<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/liquidacao/DaoConLiquidacaoDoc.class.php";

class LiquidacaoDoc {
    private $idLiquidacaoDoc = null;
    private $idLiquidacao = null;
    private $idDocumentoFiscal = null;
    private $vlLiquidacaoDoc = null;
    private $vlLiquidacaoDocSaldo = null;
    
    private $mensagens = null;
    private $sucesso = null;
    
    function getMensagens() {
        return $this->mensagens;
    }

    function getSucesso() {
        return $this->sucesso;
    }
    
    function getVlLiquidacaoDoc() {
        return $this->vlLiquidacaoDoc;
    }

    function getVlLiquidacaoDocSaldo() {
        return $this->vlLiquidacaoDocSaldo;
    }

    function setVlLiquidacaoDoc($vlLiquidacaoDoc) {
        $this->vlLiquidacaoDoc = $vlLiquidacaoDoc;
        return $this;
    }

    function setVlLiquidacaoDocSaldo($vlLiquidacaoDocSaldo) {
        $this->vlLiquidacaoDocSaldo = $vlLiquidacaoDocSaldo;
        return $this;
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
                                    ->setIdDocumentoFiscal($this->getIdDocumentoFiscal())
                                    ->setVlLiquidacaoDoc($this->getVlLiquidacaoDoc())
                                    ->setVlLiquidacaoDocSaldo($this->getVlLiquidacaoDocSaldo());
                
                $daoConLiquidacaoDoc->insert($pdo);
                
                if ($daoConLiquidacaoDoc->Sucesso()) {
                    $idLiquidacaoDoc = $pdo->lastInsertId('con_liquidacao_doc_id_liquidacao_doc_seq');
                    if (!Log::SalvaLogI('con_liquidacao_doc', $idLiquidacaoDoc, $pdo)) {
                        $this->mensagens = "Erro ao salvar o Documento Fiscal da Liquidação no LOG. Operação Cadastro.";
                    }
                    
                    //Atualiza situação do GDOF
                    $gdof = new FinDocumentoFiscal();
                    $gdof->setIdDocumentoFiscal($this->getIdDocumentoFiscal())
                         ->setIdDocumentoSituacao($gdof->getDocSitLiquidado());
                    
                    $this->sucesso = $gdof->atualizaSituacaoDocumentoGDOF($pdo);
                } else {
                    $this->mensagens = $daoConLiquidacaoDoc->getMsgRetorno() ;
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
    
    function atualizarLiquidacaoDoc(PDO $pdo = null){
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {
                
                $daoConLiquidacaoDoc = new DaoConLiquidacaoDoc();
                $daoConLiquidacaoDoc->setIdLiquidacao($this->getIdLiquidacao())
                                    ->setIdLiquidacaoDoc($this->getIdLiquidacaoDoc())
                                    ->setIdDocumentoFiscal($this->getIdDocumentoFiscal())
                                    ->setVlLiquidacaoDoc($this->getVlLiquidacaoDoc())
                                    ->setVlLiquidacaoDocSaldo($this->getVlLiquidacaoDocSaldo());
                
                $reg_antigo = $daoConLiquidacaoDoc->retorna($pdo);
                if (!$daoConLiquidacaoDoc->sucesso()) {
                    $this->sucesso = false;
                    $this->msgRetorno = "Erro ao localizar o registro na tabela con_liquidacao_doc ";
                    return false;
                }
                
                $reg_antigo = $daoConLiquidacaoDoc->getMsgRetorno();
                
                $daoConLiquidacaoDoc->update($pdo);
                if ($daoConLiquidacaoDoc->sucesso()) {
                    if (!Log::SalvaLogU('con_liquidacao_doc', $daoConLiquidacaoDoc->getIdLiquidacaoDoc(), $reg_antigo, $pdo)) {
                        $this->sucesso = false;
                        $this->msgRetorno = 'Erro no Log para atualizar Liquidação Documento';
                        return false;
                    }

                    $this->sucesso = true;
                    $this->msgRetorno = "Atualizado com Sucesso";
                    return true;
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = $daoFinEntregaDocumento->getMsgRetorno();
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
                    //Atualiza situação do GDOF
                    $gdof = new FinDocumentoFiscal();
                    $gdof->setIdDocumentoFiscal($this->getIdDocumentoFiscal())
                         ->setIdDocumentoSituacao($gdof->getDocSitALiquidar());
                    
                    $this->sucesso = $gdof->atualizaSituacaoDocumentoGDOF($pdo);
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

