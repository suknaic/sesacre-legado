<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/pedido/FinPedidoSituacao.class.php";

class DaoFinPedidoSituacao extends FinPedidoSituacao {

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
        $sql = "INSERT INTO fin_pedido_situacao (nm_pedido_situacao) VALUES (:nm_pedido_situacao)";
        try {
            if (!empty($pdo)) {
                $clausula = $pdo->prepare($sql);
                $clausula->bindValue(":nm_pedido_situacao", $this->getNmPedidoSituacao(),PDO::PARAM_STR);
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
        $sql = "UPDATE fin_pedido_situacao set nm_pedido_situacao = :nm_pedido_situacao where id_pedido_situacao = :id_pedido_situacao";
        try {
            if (!empty($pdo)) {
                $clausula = $pdo->prepare($sql);
                $clausula->bindValue(":nm_pedido_situacao", $this->getNmPedidoSituacao(),PDO::PARAM_STR);
                $clausula->bindValue(":id_pedido_situacao", $this->getIdPedidoSituacao(), PDO::PARAM_INT);
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
        $sql = "UPDATE fin_pedido_situacao set st_ativo = '0' where id_pedido_situacao = :id_pedido_situacao";
        try {
            if (!empty($pdo)) {
                $clausula = $pdo->prepare($sql);
                $clausula->bindValue(":id_pedido_situacao", $this->getIdPedidoSituacao(), PDO::PARAM_INT);
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
        $sql = "UPDATE fin_pedido_situacao set st_ativo = '1' where id_pedido_situacao = :id_pedido_situacao";
        try {
            if (!empty($pdo)) {
                $clausula = $pdo->prepare($sql);
                $clausula->bindValue(":id_pedido_situacao", $this->getIdPedidoSituacao(), PDO::PARAM_INT);
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
        $sql = "SELECT * FROM fin_pedido_situacao where id_pedido_situacao = :id_pedido_situacao";
        try {
            $clausula = $pdo->prepare($sql);
            $clausula->bindValue(":id_pedido_situacao", $this->getIdPedidoSituacao(), PDO::PARAM_INT);
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
        $sql = "SELECT * FROM fin_pedido_situacao";
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

