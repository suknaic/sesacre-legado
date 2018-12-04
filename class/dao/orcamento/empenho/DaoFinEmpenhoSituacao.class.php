<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/orcamento/empenho/FinEmpenhoSituacaoTb.class.php";

class DaoFinEmpenhoSituacao extends FinEmpenhoSituacaoTb {

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
        $this->msgRetorno = null;
        $sql = "INSERT INTO fin_empenho_situacao (nm_empenho_situacao) VALUES (:nm_empenho_situacao)";
        try {
            if (!empty($pdo)) {
                $clausula = $pdo->prepare($sql);
                $clausula->bindValue(":nm_empenho_situacao", $this->getNmEmpenhoSituacao(),PDO::PARAM_STR);
                $clausula->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem conexão com o banco de dados.";
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function update(PDO $pdo = null){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "UPDATE fin_empenho_situacao set nm_empenho_situacao = :nm_empenho_situacao where id_empenho_situacao = :id_empenho_situacao";
        try {
            if (!empty($pdo)) {
                $clausula = $pdo->prepare($sql);
                $clausula->bindValue(":nm_empenho_situacao", $this->getNmEmpenhoSituacao(),PDO::PARAM_STR);
                $clausula->bindValue(":id_empenho_situacao", $this->getIdEmpenhoSituacao(), PDO::PARAM_INT);
                $clausula->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem conexão com o banco de dados.";
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }

    }
    
    public function desativa(PDO $pdo = null){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "UPDATE fin_empenho_situacao set st_ativo = '0' where id_empenho_situacao = :id_empenho_situacao";
        try {
            if (!empty($pdo)) {
                $clausula = $pdo->prepare($sql);
                $clausula->bindValue(":id_empenho_situacao", $this->getIdEmpenhoSituacao(), PDO::PARAM_INT);
                $clausula->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem conexão com o banco de dados.";
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function ativa(PDO $pdo = null){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "UPDATE fin_empenho_situacao set st_ativo = '1' where id_empenho_situacao = :id_empenho_situacao";
        try {
            if (!empty($pdo)) {
                $clausula = $pdo->prepare($sql);
                $clausula->bindValue(":id_empenho_situacao", $this->getIdEmpenhoSituacao(), PDO::PARAM_INT);
                $clausula->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem conexão com o banco de dados.";
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function retorna(PDO $pdo = null){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "SELECT * FROM fin_empenho_situacao where id_empenho_situacao = :id_empenho_situacao";
        try {
            $clausula = $pdo->prepare($sql);
            $clausula->bindValue(":id_empenho_situacao", $this->getIdEmpenhoSituacao(), PDO::PARAM_INT);
            $clausula->execute();
            if ($clausula->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $clausula->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function retornaTodos(PDO $pdo = null){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "SELECT * FROM fin_empenho_situacao";
        try {
            $clausula = $pdo->prepare($sql);
            $clausula->execute();
            if ($clausula->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $clausula->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }
}

