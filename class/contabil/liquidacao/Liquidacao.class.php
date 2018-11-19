<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/liquidacao/DaoConLiquidacao.class.php";

class Liquidacao {

    private $idLiquidacao = null;
    private $nrLiquidacao = null;
    private $idEmpenho = null;
    private $idLiquidacaoSituacao = null;
    private $idLotacao = null;
    private $idDocTipoLotacao = null;
    private $dtLiquidacao = null;
    private $vlLiquidacao = null;
    private $vlLiquidacaoSaldo = null;
    private $dsLiquidacao = null;
    private $stAtivo = null;
    private $documentos = null;
    private $usuario = null;
    private $mensagens = null;
    private $sucesso = null;
    private $motivoCancelamento = null;
    private $anotacoes = null;
    private $tipoSolicitacao = null;
    private $qtdDocumentosDisponiveis = null;
    private $sitCadastrado = 1;
    private $sitPagoParcial = 2;
    private $sitPago = 3;
    private $sitCancelado = 4;

    function getTipoSolicitacao() {
        return $this->tipoSolicitacao;
    }

    function getQtdDocumentosDisponiveis() {
        return $this->qtdDocumentosDisponiveis;
    }

    function setTipoSolicitacao($tipoSolicitacao) {
        $this->tipoSolicitacao = $tipoSolicitacao;
        return $this;
    }

    function setQtdDocumentosDisponiveis($qtdDocumentosDisponiveis) {
        $this->qtdDocumentosDisponiveis = $qtdDocumentosDisponiveis;
        return $this;
    }

    function getVlLiquidacaoSaldo() {
        return $this->vlLiquidacaoSaldo;
    }

    function setVlLiquidacaoSaldo($vlLiquidacaoSaldo) {
        $this->vlLiquidacaoSaldo = $vlLiquidacaoSaldo;
        return $this;
    }

    function getMotivoCancelamento() {
        return $this->motivoCancelamento;
    }

    function setMotivoCancelamento($motivoCancelamento) {
        $this->motivoCancelamento = $motivoCancelamento;
        return $this;
    }

    function getSitCadastrado() {
        return $this->sitCadastrado;
    }

    function getSitPagoParcial() {
        return $this->sitPagoParcial;
    }

    function getSitPago() {
        return $this->sitPago;
    }

    function getSitCancelado() {
        return $this->sitCancelado;
    }

    function getMensagens() {
        return $this->mensagens;
    }

    function getSucesso() {
        return $this->sucesso;
    }

    function getAnotacoes() {
        return $this->anotacoes;
    }

    function setAnotacoes($anotacoes) {
        $this->anotacoes = $anotacoes;
        return $this;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
        return $this;
    }

    function getIdLiquidacao() {
        return $this->idLiquidacao;
    }

    function setIdLiquidacao($idLiquidacao) {
        $this->idLiquidacao = $idLiquidacao;
        return $this;
    }

    function getNrLiquidacao() {
        return $this->nrLiquidacao;
    }

    function getIdEmpenho() {
        return $this->idEmpenho;
    }

    function getIdLiquidacaoSituacao() {
        return $this->idLiquidacaoSituacao;
    }

    function getIdLotacao() {
        return $this->idLotacao;
    }

    function getIdDocTipoLotacao() {
        return $this->idDocTipoLotacao;
    }

    function getDtLiquidacao() {
        return $this->dtLiquidacao;
    }

    function getVlLiquidacao() {
        return $this->vlLiquidacao;
    }

    function getDsLiquidacao() {
        return $this->dsLiquidacao;
    }

    function getStAtivo() {
        return $this->stAtivo;
    }

    function getDocumentos() {
        return $this->documentos;
    }

    function setNrLiquidacao($nrLiquidacao) {
        $this->nrLiquidacao = $nrLiquidacao;
        return $this;
    }

    function setIdEmpenho($idEmpenho) {
        $this->idEmpenho = $idEmpenho;
        return $this;
    }

    function setIdLiquidacaoSituacao($idLiquidacaoSituacao) {
        $this->idLiquidacaoSituacao = $idLiquidacaoSituacao;
        return $this;
    }

    function setIdLotacao($idLotacao) {
        $this->idLotacao = $idLotacao;
        return $this;
    }

    function setIdDocTipoLotacao($idDocTipoLotacao) {
        $this->idDocTipoLotacao = $idDocTipoLotacao;
        return $this;
    }

