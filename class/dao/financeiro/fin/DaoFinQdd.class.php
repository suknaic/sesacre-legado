<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinQdd.class.php";

class DaoFinQdd extends FinQdd {
    
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
            $result = $pdo->prepare("INSERT INTO fin_qdd (aa_qdd) "
                    . " VALUES (:aaQdd)");                                        
            $result->bindValue(":aaQdd", $this->getAaQdd(), PDO::PARAM_INT);                                        
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }    
    
    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE fin_qdd SET aa_qdd = :aaQdd "
                    . "WHERE id_qdd = :idQdd ");
            $result->bindValue(":aaQdd", $this->getAaQdd(), PDO::PARAM_INT);
            $result->bindValue(":idQdd", $this->getIdQdd(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM fin_qdd WHERE id_qdd = :idQdd");
            $result->bindValue(":idQdd", $this->getIdQdd(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }   
    
    function verificaExistePorAno($pdo) {    
        $this->sucesso = false;

        $sql = " SELECT id_qdd, aa_qdd"                    
                . " FROM fin_qdd"
                . " WHERE aa_qdd = :aaQdd";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":aaQdd", $this->getAaQdd(), PDO::PARAM_INT);
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