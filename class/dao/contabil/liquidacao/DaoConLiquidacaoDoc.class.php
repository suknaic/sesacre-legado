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
            $result = $pdo->prepare("INSERT INTO con_liquidacao_doc (id_liquidacao, id_documento_fiscal)"                    
                    . " VALUES (:id_liquidacao, :id_documento_fiscal);");                                                            
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->bindValue(":id_documento_fiscal", $this->getIdDocumentoFiscal(), PDO::PARAM_INT); 
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
        $sql = " SELECT id_liquidacao_doc, id_liquidacao, id_documento_fiscal"                    
                . " FROM con_liquidacao_doc"
                . " WHERE id_liquidacao = :id_liquidacao";
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->execute();
//            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
//            } else {
//                $this->sucesso = false;                
//                $this->msgRetorno = "Não encontrou Registros";                
//            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }   
    
    function retornaPorDocumentoFiscal($pdo){
        $this->sucesso = false;
        $sql = " SELECT id_liquidacao_doc, id_liquidacao, id_documento_fiscal"                    
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