    function setDtLiquidacao($dtLiquidacao) {
        $this->dtLiquidacao = $dtLiquidacao;
        return $this;
    }

    function setVlLiquidacao($vlLiquidacao) {
        $this->vlLiquidacao = $vlLiquidacao;
        return $this;
    }

    function setDsLiquidacao($dsLiquidacao) {
        $this->dsLiquidacao = $dsLiquidacao;
        return $this;
    }

    function setStAtivo($stAtivo) {
        $this->stAtivo = $stAtivo;
        return $this;
    }

    function setDocumentos($documento) {
        $this->documentos = $documento;
        return $this;
    }

    public function retornaDadosLiquidacao() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdLiquidacao($this->getIdLiquidacao());
            $daoConLiquidacao->retornaDadosLiquidacao($pdo);
            return $daoConLiquidacao->getMsgRetorno();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function retornaHistorico() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoConLiquidacaoHistorico = new DaoConLiquidacaoHistorico();
            $daoConLiquidacaoHistorico->setIdLiquidacao($this->getIdLiquidacao());

            $daoConLiquidacaoHistorico->historico($pdo);

            if ($daoConLiquidacaoHistorico->Sucesso()) {
                foreach ($daoConLiquidacaoHistorico->getMsgRetorno() as $linha) {
                    $retorno .= $linha['historico'] . "\n";
                }
            } else {
                $retorno = $daoConLiquidacaoHistorico->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }

    public function montaTabelaDocumentosLiquidacao(bool $edita = true) {
        try {
            $tabela = '';

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdLiquidacao($this->getIdLiquidacao());
            $daoConLiquidacao->retornaDocumentosPorLiquidacao($pdo);

            if ($daoConLiquidacao->Sucesso()) {
                foreach ($daoConLiquidacao->getMsgRetorno() as $linha) {
                    $tabela .= "<tr data-id=" . $linha['id_documento_fiscal'] . " data-objeto='" . json_encode($linha) . "' class='documentoFiscal'>"
                            . "<td class='text-center'>" . $linha['nr_documento_fiscal'] . "</td>"
                            . "<td class='text-center'>" . $linha['nm_tipo_documento'] . "</td>"
                            . "<td class='text-center'>" . $linha['competencia'] . "</td>"
                            . "<td class='text-center'>" . $linha['dt_emissao'] . "</td>"
                            . "<td class='text-center'>" . $linha['dt_atesto'] . "</td>"
                            . "<td class='text-center'>" . $linha['vl_documento'] . "</td>"
                            . "<td class='text-center'>" . $linha['vl_documento'] . "</td>"
                            . "<td class='text-center'>" . $linha['nm_situacao'] . "</td>"
                            . "<td class='text-center'>"
                            . "<button type='button' title='Ver Documento Fiscal' class='ver-documento' value=" . $linha['id_documento_fiscal'] . ">"
                            . "<i class='fa fa-file-text-o text-info' aria-hidden='true'></i>"
                            . "</button>";
                    if ($edita) {
                        $tabela .= "<button type='button' title='Remover Documento Fiscal' class='remover-documento'>"
                                . "<i class='fa fa-trash text-danger' aria-hidden='true'></i>"
                                . "</button>";
                    }

                    $tabela .= "</td></tr>";
                }
            }
            return $tabela;
        } catch (Exception $exc) {
            return $ex->getMessage();
        }
    }

