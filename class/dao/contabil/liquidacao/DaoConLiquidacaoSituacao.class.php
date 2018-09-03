<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/liquidacao/ConLiquidacaoSituacao.class.php";

class DaoConLiquidacaoSituacao extends ConLiquidacaoSituacao {
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }

    function insert($pdo) {
        try {                      
            $result = $pdo->prepare("INSERT INTO con_liquidacao_situacao (nm_liquidacao_situacao)"                    
                    . " VALUES (:nm_liquidacao_situacao);");                                        
            $result->bindValue(":nm_liquidacao_situacao", $this->getNmLiquidacaoSituacao(), PDO::PARAM_STR);            
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }    
    
    function delete($pdo){
        try {
            $result = $pdo->prepare("DELETE FROM con_liquidacao_situacao WHERE id_liquidacao_situacao = :id_liquidacao_situacao");
            $result->bindValue(":id_liquidacao_situacao", $this->getIdLiquidacaoSituacao(), PDO::PARAM_INT);            
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE con_liquidacao_situacao SET nm_liquidacao_situacao = :nm_liquidacao_situacao"                    
                    . " WHERE id_liquidacao_situacao = :id_liquidacao_situacao");
            $result->bindValue(":id_liquidacao_situacao", $this->getIdLiquidacaoSituacao(), PDO::PARAM_INT);
            $result->bindValue(":nm_liquidacao_situacao", $this->getNmLiquidacaoSituacao(), PDO::PARAM_STR);                                    
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function desativa($pdo){
        try {
            $result = $pdo->prepare("UPDATE con_liquidacao_situacao SET st_ativo = '0'"                    
                    . " WHERE id_liquidacao_situacao = :id_liquidacao_situacao ");
            $result->bindValue(":id_liquidacao_situacao", $this->getIdLiquidacaoSituacao(), PDO::PARAM_INT);            
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function ativa($pdo){
        try {
            $result = $pdo->prepare("UPDATE con_liquidacao_situacao SET st_ativo = '1'"                    
                    . " WHERE id_liquidacao_situacao = :id_liquidacao_situacao ");
            $result->bindValue(":id_liquidacao_situacao", $this->getIdLiquidacaoSituacao(), PDO::PARAM_INT);            
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }        
    
    function retorna($pdo) {
        $this->sucesso = false;
        $sql = " SELECT *"                    
                . " FROM con_liquidacao_situacao"
                . " WHERE id_liquidacao_situacao = :id_liquidacao_situacao";
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":id_liquidacao_situacao", $this->getIdLiquidacaoSituacao(), PDO::PARAM_INT);
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
}