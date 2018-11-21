<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/liquidacao/ConLiquidacaoDoc.class.php";

class DaoConLiquidacaoDoc extends ConLiquidacaoDoc{
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno(){
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }

    function insert($pdo){
        try {
            $sql = "INSERT INTO con_liquidacao_doc (id_liquidacao, id_documento_fiscal, vl_liquidacao_doc, vl_liquidacao_doc_saldo, id_documento_situacao)"                    
                    . " VALUES (:id_liquidacao, :id_documento_fiscal, :vl_liquidacao_doc, :vl_liquidacao_doc_saldo, :id_documento_situacao);";
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->bindValue(":id_documento_fiscal", $this->getIdDocumentoFiscal(), PDO::PARAM_INT); 
            $result->bindValue(":vl_liquidacao_doc", $this->getVlLiquidacaoDoc(), PDO::PARAM_STR);
            $result->bindValue(":vl_liquidacao_doc_saldo", $this->getVlLiquidacaoDocSaldo(), PDO::PARAM_STR);
            $result->bindValue(":id_documento_situacao", $this->getIdDocumentoSituacao(),PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }
    
    function update($pdo){
        try {             
            $sql = "update
                        con_liquidacao_doc 
                     set
                        vl_liquidacao_doc = :vl_liquidacao_doc, vl_liquidacao_doc_saldo = :vl_liquidacao_doc_saldo 
                     where
                        id_liquidacao_doc = :id_liquidacao_doc";
            $result = $pdo->prepare($sql);                                                            
            $result->bindValue(":id_liquidacao_doc", $this->getIdLiquidacaoDoc(), PDO::PARAM_INT); 
            $result->bindValue(":vl_liquidacao_doc", $this->getVlLiquidacaoDoc(), PDO::PARAM_STR);
            $result->bindValue(":vl_liquidacao_doc_saldo", $this->getVlLiquidacaoDocSaldo(), PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }
    
    function delete($pdo){
        try {
            $result = $pdo->prepare("DELETE FROM con_liquidacao_doc WHERE id_liquidacao_doc = :id_liquidacao_doc");
            $result->bindValue(":id_liquidacao_doc", $this->getIdLiquidacaoDoc(), PDO::PARAM_INT);            
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function retorna($pdo){
        $this->sucesso = false;
        $sql = " SELECT *"                    
                . " FROM con_liquidacao_doc"
                . " WHERE id_liquidacao_doc = :id_liquidacao_doc";
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":id_liquidacao_doc", $this->getIdLiquidacaoDoc(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }   
    
    function retornaPorLiquidacao($pdo){
        $this->sucesso = false;
        $sql = " SELECT id_liquidacao_doc, id_liquidacao, id_documento_fiscal, vl_liquidacao_doc, vl_liquidacao_doc_saldo"                    
                . " FROM con_liquidacao_doc"
                . " WHERE id_liquidacao = :id_liquidacao";
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->execute();

            $this->sucesso = true; 
            $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }   
    
    function retornaPorDocumentoFiscal($pdo){
        $this->sucesso = false;
        $sql = " SELECT id_liquidacao_doc, id_liquidacao, id_documento_fiscal, vl_liquidacao_doc, vl_liquidacao_doc_saldo"                    
                . " FROM con_liquidacao_doc"
                . " WHERE id_documento_fiscal = :id_documento_fiscal";
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":id_documento_fiscal", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e){
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }                      
}