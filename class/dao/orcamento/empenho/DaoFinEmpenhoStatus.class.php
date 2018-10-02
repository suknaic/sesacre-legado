<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/orcamento/empenho/FinEmpenhoStatus.class.php";

class DaoFinEmpenhoStatus extends FinEmpenhoStatus {

    private $sucesso = false;
    private $msgRetorno = null;

    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function sucesso() {
        return $this->sucesso;
    }
    
    public function insert(PDO $pdo = null){
        $this->sucesso = false;
        $sql = "INSERT INTO fin_empenho_status (nm_empenho_status) VALUES (:nm_empenho_status)";
        try {
            if (!empty($pdo)) {
                $clausula = $pdo->prepare($sql);
                $clausula->bindValue(":nm_empenho_status", $this->getNmEmpenhoStatus(),PDO::PARAM_STR);
                $clausula->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem conexão com o banco de dados.";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function update(PDO $pdo = null){
        $this->sucesso = false;
        $sql = "UPDATE fin_empenho_status set nm_empenho_status = :nm_empenho_status where id_empenho_status = :id_empenho_status";
        try {
            if (!empty($pdo)) {
                $clausula = $pdo->prepare($sql);
                $clausula->bindValue(":nm_empenho_status", $this->getNmEmpenhoStatus(),PDO::PARAM_STR);
                $clausula->bindValue(":id_empenho_status", $this->getIdEmpenhoStatus(), PDO::PARAM_INT);
                $clausula->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem conexão com o banco de dados.";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }

    }
    
    public function desativa(PDO $pdo = null){
        $this->sucesso = false;
        $sql = "UPDATE fin_empenho_status set st_ativo = '0' where id_empenho_status = :id_empenho_status";
        try {
            if (!empty($pdo)) {
                $clausula = $pdo->prepare($sql);
                $clausula->bindValue(":id_empenho_status", $this->getIdEmpenhoStatus(), PDO::PARAM_INT);
                $clausula->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem conexão com o banco de dados.";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function ativa(PDO $pdo = null){
        $this->sucesso = false;
        $sql = "UPDATE fin_empenho_status set st_ativo = '1' where id_empenho_status = :id_empenho_status";
        try {
            if (!empty($pdo)) {
                $clausula = $pdo->prepare($sql);
                $clausula->bindValue(":id_empenho_status", $this->getIdEmpenhoStatus(), PDO::PARAM_INT);
                $clausula->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem conexão com o banco de dados.";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function retorna(PDO $pdo = null){
        $this->sucesso = false;
        $sql = "SELECT * FROM fin_empenho_status where id_empenho_status = :id_empenho_status";
        try {
            $clausula = $pdo->prepare($sql);
            $clausula->bindValue(":id_empenho_status", $this->getIdEmpenhoStatus(), PDO::PARAM_INT);
            $clausula->execute();
            if ($clausula->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $clausula->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function retornaTodos(PDO $pdo = null){
        $this->sucesso = false;
        $sql = "SELECT * FROM fin_empenho_status";
        try {
            $clausula = $pdo->prepare($sql);
            $clausula->execute();
            if ($clausula->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $clausula->fetchAll(PDO::FETCH_ASSOC);
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

