<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinTipoAdministracao.class.php";

class DaoFinTipoAdministracao extends FinTipoAdministracao {
    private $sucesso = false;
    private $msgRetorno = null;
    
    function getSucesso(){
        return $this->sucesso;
    }
    
    function getMsgRetorno(){
        return $this->msgRetorno;
    }
    
    function insert(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "insert into fin_tipo_administracao (nm_tipo_administracao) values (:nm_tipo_administracao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_tipo_administracao", $this->getNmTipoAdministracao(), PDO::PARAM_STR);
                
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
                $sql = "update fin_tipo_administracao set nm_tipo_administracao = :nm_tipo_administracao where id_tipo_administracao = :id_tipo_administracao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tipo_administracao", $this->getIdTipoAdministracao(), PDO::PARAM_INT);
                $stmt->bindValue(":nm_tipo_administracao", $this->getNmTipoAdministracao(), PDO::PARAM_STR);
                
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
                $sql = "delete from fin_tipo_administracao where id_tipo_administracao = :id_tipo_administracao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tipo_administracao", $this->getIdTipoAdministracao(), PDO::PARAM_INT);
                
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
                $sql = "select id_tipo_administracao, nm_tipo_administracao, st_ativo from fin_tipo_administracao". $this->filtroSql() . " order by id_tipo_administracao";
                $stmt = $pdo->prepare($sql);
                
                if($this->getIdTipoAdministracao()){
                    $stmt->bindValue(":id_tipo_administracao", $this->getIdTipoAdministracao(), PDO::PARAM_INT);
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
    
    function selectLinha(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select * from fin_tipo_administracao where id_tipo_administracao = :id_tipo_administracao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tipo_administracao", $this->getIdTipoAdministracao(), PDO::PARAM_INT);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
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
    
    function filtroSql(){
        $filtro = "";
        
        if ($this->getIdTipoAdministracao()) {
            $filtro .= empty($filtro) ? " where id_tipo_administracao = :id_tipo_administracao" : " and id_tipo_administracao = :id_tipo_administracao";
        }
        
        return $filtro;
    }
}

