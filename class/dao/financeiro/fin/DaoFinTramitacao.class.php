<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinTramitacao.class.php";

class DaoFinTramitacao extends FinTramitacao {
    
    private $sucesso = false;
    private $msgRetorno = null;
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }


    function insert(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "insert into fin_tramitacao (nm_tramitacao) values (:nm_tramitacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':nm_tramitacao', $this->getNmTramitacao(), PDO::PARAM_STR);
                
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function update(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "update fin_tramitacao set nm_tramitacao = :nm_tramitacao where id_tramitacao = :id_tramitacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':nm_tramitacao', $this->getNmTramitacao(), PDO::PARAM_STR);
                $stmt->bindValue(':id_tramitacao', $this->getIdTramitacao(), PDO::PARAM_INT);
                
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function delete(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "delete from fin_tramitacao where id_tramitacao = :id_tramitacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tramitacao",$this->getIdTramitacao(), PDO::PARAM_INT);
                $this->sucesso = $stmt->execute();
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function select(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select id_tramitacao, nm_tramitacao from fin_tramitacao " . $this->montaFiltro();
                $stmt = $pdo->prepare($sql);
                
                if ($this->getIdTramitacao()) {
                    $stmt->bindValue(':id_tramitacao', $this->getIdTramitacao(), PDO::PARAM_INT);
                }
                
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function montaFiltro(){
        $retorno = "";
        if ($this->getIdTramitacao()) {
            $retorno = " where id_tramitacao = :id_tramitacao";
        }
        return $retorno;
    }
}

