<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/empenho/anulacao/DaoConEmpenhoAnulacao.class.php";

class EmpenhoAnulacao{
    
    private $idPedido = null;
    private $idEmpenho = null;
    private $nrAnulacao = null;
    private $dtAnulacao = null;
    private $vlAnulacao = null;
    private $idEmpenhoAnulacaoSituacao = null;
    private $idEmpenhoAnulacaoStatus = null;
    private $idPessoa = null;
    private $dsEmpenhoAnulacaoAnotacao = null;
    private $itens = null;
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    public function getSucesso() {
        return $this->sucesso;
    }

    public function getMsgRetorno() {
        return $this->msgRetorno;
    }
        
    public function getIdPedido() {
        return $this->idPedido;
    }

    public function getIdEmpenho() {
        return $this->idEmpenho;
    }

    public function getNrAnulacao() {
        return $this->nrAnulacao;
    }

    public function getDtAnulacao() {
        return $this->dtAnulacao;
    }

    public function getVlAnulacao() {
        return $this->vlAnulacao;
    }

    public function getIdEmpenhoAnulacaoSituacao() {
        return $this->idEmpenhoAnulacaoSituacao;
    }

    public function getIdEmpenhoAnulacaoStatus() {
        return $this->idEmpenhoAnulacaoStatus;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getDsEmpenhoAnulacaoAnotacao() {
        return $this->dsEmpenhoAnulacaoAnotacao;
    }

    public function getItens() {
        return $this->itens;
    }

    public function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
        return $this;
    }

    public function setIdEmpenho($idEmpenho) {
        $this->idEmpenho = $idEmpenho;
        return $this;
    }

    public function setNrAnulacao($nrAnulacao) {
        $this->nrAnulacao = $nrAnulacao;
        return $this;
    }

    public function setDtAnulacao($dtAnulacao) {
        $this->dtAnulacao = $dtAnulacao;
        return $this;
    }

    public function setVlAnulacao($vlAnulacao) {
        $this->vlAnulacao = $vlAnulacao;
        return $this;
    }

    public function setIdEmpenhoAnulacaoSituacao($idEmpenhoAnulacaoSituacao) {
        $this->idEmpenhoAnulacaoSituacao = $idEmpenhoAnulacaoSituacao;
        return $this;
    }

    public function setIdEmpenhoAnulacaoStatus($idEmpenhoAnulacaoStatus) {
        $this->idEmpenhoAnulacaoStatus = $idEmpenhoAnulacaoStatus;
        return $this;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
        return $this;
    }

    public function setDsEmpenhoAnulacaoAnotacao($dsEmpenhoAnulacaoAnotacao) {
        $this->dsEmpenhoAnulacaoAnotacao = $dsEmpenhoAnulacaoAnotacao;
        return $this;
    }

    public function setItens($itens) {
        $this->itens = $itens;
        return $this;
    }


    
    
