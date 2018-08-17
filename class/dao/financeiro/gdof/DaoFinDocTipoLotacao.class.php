<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinDocTipoLotacao.class.php";

class DaoFinDocTipoLotacao extends FinDocTipoLotacao {

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
                $sql = "insert into fin_doc_tipo_lotacao (nm_doc_tipo_lotacao) values (:nm_doc_tipo_lotacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_doc_tipo_lotacao", $this->getNmDocTipoLotacao(), PDO::PARAM_STR);
                
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
                $sql = "update fin_doc_tipo_lotacao set nm_doc_tipo_lotacao = :nm_doc_tipo_lotacao where id_doc_tipo_lotacao = :id_doc_tipo_lotacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':nm_doc_tipo_lotacao', $this->getNmDocTipoLotacao(), PDO::PARAM_STR);
                $stmt->bindValue(':id_doc_tipo_lotacao', $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
                
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
                $sql = "delete from fin_doc_tipo_lotacao where id_doc_tipo_lotacao = :id_doc_tipo_lotacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
                
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
                $sql = "select id_doc_tipo_lotacao, nm_doc_tipo_lotacao, st_ativo from fin_doc_tipo_lotacao". $this->filtroSql() . " order by id_doc_tipo_lotacao";
                $stmt = $pdo->prepare($sql);
                
                if($this->getIdDocTipoLotacao()){
                    $stmt->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
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
                $sql = "select * from fin_doc_tipo_lotacao where id_doc_tipo_lotacao = :id_doc_tipo_lotacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
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
        
        if ($this->getIdDocTipoLotacao()) {
            $filtro .= empty($filtro) ? " where id_doc_tipo_lotacao = :id_doc_tipo_lotacao" : " and id_doc_tipo_lotacao = :id_doc_tipo_lotacao";
        }
        
        return $filtro;
    }


}

