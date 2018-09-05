<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/liquidacao/DaoConLiquidacaoDoc.class.php";

class LiquidacaoDoc {
    private $idLiquidacaoDoc = null;
    private $idLiquidacao = null;
    private $idDocumentoFiscal = null;
    
    private $mensagens = null;
    private $sucesso = null;
    
    function getMensagens() {
        return $this->mensagens;
    }

    function getSucesso() {
        return $this->sucesso;
    }
    
    function getIdLiquidacaoDoc() {
        return $this->idLiquidacaoDoc;
    }

    function getIdLiquidacao() {
        return $this->idLiquidacao;
    }

    function getIdDocumentoFiscal() {
        return $this->idDocumentoFiscal;
    }

    function setIdLiquidacaoDoc($idLiquidacaoDoc) {
        $this->idLiquidacaoDoc = $idLiquidacaoDoc;
        return $this;
    }

    function setIdLiquidacao($idLiquidacao) {
        $this->idLiquidacao = $idLiquidacao;
        return $this;
    }

    function setIdDocumentoFiscal($idDocumentoFiscal) {
        $this->idDocumentoFiscal = $idDocumentoFiscal;
        return $this;
    }


    function salvarLiquidacaoDoc(PDO $pdo = null){
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {
                
                $daoConLiquidacaoDoc = new DaoConLiquidacaoDoc();
                $daoConLiquidacaoDoc->setIdLiquidacao($this->getIdLiquidacao())
                                    ->setIdDocumentoFiscal($this->getIdDocumentoFiscal());
                
                $daoConLiquidacaoDoc->insert($pdo);
            
                if ($daoConLiquidacaoDoc->Sucesso()) {
                    $idLiquidacaoDoc = $pdo->lastInsertId('con_liquidacao_doc_id_liquidacao_doc_seq');
                    if (!Log::SalvaLogI('con_liquidacao_doc', $idLiquidacaoDoc, $pdo)) {
                        $this->mensagens = "Erro ao salvar o Documento Fiscal da Liquidação no LOG. Operação Cadastro.";
                    }
                    $this->sucesso = true;
                } else {
                    $this->mensagens = $daoConLiquidacaoDoc->getMsgRetorno();
                }
            } else {
                $this->mensagens = "Sem conexão com o banco de dados";
            }
 
        } catch (Exception $exc) {
            //Se der algum erro, registra o erro no objeto
            $this->sucesso = false;
            $this->mensagens = $exc->getMessage();
        }
    }
    
    function removerLiquidacaoDoc(PDO $pdo = null){
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {
                
                $daoConLiquidacaoDoc = new DaoConLiquidacaoDoc();
                $daoConLiquidacaoDoc->setIdLiquidacaoDoc($this->getIdLiquidacaoDoc());
                
                if (!Log::SalvaLogD('con_liquidacao_doc', $daoConLiquidacaoDoc->getIdLiquidacaoDoc(), $pdo)) {
                    $this->mensagens = "Erro ao salvar o Documento Fiscal da Liquidação no LOG. . Operação Exclusão.";
                }
                
                $daoConLiquidacaoDoc->delete($pdo);
                
                if ($daoConLiquidacaoDoc->Sucesso()) {
                    $this->sucesso = true;
                } else {
                    $this->mensagens = $daoConLiquidacaoDoc->getMsgRetorno();
                }
                
            } else {
                $this->mensagens = "Sem conexão com o banco de dados";
            }
        } catch (Exception $exc) {
            //Se der algum erro, registra o erro no objeto
            $this->sucesso = false;
            $this->mensagens = $exc->getMessage();
        }
    }
    
    function retornaDocumentosPorLiquidacao(PDO $pdo = null){
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {
                $daoConLiquidacaoDoc = new DaoConLiquidacaoDoc();
                $daoConLiquidacaoDoc->setIdLiquidacao($this->getIdLiquidacao());
                $daoConLiquidacaoDoc->retornaPorLiquidacao($pdo);
                
                if ($daoConLiquidacaoDoc->Sucesso()) {
                    $this->sucesso = true;
                    $this->mensagens = $daoConLiquidacaoDoc->getMsgRetorno();
                } else {
                    $this->mensagens = $daoConLiquidacaoDoc->getMsgRetorno();
                }
            } else {
                $this->mensagens = "Sem conexão com o banco de dados";
            }
        } catch (Exception $exc) {
            //Se der algum erro, registra o erro no objeto
            $this->sucesso = false;
            $this->mensagens = $exc->getMessage();
        }
    }
}