    public function salvarAnulacao() {
        try {

            if (empty($this->getIdEmpenho()) || empty($this->getIdLotacao()) || empty($this->getIdDocTipoLotacao()) || empty($this->getNrLiquidacao()) || empty($this->getDtLiquidacao()) || empty($this->getVlLiquidacao())) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            /*
             * Se o tipo de solicitação for administrativo, precisa verificar se ele possui documentos disponiveis
             * e caso tenha documentos disponiveis, ele precisa no minimo usar 1
             * Se o tipo de solicitação for administrativo por licitação, é necessário ter documento fiscal
             */
            if ($this->getTipoSolicitacao() == '1' && (int) $this->getQtdDocumentosDisponiveis() > 1 && count($this->getDocumentos()) < 1) {
                return Metodos::retornoAjax("Erro", "alert", 'Selecione pelo menos um documento fiscal para efetuar a Liquidação');
            } elseif ($this->getTipoSolicitacao() == '2' && count($this->getDocumentos()) < 1) {
                return Metodos::retornoAjax("Erro", "alert", 'Selecione pelo menos um documento fiscal para efetuar a Liquidação');
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            //Retorna saldo do empenho disponivel no momento da operação
            $empenho = new FinEmpenhoModel();
            $empenho->setIdEmpenho($this->getIdEmpenho());
            $dados_empenho = $empenho->retornaDadosEmpenho($pdo);
            //Se os dados do empenho estiver vazio, retorna erro
            if (empty($dados_empenho)) {
                return Metodos::retornoAjax("Erro", "alert", 'Erro ao consultar os dados do Empenho.');
            }

            //Se for Empenho do tipo 'Ordinário' deverá ser liquidado em sua totalidade
            if ($dados_empenho['id_tipo_empenho'] == 3 && $dados_empenho['vl_empenho'] > Metodos::ConverteValorIng($this->getVlLiquidacao())) {
                return Metodos::retornoAjax("Erro", "alert", 'Este tipo de empenho deve ser liquidado em sua totalidade.');
            }

            //Retorna o total liquidado do empenho
            $empenho_total = $empenho->retornaTotalLiquidadoDoEmpenho($pdo);

            $saldo_empenho = $dados_empenho['vl_empenho'] - $empenho_total['total_liquidado'];
            $saldo_empenho = round($saldo_empenho, 4);
            //***********************************************************************************************

            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdEmpenho($this->getIdEmpenho())
                    ->setIdLiquidacaoSituacao($this->getSitCadastrado())
                    ->setIdLiquidacaoStatus(1)
                    ->setIdLotacao($this->getIdLotacao())
                    ->setIdDocTipoLotacao($this->getIdDocTipoLotacao())
                    ->setNrLiquidacao($this->getNrLiquidacao())
                    ->setDtLiquidacao($this->getDtLiquidacao())
                    ->setVlLiquidacao(Metodos::ConverteValorIng($this->getVlLiquidacao()))
                    ->setVlLiquidacaoSaldo($saldo_empenho);

            $daoConLiquidacao->insert($pdo);

            if ($daoConLiquidacao->Sucesso()) {
                $idLiquidacao = $pdo->lastInsertId('con_liquidacao_id_liquidacao_seq');
                if (!Log::SalvaLogI('con_liquidacao', $idLiquidacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar a Liquidação no LOG. Operação Cadastro.");
                }
                $this->setIdLiquidacao($idLiquidacao); //Id da Liquidação
                $this->setIdLiquidacaoSituacao($this->getSitCadastrado()); //Status da Liquidação
                //Atualiza a situação do empenho
                if (!$this->atualizaEmpenho($pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $this->mensagens);
                }

                //Atualiza a situação do pedido
                if (!$this->atualizaPedido($pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $this->mensagens);
                }

                if ($this->getAnotacoes()) {
                    //codigo abaixo salva as anotaçoes 
                    $liquidacaoAnotacao = new LiquidacaoAnotacao();
                    $liquidacaoAnotacao->setIdPessoa($this->usuario);
                    $liquidacaoAnotacao->setIdLiquidacao($this->idLiquidacao);
                    $liquidacaoAnotacao->setDsLiquidacaoAnotacao($this->anotacoes);
                    if (!$liquidacaoAnotacao->salvar($pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", $liquidacaoAnotacao->getMsgErros());
                    }
                }

                //Se cadastro da liquidação possuir documentos fiscais, 
                //verifica se os mesmos encontram-se na situação de 'A Liquidar'
                if ($this->getDocumentos()) {
                    if ($this->verificaDocumentosDiferenteDeALiquidar($pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Há documentos com situação diferente de 'A Liquidar'.");
                    }
                }

                //Salva os Documentos Fiscais na Liquidação
                if (!$this->salvarDocumentosLiquidacao($pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $this->getMensagens());
                }

                //Salva Historico da Liquidacao
                if (!$this->salvarLiquidacaoHistorico($pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $this->getMensagens());
                }

                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                return Metodos::retornoAjax("Erro", "alert", $daoConLiquidacao->getMsgRetorno());
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", $exc->getMessage());
        }
    }
    
    
    
    
    
    
}

