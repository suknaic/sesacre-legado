<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinTipoDocumentoTb.class.php";

class DaoFinTipoDocumento extends FinTipoDocumentoTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function sucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    
    public function insert(PDO $pdo){
        $this->sucesso = false;
        $sql = "insert into fin_tipo_documento (nm_tipo_documento) values (:nm_tipo_documento)";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_tipo_documento", $this->getNmTipoDocumento(), PDO::PARAM_STR);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $ex) {
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function update(PDO $pdo){
        $this->sucesso = false; 
        $sql = "UPDATE fin_tipo_documento SET nm_tipo_documento = :nm_tipo_documento"                    
                    . " WHERE id_tipo_documento = :id_tipo_documento";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tipo_documento", $this->getIdTipoDocumento(), PDO::PARAM_INT);
                $stmt->bindValue(":nm_tipo_documento", $this->getNmTipoDocumento(), PDO::PARAM_STR);                                    
                $stmt->execute();
                $this->sucesso = true; 
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {          
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    public function desativa(PDO $pdo){
        $this->sucesso = false; 
        $sql = "UPDATE fin_tipo_documento SET st_ativo = '0'"                    
                    . " WHERE id_tipo_documento = :id_tipo_documento";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tipo_documento", $this->getIdTipoDocumento(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true; 
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {          
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    public function ativa(PDO $pdo){
        $this->sucesso = false; 
        $sql = "UPDATE fin_tipo_documento SET st_ativo = '1'"                    
                    . " WHERE id_tipo_documento = :id_tipo_documento";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tipo_documento", $this->getIdTipoDocumento(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true; 
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {          
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    public function retorna(PDO $pdo){
        $this->sucesso = false;
        $sql = " SELECT *"                    
                . " FROM fin_tipo_documento"
                . " WHERE id_tipo_documento = :id_tipo_documento";
        try {
            $stmt = $pdo->prepare($sql);            
            $stmt->bindValue(":id_tipo_documento", $this->getIdTipoDocumento(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {               
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    public function retornaTodos(PDO $pdo){
        $this->sucesso = false;
        $sql = " SELECT *"                    
                . " FROM fin_tipo_documento";
        try {
            $stmt = $pdo->prepare($sql);            
            $stmt->execute();
            if ($stmt->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {               
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage(); 
        }
    }

    public function retornaTipoDocumento(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }
            $sql = "select * from fin_tipo_documento";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Não foi possível Localizar o Contrato";
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
