<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinDocTipoDestinatario.class.php";

class DaoFinDocTipoDestinatario extends FinDocTipoDestinatario {

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
                $sql = "insert into fin_doc_tipo_destinatario (nm_doc_tipo_destinatario) values (:nm_doc_tipo_destinatario)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_doc_tipo_destinatario", $this->getNmDocTipoDestinatario(), PDO::PARAM_STR);
                
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
                $sql = "update fin_doc_tipo_destinatario set nm_doc_tipo_destinatario = :nm_doc_tipo_destinatario where id_doc_tipo_destinatario = :id_doc_tipo_destinatario";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':nm_doc_tipo_destinatario', $this->getNmDocTipoDestinatario(), PDO::PARAM_STR);
                $stmt->bindValue(':id_doc_tipo_destinatario', $this->getIdDocTipoDestinatario(), PDO::PARAM_INT);
                
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
                $sql = "delete from fin_doc_tipo_destinatario where id_doc_tipo_destinatario = :id_doc_tipo_destinatario";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_tipo_destinatario", $this->getIdDocTipoDestinatario(), PDO::PARAM_INT);
                
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
                $sql = "select id_doc_tipo_destinatario, nm_doc_tipo_destinatario, st_ativo from fin_doc_tipo_destinatario". $this->filtroSql() . " order by id_doc_tipo_destinatario";
                $stmt = $pdo->prepare($sql);
                
                if($this->getIdDocTipoDestinatario()){
                    $stmt->bindValue(":id_doc_tipo_destinatario", $this->getIdDocTipoDestinatario(), PDO::PARAM_INT);
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
                $sql = "select * from fin_doc_tipo_destinatario where id_doc_tipo_destinatario = :id_doc_tipo_destinatario";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_tipo_destinatario", $this->getIdDocTipoDestinatario(), PDO::PARAM_INT);
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
        
        if ($this->getIdDocTipoDestinatario()) {
            $filtro .= empty($filtro) ? " where id_doc_tipo_destinatario = :id_doc_tipo_destinatario" : " and id_doc_tipo_destinatario = :id_doc_tipo_destinatario";
        }
        
        return $filtro;
    }


}

