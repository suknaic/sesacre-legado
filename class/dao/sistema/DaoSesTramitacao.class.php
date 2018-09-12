<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/sistema/SesTramitacao.class.php";


class DaoSesTramitacao extends SesTramitacao {

    private $sucesso = false;
    private $msgRetorno = null;
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function insert($pdo) {
        try {                      
            $result = $pdo->prepare("INSERT INTO ses_tramitacao (nm_tramitacao)"                    
                    . " VALUES (:nm_tramitacao);");                                        
            $result->bindValue(":nm_tramitacao", $this->getNmTramitacao(), PDO::PARAM_STR);            
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }    
    
    function delete($pdo){
        try {
            $result = $pdo->prepare("DELETE FROM ses_tramitacao WHERE id_tramitacao = :id_tramitacao");
            $result->bindValue(":id_tramitacao", $this->getIdTramitacao(), PDO::PARAM_INT);            
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_tramitacao SET nm_tramitacao = :nm_tramitacao"                    
                    . " WHERE id_tramitacao = :id_tramitacao");
            $result->bindValue(":id_tramitacao", $this->getIdTramitacao(), PDO::PARAM_INT);
            $result->bindValue(":nm_tramitacao", $this->getNmTramitacao(), PDO::PARAM_STR);                                    
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function desativa($pdo){
        try {
            $result = $pdo->prepare("UPDATE ses_tramitacao SET st_ativo = '0'"                    
                    . " WHERE id_tramitacao = :id_tramitacao ");
            $result->bindValue(":id_tramitacao", $this->getIdTramitacao(), PDO::PARAM_INT);            
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function ativa($pdo){
        try {
            $result = $pdo->prepare("UPDATE ses_tramitacao SET st_ativo = '1'"                    
                    . " WHERE id_tramitacao = :id_tramitacao ");
            $result->bindValue(":id_tramitacao", $this->getIdTramitacao(), PDO::PARAM_INT);            
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
                . " FROM ses_tramitacao"
                . " WHERE id_tramitacao = :id_tramitacao";
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":id_tramitacao", $this->getIdTramitacao(), PDO::PARAM_INT);
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
    
    function retornaTodos($pdo){
        $this->sucesso = false;
        $sql = " SELECT *"                    
                . " FROM ses_tramitacao";
        try {
            $result = $pdo->prepare($sql);   
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

}

