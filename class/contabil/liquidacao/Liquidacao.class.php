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
    private $dsLiquidacao = null;
    private $stAtivo = null;
    
    private $documentos = null;
    
    private $usuario = null;
    
    private $mensagens = null;
    private $sucesso = null;
    
    function getMensagens() {
        return $this->mensagens;
    }

    function getSucesso() {
        return $this->sucesso;
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

    
    public function retornaOptionsDocsEmpenho(PDO $pdo = null){
        try {
            $opcoes = "<option value=0>Selecione um Documento Fiscal</option>";
            
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdEmpenho($this->getIdEmpenho());
            $daoConLiquidacao->retornaDocumentosPorEmpenho($pdo);
            
            if ($daoConLiquidacao->Sucesso()) {
                foreach ($daoConLiquidacao->getMsgRetorno() as $linha) {
                    $opcoes .= "<option data-objeto='". json_encode($linha)."' value=".$linha['id_documento_fiscal'].">".$linha['nr_documento_fiscal']. ' - ' .$linha['competencia']."</option>";
                }
            }
            return $opcoes;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    public function salvarLiquidacao(){
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            $daoConLiquidacao = new DaoConLiquidacao();
            $daoConLiquidacao->setIdEmpenho($this->getIdEmpenho())
                             ->setIdLiquidacaoSituacao(1)
                             ->setIdLotacao($this->getIdLotacao())
                             ->setIdDocTipoLotacao($this->getIdDocTipoLotacao())
                             ->setNrLiquidacao($this->getNrLiquidacao())
                             ->setDtLiquidacao($this->getDtLiquidacao())
                             ->setVlLiquidacao(Metodos::ConverteValorIng($this->getVlLiquidacao()))
                             ->setDsLiquidacao($this->getDsLiquidacao());
            
            $daoConLiquidacao->insert($pdo);
            
            if ($daoConLiquidacao->Sucesso()) {
                $idLiquidacao = $pdo->lastInsertId('con_liquidacao_id_liquidacao_seq');
                if (!Log::SalvaLogI('con_liquidacao', $idLiquidacao, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Erro ao Salvar a Liquidação no LOG. Operação Cadastro.");
                }
                $this->setIdLiquidacao($idLiquidacao);
                
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
    
    function salvarDocumentosLiquidacao(PDO $pdo = null){
        try {
            $this->sucesso = true;
            
            if (!empty($pdo)) {
                if ($this->getDocumentos()) {
                    $liquidacaoDoc = new LiquidacaoDoc();

                    $liquidacaoDoc->setIdLiquidacao($this->getIdLiquidacao());

                    foreach ($this->getDocumentos() as $indice => $documento) {
                        $liquidacaoDoc->setIdDocumentoFiscal($documento[$indice]);
                        $liquidacaoDoc->salvarLiquidacaoDoc($pdo);

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
    
    function salvarLiquidacaoHistorico(PDO $pdo = null){
        try {
            $this->sucesso = true;
            if (!empty($pdo)) {
                $liquidacaoHistorico = new LiquidacaoHistorico();
                $liquidacaoHistorico->setIdLotacao($this->getIdLotacao())
                                    ->setIdPessoa($this->getUsuario())
                                    ->setIdDocTipoLotacao($this->getIdDocTipoLotacao())
                                    ->setIdLiquidacaoSituacao($this->getIdLiquidacaoSituacao())
                                    ->setDsLiquidacao($this->getDsLiquidacao());
                
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
    
    function alterarLiquidacao(){
        try{
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
            
            //Atualiza a Liquidação
            $daoConLiquidacao->update($pdo);
            
            if ($daoConLiquidacao->Sucesso()) {
                if (!Log::SalvaLogU('con_liquidacao', $daoConLiquidacao->getIdLiquidacao(), $reg_antigo, $pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", STR_ERROR);
                }
                
                //Atualiza os Documentos Fiscais na Liquidação
                if (!$this->atualizaDocumentosLiquidacao($pdo)) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $this->getMensagens());
                }
                
            } else {
                
            }
            
        } catch (Exception $exc) {
            return Metodos::retornoAjax("Erro", "alert", $exc->getMessage());
        }
    }
    
    function atualizaDocumentosLiquidacao(PDO $pdo = null){
        try {
            $this->sucesso = true;
            
            if (!empty($pdo)) {
                
                //Busca os Documentos Fiscais associado a Liquidacao para saber qual foi removido ou inserido
                $liquidacaoDoc = new LiquidacaoDoc();
                $liquidacaoDoc->setIdLiquidacao($this->getIdLiquidacao());
                
                $documentosAntigos = $liquidacaoDoc->retornaDocumentosPorLiquidacao($pdo);
                
                if (!$liquidacaoDoc->getSucesso()) {
                    $this->sucesso = false;
                    $this->mensagens = $liquidacaoDoc->getMensagens();
                    return false;
                }
                
                if ($this->getDocumentos()) {
                    foreach ($this->getDocumentos() as $indice => $documentoNovo) {
                        
                        $idDocumentoFiscal = $documentoNovo[$indice];
                        
                        //Laço para verificar se o documento já está persistido na liquidação
                        if ($documentosAntigos) { //Se não estiver vazio
                            foreach ($documentosAntigos as $chave => $documentoAntigo) {
                                if($documentoAntigo['id_documento_fiscal'] == $idDocumentoFiscal){
                                    unset($documentosAntigos[$chave]);
                                    break;
                                }
                            }
                        }
                        //verifica se o Documento já está incluído na Liquidação  
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
    
}