    public function retornaOptionsDocsEmpenho() {
        try {
            $opcoes = "<option value=0>Selecione um Documento Fiscal</option>";

            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdEmpenho($this->getIdEmpenho());
            if ($this->getIdLiquidacao()) {
                $daoConLiquidacao->setIdLiquidacao($this->getIdLiquidacao());
            } else {
                $daoConLiquidacao->setIdLiquidacao(0);
            }
            $daoConLiquidacao->retornaDocumentosPorEmpenho($pdo);

            if ($daoConLiquidacao->Sucesso()) {
                foreach ($daoConLiquidacao->getMsgRetorno() as $linha) {
                    $opcoes .= "<option data-objeto='" . json_encode($linha) . "' value=" . $linha['id_documento_fiscal'] . ">" . $linha['nr_documento_fiscal'] . ' - ' . $linha['competencia'] . "</option>";
                }
            }
            return $opcoes;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function retornaOptionsDocsPagamento() {
        try {
            $opcoes = "<option value=0>Selecione um Documento Fiscal</option>";

            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoConLiquidacao = new DaoConLiquidacao();

            if ($this->getIdLiquidacao()) {
                $daoConLiquidacao->setIdLiquidacao($this->getIdLiquidacao());
            } else {
                $daoConLiquidacao->setIdLiquidacao(0);
            }

            $daoConLiquidacao->retornaDocumentosPorLiquidacaoPagamento($pdo);

            if ($daoConLiquidacao->Sucesso()) {
                foreach ($daoConLiquidacao->getMsgRetorno() as $linha) {
                    $opcoes .= "<option data-objeto='" . json_encode($linha) . "' value=" . $linha['id_documento_fiscal'] . ">" . $linha['nr_documento_fiscal'] . ' - ' . $linha['competencia'] . "</option>";
                }
            }

            return $opcoes;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * 
     * @param type $idsDocFiscaisParaVerificar
     * @param PDO $pdo
     * @return type
     */
    function verificaDocumentosDiferenteDeALiquidar($idsDocFiscaisParaVerificar, PDO $pdo = null) {
        $this->sucesso = false;
        try {
            if (!empty($pdo)) {
                $daoConLiquidacao = new DaoConLiquidacao();
                $daoConLiquidacao->setIdLiquidacao($this->getIdLiquidacao());

                $arrayAux = array();

                if ($idsDocFiscaisParaVerificar) {
                    foreach ($idsDocFiscaisParaVerificar as $documento) {
                        $arrayAux[] = $documento['id_documento_fiscal'];
                    }
                }

                $filtroDocumentos = implode(', ', $arrayAux);

                $daoConLiquidacao->retornaDocumentosFiscaisDiferentesDeALiquidar($pdo, $filtroDocumentos);

                if ($daoConLiquidacao->Sucesso()) {
                    $this->sucesso = true;
                } else {
                    $this->mensagens = $daoConLiquidacao->getMsgRetorno();
                }
                return $this->sucesso;
            } else {
                $this->mensagens = "Sem conexão com o banco de dados";
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->mensagens = $exc->getMessage();
        }
    }

    public function salvarLiquidacao() {
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
                    $idsDocFiscaisParaVerificar = $this->getDocumentos();
                    if ($this->verificaDocumentosDiferenteDeALiquidar($idsDocFiscaisParaVerificar, $pdo)) {
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

    function salvarDocumentosLiquidacao(PDO $pdo = null) {
        try {
            $this->sucesso = true;

            if (!empty($pdo)) {
                if ($this->getDocumentos()) {
                    $liquidacaoDoc = new LiquidacaoDoc();

                    $liquidacaoDoc->setIdLiquidacao($this->getIdLiquidacao());

                    foreach ($this->getDocumentos() as $documento) {
                        $liquidacaoDoc->setIdDocumentoFiscal($documento['id_documento_fiscal']);
                        $liquidacaoDoc->setVlLiquidacaoDoc($documento['vl_liquidacao_doc']);
                        $liquidacaoDoc->setVlLiquidacaoDocSaldo($documento['vl_liquidacao_doc_saldo']);
                        $liquidacaoDoc->salvarLiquidacaoDoc($pdo);

                        if (!$liquidacaoDoc->getSucesso()) { //Retorna o erro se der problema ao salvar o documento fiscal
                            $this->sucesso = false;
                            $this->mensagens = $liquidacaoDoc->getMensagens();
                            return false;
                            break;
                        }
                    }
                }
            } else {
                $this->mensagens = "Sem conexão com o banco de dados";
                $this->sucesso = false;
            }

            return $this->sucesso;
        } catch (Exception $exc) {
            //Se der algum erro, registra o erro no objeto
            $this->sucesso = false;
            $this->mensagens = $exc->getMessage();
        }
    }

    function salvarLiquidacaoHistorico(PDO $pdo = null) {
        try {
            $this->sucesso = true;
            if (!empty($pdo)) {
                $liquidacaoHistorico = new LiquidacaoHistorico();
                $liquidacaoHistorico->setIdLotacao($this->getIdLotacao())
                        ->setIdLiquidacao($this->getIdLiquidacao())
                        ->setIdPessoa($this->getUsuario())
                        ->setIdDocTipoLotacao($this->getIdDocTipoLotacao())
                        ->setIdLiquidacaoSituacao($this->getIdLiquidacaoSituacao());

                $liquidacaoHistorico->salvarLiquidacaoHistorico($pdo);

                if (!$liquidacaoHistorico->getSucesso()) {
                    $this->sucesso = false;
                    $this->mensagens = $liquidacaoHistorico->getMensagens();
                    return false;
                }

                return $this->sucesso;
            } else {
                $this->mensagens = "Sem conexão com o banco de dados";
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            //Se der algum erro, registra o erro no objeto
            $this->sucesso = false;
            $this->mensagens = $exc->getMessage();
        }
    }

    function alterarLiquidacao() {
        try {

            if (empty($this->getIdLiquidacao()) || empty($this->getNrLiquidacao()) || empty($this->getDtLiquidacao()) || empty($this->getNrLiquidacao()) || empty($this->getVlLiquidacao()) || empty($this->getVlLiquidacao())) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdLiquidacao($this->getIdLiquidacao())
                    ->setNrLiquidacao($this->getNrLiquidacao())
                    ->setDtLiquidacao($this->getDtLiquidacao())
                    ->setVlLiquidacao(Metodos::ConverteValorIng($this->getVlLiquidacao()))
                    ->setDsLiquidacao($this->getDsLiquidacao());

            $daoConLiquidacao->retorna($pdo);

            if (!$daoConLiquidacao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoConLiquidacao->getMsgRetorno());
            }

            $reg_antigo = $daoConLiquidacao->getMsgRetorno();

            $daoConLiquidacao->retornaSaldoEmpenhoEdicaoLiquidacao($pdo);
            if (!$daoConLiquidacao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "console", $daoConLiquidacao->getMsgRetorno());
            }
            $totais = $daoConLiquidacao->getMsgRetorno();

            $saldo_empenho = $totais['vl_empenho'] - $totais['vl_utilizado'];
            $saldo_empenho = round($saldo_empenho, 4);

            //Se o tipo de empenho for 'Ordinário' o valor da liquidação deve ser igual ao valor do empenho
            if ($totais['id_tipo_empenho'] == 3 && $totais['vl_empenho'] > Metodos::ConverteValorIng($this->getVlLiquidacao())) {
                return Metodos::retornoAjax("Erro", "alert", 'Este tipo de empenho deve ser liquidado em sua totalidade.');
            }

            //seta saldo da atualização
            $daoConLiquidacao->setVlLiquidacaoSaldo($saldo_empenho);

            //Atualiza a Liquidação
            $daoConLiquidacao->update($pdo);


            if ($daoConLiquidacao->Sucesso()) {


                if (!Log::SalvaLogU('con_liquidacao', $daoConLiquidacao->getIdLiquidacao(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }

                $this->setIdEmpenho($reg_antigo['id_empenho']); //Id do Empenho
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

                if ($this->getDocumentos()) {                                                                                                                     
                    //Atualiza os Documentos Fiscais na Liquidação
                    if (!$this->atualizaDocumentosLiquidacao($pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", $this->getMensagens());
                    }
                }
                               
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_EDICAO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $this->getMensagens());
            }
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", $daoConLiquidacao->getMsgRetorno());
        }
    }

    function atualizaDocumentosLiquidacao(PDO $pdo = null) {
        try {
            $this->sucesso = true;

            if (!empty($pdo)) {

                //Busca os Documentos Fiscais associado a Liquidacao para saber qual foi removido ou inserido
                $liquidacaoDoc = new LiquidacaoDoc();
                $liquidacaoDoc->setIdLiquidacao($this->getIdLiquidacao());

                $liquidacaoDoc->retornaDocumentosPorLiquidacao($pdo);

                if (!$liquidacaoDoc->getSucesso()) {
                    $this->sucesso = false;
                    $this->mensagens = $liquidacaoDoc->getMensagens();
                    return false;
                }

                $documentosAntigos = $liquidacaoDoc->getMensagens(); //Retorna o resultado da consulta


                $arrayInsert = array();
                $arrayRemove = array();
                $arrayUpdate = array();

                $arrayAux = array();
                foreach ($documentosAntigos as $key => $value) {
                    $arrayAux[$value['id_liquidacao_doc']] = $value['id_documento_fiscal'];
                }

                $arrayAux2 = array();
                foreach ($this->getDocumentos() as $key => $value) {
                    $arrayAux2[] = $value['id_documento_fiscal'];
                }

                $arrayInsert = array_diff($arrayAux2, $arrayAux);
                $arrayRemove = array_diff($arrayAux, $arrayAux2);
                $arrayUpdate = array_intersect($arrayAux2, $arrayAux);


                if ($this->getDocumentos()) {                                       
                    /*
                     * Verifica se o Documento Fiscal que está sendo incluído está na diferente 
                     * da situação a Liquidar
                     */                                        
                    if(!empty($arrayInsert)){
                        $idsDocFiscaisParaVerificar = array();
                        foreach ($arrayInsert as $key => $value) {
                            $kI = array_search($value, array_column($this->getDocumentos(), "id_documento_fiscal"));
                            if ($kI === false) {
                                continue;
                            }
                            $idsDocFiscaisParaVerificar[] = $this->getDocumentos()[$kI];                                                
                        }
                        
                        if ($this->verificaDocumentosDiferenteDeALiquidar($idsDocFiscaisParaVerificar, $pdo)) {                        
                            $this->sucesso = false;
                            $this->mensagens = "Há documentos com situação diferente de 'A Liquidar'.";
                            return false;                            
                        }                                                                        
                    }
                                      
                    foreach ($this->getDocumentos() as $documento) {
                        $liquidacaoDoc->setIdDocumentoFiscal($documento['id_documento_fiscal']);
                        $liquidacaoDoc->setVlLiquidacaoDoc($documento['vl_liquidacao_doc']);
                        $liquidacaoDoc->setVlLiquidacaoDocSaldo($documento['vl_liquidacao_doc_saldo']);

                        //DOCMENTOS QUE SERÃO INSERIDOS
                        if (in_array($documento['id_documento_fiscal'], $arrayInsert)) {
                            $liquidacaoDoc->salvarLiquidacaoDoc($pdo);
                        }

                        //DOCUMENTOS QUE SERÃO ATUALIZADOS
                        if (in_array($documento['id_documento_fiscal'], $arrayUpdate)) {
                            $liquidacaoDoc->setIdLiquidacaoDoc($documento['id_liquidacao_doc']);
                            $liquidacaoDoc->atualizarLiquidacaoDoc($pdo);
                        }
                    }
                }

                //DOCUMENTOS QUE FORAM REMOVIDOS
                if ($arrayRemove) {
                    foreach ($arrayRemove as $indice => $documento) {
                        $liquidacaoDoc->setIdDocumentoFiscal($documento);
                        $liquidacaoDoc->setIdLiquidacaoDoc($indice);
                        $liquidacaoDoc->removerLiquidacaoDoc($pdo);

                        if (!$liquidacaoDoc->getSucesso()) { //Retorna o erro se der problema ao salvar o documento fiscal
                            $this->sucesso = false;
                            $this->mensagens = $liquidacaoDoc->getMensagens();
                            return false;
                        }
                    }
                }
            } else {
                $this->mensagens = "Sem conexão com o banco de dados";
                $this->sucesso = false;
            }

            return $this->sucesso;
        } catch (Exception $exc) {
            //Se der algum erro, registra o erro no objeto
            $this->sucesso = false;
            $this->mensagens = $exc->getMessage();
        }
    }

    function cancelarLiquidacao() {
        try {
            if (empty($this->getIdLiquidacao()) || empty($this->getMotivoCancelamento())) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdLiquidacao($this->getIdLiquidacao())
                    ->setIdLiquidacaoSituacao($this->getSitCancelado());

            $daoConLiquidacao->retorna($pdo);
            if (!$daoConLiquidacao->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Erro ao verificar os dados desta Liquidação");
            }

            $dadosLiquidacao = $daoConLiquidacao->getMsgRetorno();

            $idLiquidacao = $this->getIdLiquidacao();
            if (!Log::SalvaLogU('con_liquidacao', $idLiquidacao, $dadosLiquidacao, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $daoConLiquidacao->mudaSituacao($pdo);
            if (!$daoConLiquidacao->Sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $daoConLiquidacao->getMsgRetorno());
            }

            //Seta as informações complementares para salvar no histórico
            $this->setIdLiquidacaoSituacao($this->getSitCancelado())
                    ->setIdLotacao($dadosLiquidacao['id_lotacao'])
                    ->setIdDocTipoLotacao($dadosLiquidacao['id_doc_tipo_lotacao']);


            //Busca os Documentos Fiscais associado a Liquidacao para voltar o status de 'A Liquidar'
            $liquidacaoDoc = new LiquidacaoDoc();
            $liquidacaoDoc->setIdLiquidacao($this->getIdLiquidacao());

            $liquidacaoDoc->retornaDocumentosPorLiquidacao($pdo);

            if (!$liquidacaoDoc->getSucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Erro ao verificar os Documentos Fiscais desta Liquidação");
            }

            $documentos = $liquidacaoDoc->getMensagens(); //Retorna o resultado da consulta

            if ($documentos) {
                $gdof = new FinDocumentoFiscal();
                foreach ($documentos as $doc) {
                    $gdof->setIdDocumentoFiscal($doc['id_documento_fiscal'])
                            ->setIdDocumentoSituacao($gdof->getDocSitALiquidar());
                    if (!$gdof->atualizaSituacaoDocumentoGDOF($pdo)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", $gdof->getMsgErros());
                    }
                }
            }

            //Salvar no histórico o cancelamento
            if (!$this->salvarLiquidacaoHistorico($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao verificar os Documentos Fiscais desta Liquidação");
            };

            //Armazena o ID do empenho no objeto para poder atualizar a situação do Empenho
            $this->idEmpenho = $dadosLiquidacao['id_empenho'];
            //Atualiza a situação do empenho
            if (!$this->atualizaEmpenho($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao atualizar a situação do Empenho: " . $this->mensagens);
            }

            //Atualiza a situação do pedido
            if (!$this->atualizaPedido($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao atualizar a situação do Pedido: " . $this->mensagens);
            }

            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Liquidação cancelada com sucesso.");
        } catch (Exception $exc) {
            //Se der algum erro, registra o erro no objeto
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function pesquisaLiquidacaoParaPagamento($pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            //removendo barra do numero do pagamento
            $this->nrLiquidacao = str_replace("/", "", $this->nrLiquidacao);

            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setNrLiquidacao($this->nrLiquidacao);
            $daoConLiquidacao->retornaLiquidacaoPorNumeroPamento($pdo);
            $retorno = '';

            if ($daoConLiquidacao->Sucesso()) {
                $dados = $daoConLiquidacao->getMsgRetorno();
                $retorno .= '<tr class="selecionaItem" pedido="' . $dados["id_pedido"] . '" nrpedido = "' . $dados["nr_pedido"] . '" 
                                  idEmpenho ="' . $dados["id_empenho"] . '" idLiquidacao="' . $dados["id_liquidacao"] . '"  
                        style="cursor:pointer;">
                <td>' . $dados["nr_liquidacao"] . '</td>
                <td>' . $dados["nr_pedido"] . '</td>
                <td>' . $dados["dt_liquidacao"] . '</td>
                <td>' . $dados["vl_liquidacao"] . '</td>    
                <td>' . $dados["saldo"] . '</td>        
     
                </tr>';
            }
            if (empty($retorno)) {
                return "Nenhum liquidacao encontrada";
            }
            return $retorno;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->mensagens = $ex->getMessage();
            return;
        }
    }

    public function retornaLiquidacaoParaPagamento($pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $dadosContrato = '';
            $daoConLiquidacao = new DaoConLiquidacao();

            //removendo barra do numero da liquidacao
            $this->nrLiquidacao = str_replace("/", "", $this->nrLiquidacao);

            $daoConLiquidacao->setNrLiquidacao($this->nrLiquidacao);
            $daoConLiquidacao->retornaLiquidacaoPorNumeroPamento($pdo);

            if ($daoConLiquidacao->sucesso()) {
                $campos = $daoConLiquidacao->getMsgRetorno();

                $dadosContrato .= '<div class="panel-group" id="accordionFor" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingFor">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordionFor" href="#collapseFor" 
                                                        aria-expanded="true" aria-controls="collapseFor" >
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados da Liquidação: </b><span style="color:#758697"> Nº ' . $campos["nr_liquidacao"] . '</span> 
                                                    </a>
                                                </h4>
                                            </div>
                                        
                                            <div id="collapseFor" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFor" aria-expanded="true">
                                                <div class="panel-body">
                                                <input id="id_liquidacao" type="hidden" value="' . $campos['id_liquidacao'] . '" />
                                                <input id="saldoLiquidacao" type="hidden" value="' . $campos['saldo'] . '" /> 
                                                <input id="id_liquidacao_situacao" type="hidden" value="' . $campos['id_liquidacao_situacao'] . '" />    
                                                <table id="tabelaItens" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Data da Liquidação</th>
                                                            <th class="text-center">Valor da Liquidação</th>
                                                            <th class="text-center">Saldo da liquidação</th>
                                                            <th class="text-center">Situação</th>
                                                            <th class="text-center">Ação</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center">' . $campos["dt_liquidacao"] . '</td>
                                                            <td class="text-center">' . $campos["vl_liquidacao"] . '</td>
                                                            <td class="text-center">' . $campos["saldo"] . '</td>
                                                            <td class="text-center">' . $campos["situacao"] . '</td>
                                                            <td class="text-center">
                                                                <button type="button" title="Ver Liquidação" class="ver-liquidacao" value="' . $campos['id_liquidacao'] . '">
                                                                <i class="fa fa-file-text-o text-info" aria-hidden="true"></i>
                                                                </button>
                                                            </td>    
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                         </div>
                                    </div>';
                return $dadosContrato;
            }
            return $dadosContrato;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }
    }

    public function retornaEmpenhoLiquidacao(PDO $pdo = null, int $opcao = 1 /* 1 - Visualização; 2 - Edição */) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosEmpenho = '';
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdLiquidacao($this->idLiquidacao);
            $daoConLiquidacao->retornaEmpenhoLiquidacao($pdo);

            if ($daoConLiquidacao->sucesso()) {

                $campos = $daoConLiquidacao->getMsgRetorno();

                $saldo = '';
                if ($opcao == 1) {
                    $saldo = $campos['saldo_visualizacao'];
                } else {
                    $saldo = $campos['saldo_edicao'];
                }


                $dadosEmpenho .= '<div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingThree">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree" 
                                                        aria-expanded="false" aria-controls="collapseThree" class="collapsed">
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados do Empenho: </b><span style="color:#758697"> Nº ' . $campos["nr_empenho"] . '</span> 
                                                    </a>
                                                </h4>
                                            </div>
                                        
                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false">
                                                <div class="panel-body">
                                                    <input id="id_empenho" type="hidden" value="' . $campos['id_empenho'] . '" />
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Data do Empenho:</b></div>
                                                        <div class="col-sm-3">' . $campos["dataempenho"] . '</div>
                                                        <div class="col-sm-7"></div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Tipo de Empenho:</b></div>
                                                        <div class="col-sm-3">' . $campos["nm_tipo_empenho"] . '</div>
                                                        <div class="col-sm-7"></div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Valor do Empenho:</b></div>
                                                        <div class="col-sm-3">' . Metodos::ConverteValorBr($campos["vl_empenho"], 4) . '</div>
                                                        <div class="col-sm-7"></div>    
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Saldo do Empenho a Liquidar:</b></div>
                                                        <div class="col-sm-3">' . Metodos::ConverteValorBr($saldo, 4) . '</div>
                                                        <div class="col-sm-7"></div>    
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                    </div>';
                return $dadosEmpenho;
            }
            return $dadosEmpenho;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function retornaPedidoLiquidacao(PDO $pdo = null) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dadosPedido = '';
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdLiquidacao($this->idLiquidacao);
            $daoConLiquidacao->retornaPedidoLiquidacao($pdo);

            if ($daoConLiquidacao->sucesso()) {

                $campos = $daoConLiquidacao->getMsgRetorno();

                $dadosPedido .= '<div class="panel-group" id="accordionTwo" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingTwo">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordionTwo" href="#collapseTwo" 
                                                        aria-expanded="false" aria-controls="collapseTwo" class="collapsed">
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados do Pedido de Necessidade: </b><span style="color:#758697"> Nº ' . $campos["nr_pedido"] . '</span> 
                                                    </a>
                                                </h4>
                                            </div>
                                        
                                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false">
                                                <div class="panel-body">
                                                    <input type="hidden" id="id_pedido" value=' . $campos['id_pedido'] . ' data-tipo-solicitacao=' . $campos['id_tipo_solicitacao'] . ' />
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Descrição:</b></div>
                                                        <div class="col-sm-10">' . $campos["ds_pedido"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Fonte:</b></div>
                                                        <div class="col-sm-10">' . $campos["nr_fonte"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>' . STR_FUNCIONAL_PROGRAMATICA . ':</b></div>
                                                        <div class="col-sm-10">' . $campos["cd_programa_trabalho"] . '- ' . $campos["ds_programa_trabalho"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Despesa:</b></div>
                                                        <div class="col-sm-10">' . $campos["cd_despesa"] . '- ' . $campos["ds_despesa"] . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Valor do Pedido:</b></div>
                                                        <div class="col-sm-10">' . Metodos::ConverteValorBr($campos["vl_pedido"], 4) . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Saldo do Pedido de Necessidade a Liquidar:</b></div>
                                                        <div class="col-sm-10">' . Metodos::ConverteValorBr($campos["saldo_visualizacao"], 4) . '</div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-2"><b>Tipo da Solicitação:</b></div>
                                                        <div class="col-sm-10">' . $campos["nm_tipo_solicitacao"] . '</div>
                                                    </div>
                                                </div>
                                            </div>
                                         </div>
                                    </div>';
                return $dadosPedido;
            }
            return $dadosPedido;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }
    }

    private function atualizaEmpenho(PDO $pdo = null) {
        try {
            //Trecho que irá atualizar a situação do empenho
            $empenho = new FinEmpenhoModel();
            $empenho->setIdEmpenho($this->getIdEmpenho());
            $dados_empenho = $empenho->retornaDadosEmpenho($pdo);

            //Se os dados do empenho estiver vazio, retorna erro
            if (empty($dados_empenho)) {
                $this->mensagens = 'Não foi possível localizar os dados do Empenho.';
                return false;
            }

            //Retorna o total liquidado do empenho
            $total_liquidado = $empenho->retornaTotalLiquidadoDoEmpenho($pdo);
            //Se os dados do empenho estiver vazio, retorna erro
            if (empty($total_liquidado)) {
                $this->mensagens = 'Erro ao verificar o total liquidado para este empenho.';
                return false;
            }

            $valor_empenho = $dados_empenho['vl_empenho'];
            $valor_liquidado = $total_liquidado['total_liquidado'];
            $valor_empenho = Metodos::ConverteValorIng($valor_empenho);

            if ($valor_liquidado > $valor_empenho) { //Se o total liquidado for superior ao valor do empenho, retorna erro
                $this->mensagens = 'O total liquidado deste empenho ultrapassou o valor do empenho.';
                return false;
            }

            $empenho->atualizaStatusSituacaoOficialEmpenho($pdo);
            if ($empenho->sucesso()) {
                return true;
            } else {
                $this->mensagens = $empenho->getMsgRetorno();
                return false;
            }
        } catch (Exception $exc) {
            //Se der algum erro, registra o erro no objeto
            $this->sucesso = false;
            $this->mensagens = $exc->getMessage();
        }
    }

    private function atualizaPedido(PDO $pdo = null) {
        try {
            //Trecho que irá atualizar a situação do empenho
            $empenho = new FinEmpenhoModel();
            $empenho->setIdEmpenho($this->getIdEmpenho());
            $dados_empenho = $empenho->retornaDadosEmpenho($pdo);

            //Se os dados do empenho estiver vazio, retorna erro
            if (empty($dados_empenho)) {
                $this->mensagens = 'Não foi possível localizar os dados do Empenho.';
                return false;
            }

            //informações do pedido para possíveis alterações no mesmo
            $pedido = new Pedido();
            $pedido->setIdPedido($dados_empenho['id_pedido']);
            $dados_pedido = $pedido->retornaDadosPedido();

            //Se os dados do pedido estiver vazio, retorna erro
            if (empty($dados_pedido)) {
                $this->mensagens = 'Não foi possível localizar os dados do Pedido.';
                return false;
            }

            //Retorna os totais do pedido
            $totais_pedido = $pedido->retornaTotaisDoPedido($pdo);
            $valor_pedido = $totais_pedido['valor_pedido'];
            $valor_liquidado = $totais_pedido['valor_liquidado'];

            //Se o total liquidado for superior ao valor do empenho, retorna erro
            if ($valor_liquidado > $valor_pedido) {
                $this->mensagens = 'O total liquidado ultrapassou o valor do pedido. valor pedido: ' . $valor_pedido . ' valor liquidado: ' . $valor_liquidado;
                return false;
            }

            $pedido->atualizaStatusSituacaoOficialPedido($pdo);
            if ($pedido->sucesso()) {
                return true;
            } else {
                $this->mensagens = $pedido->getMsgErros();
                return false;
            }
        } catch (Exception $exc) {
            //Se der algum erro, registra o erro no objeto
            $this->sucesso = false;
            $this->mensagens = $exc->getMessage();
        }
    }

}
