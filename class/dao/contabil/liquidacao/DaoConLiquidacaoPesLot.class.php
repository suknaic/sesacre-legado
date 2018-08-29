<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/liquidacao/ConLiquidacaoPesLot.class.php";

class DaoConLiquidacaoPesLot extends ConLiquidacaoPesLot{
    
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
            $result = $pdo->prepare("INSERT INTO con_liquidacao_pes_lot (id_pessoa, id_lotacao)"                    
                    . " VALUES (:id_pessoa, :id_lotacao);");                                                            
            $result->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_STR);
            $result->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);            
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }            
    
    function delete($pdo){
        try {
            $result = $pdo->prepare("DELETE FROM con_liquidacao_pes_lot WHERE id_liquidacao_pes_lot = :id_liquidacao_pes_lot");
            $result->bindValue(":id_liquidacao_pes_lot", $this->getIdLiquidacaoPesLot(), PDO::PARAM_INT);            
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
                . " FROM con_liquidacao_pes_lot"
                . " WHERE id_liquidacao_pes_lot = :id_liquidacao_pes_lot";
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":id_liquidacao_pes_lot", $this->getIdLiquidacaoPesLot(), PDO::PARAM_INT);
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
    
    function retornaPorPessoa($pdo){
        $this->sucesso = false;
        $sql = " SELECT id_liquidacao_pes_lot, id_pessoa, id_lotacao"                    
                . " FROM con_liquidacao_pes_lot"
                . " WHERE id_pessoa = :id_pessoa";
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }   
    
    function retornaPorLotacao($pdo){
        $this->sucesso = false;
        $sql = " SELECT id_liquidacao_pes_lot, id_pessoa, id_lotacao"                    
                . " FROM con_liquidacao_pes_lot"
                . " WHERE id_lotacao = :id_lotacao";
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
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