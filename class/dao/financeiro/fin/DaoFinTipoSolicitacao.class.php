<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinTipoSolicitacao.class.php";

class DaoFinTipoSolicitacao extends FinTipoSolicitacao {
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
                $sql = "insert into fin_tipo_solicitacao (nm_tipo_solicitacao) values (:nm_tipo_solicitacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':nm_tipo_solicitacao', $this->getNmTipoSolicitacao(), PDO::PARAM_STR);
                
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function update(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "update fin_tipo_solicitacao set nm_tipo_solicitacao = :nm_tipo_solicitacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':nm_tipo_solicitacao', $this->getNmTipoSolicitacao(), PDO::PARAM_STR);
                
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function delete(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "delete from fin_tipo_solicitacao where id_tipo_solicitacao = :id_tipo_solicitacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tipo_solicitacao",$this->getIdTipoSolicitacao(), PDO::PARAM_INT);
                $this->sucesso = $stmt->execute();
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function select(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select id_tipo_solicitacao, nm_tipo_solicitacao from fin_tipo_solicitacao " . $this->montaFiltro();
                $stmt = $pdo->prepare($sql);
                
                if ($this->getIdTipoSolicitacao()) {
                    $stmt->bindValue(':id_tipo_solicitacao', $this->getIdTipoSolicitacao(), PDO::PARAM_INT);
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
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function montaFiltro(){
        $retorno = "";
        if ($this->getIdTipoSolicitacao()) {
            $retorno = " where id_tipo_solicitacao = :id_tipo_solicitacao";
        }
        return $retorno;
    }
}

