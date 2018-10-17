<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/empenho/anulacao/ConEmpenhoAnulacaoStatus.class.php";

class DaoConEmpenhoAnulacaoStatus extends ConEmpenhoAnulacaoStatus {

    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function getSucesso(){
        return $this->sucesso;
    }

    function insert(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "INSERT INTO con_empenho_anulacao_status (nm_empenho_anulacao_status)"                    
                    . " VALUES (:nm_empenho_anulacao_status)";
        try {      
            if(!empty($pdo)){
                $stmt = $pdo->prepare($sql);                                        
                $stmt->bindValue(":nm_empenho_anulacao_status", $this->getNmEmpenhoAnulacaoStatus(), PDO::PARAM_STR);            
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();            
        }
    }    
    
    
    function update(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "UPDATE con_empenho_anulacao_status SET nm_empenho_anulacao_status = :nm_empenho_anulacao_status"                    
                    . " WHERE id_empenho_anulacao_status = :id_empenho_anulacao_status";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao_status", $this->getIdEmpenhoAnulacaoStatus(), PDO::PARAM_INT);
                $stmt->bindValue(":nm_empenho_anulacao_status", $this->getNmEmpenhoAnulacaoStatus(), PDO::PARAM_STR);                                    
                $stmt->execute();
                $this->sucesso = true; 
            } else {
                $this->msgRetorno = "Sem conexão com o banco de dados";
            }
        } catch (PDOException $e) {         
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function desativa(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "UPDATE con_empenho_anulacao_status SET st_ativo = '0'"                    
                    . " WHERE id_empenho_anulacao_status = :id_empenho_anulacao_status";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao_status", $this->getIdEmpenhoAnulacaoStatus(), PDO::PARAM_INT);            
                $stmt->execute();
                $this->sucesso = true; 
            } else {
                $this->msgRetorno = "Sem conexão com o banco de dados";
            }
        } catch (PDOException $e) {         
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function ativa(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "UPDATE con_empenho_anulacao_status SET st_ativo = '1'"                    
                    . " WHERE id_empenho_anulacao_status = :id_empenho_anulacao_status ";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao_status", $this->getIdEmpenhoAnulacaoStatus(), PDO::PARAM_INT);            
                $stmt->execute();
                $this->sucesso = true; 
            } else {
                $this->msgRetorno = "Sem conexão com o banco de dados";
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage(); 
        }
    }        
    
    function retorna(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = " SELECT *"                    
                . " FROM con_empenho_anulacao_status"
                . " WHERE id_empenho_anulacao_status = :id_empenho_anulacao_status";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);            
                $stmt->bindValue(":id_empenho_anulacao_status", $this->getIdEmpenhoAnulacaoStatus(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() >= 1){
                    $this->sucesso = true; 
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {             
                    $this->msgRetorno = "Não encontrou Registros";                
                }  
            } else {
                $this->msgRetorno = "Sem conexão com o banco de dados";
            }
                      
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function retornaTodos(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = " SELECT *"                    
                . " FROM con_empenho_anulacao_status";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);   
                $stmt->execute();
                if ($stmt->rowCount() >= 1){
                    $this->sucesso = true; 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {             
                    $this->msgRetorno = "Não encontrou Registros";                
                }  
            } else {
                $this->msgRetorno = "Sem conexão com o banco de dados";
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage(); 
        }
    }

}