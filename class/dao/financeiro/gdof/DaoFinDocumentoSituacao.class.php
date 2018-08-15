<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinDocumentoSituacaoTb.class.php";

class DaoFinDocumentoSituacao extends FinDocumentoSituacaoTb {

    private $sucesso = false;
    private $msgRetorno = null;
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

        
    public function insert(PDO $pdo){
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }
            $sql = "insert into fin_documento_situacao (nm_situacao) values (:nm_situacao)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':nm_situacao', $this->getNmSituacao(), PDO::PARAM_STR);
            $stmt->execute();
            $this->sucesso = true;
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function update(PDO $pdo){
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }
            $sql = "update fin_documento_situacao set nm_situacao = :nm_situacao where id_documento_situacao = :id_documento_situacao";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':nm_situacao', $this->getNmSituacao(), PDO::PARAM_STR);
            $stmt->bindValue(':id_documento_situacao', $this->getIdDocumentoSituacao(), PDO::PARAM_INT);
            $this->sucesso = $stmt->execute();
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function delete(PDO $pdo){
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }
            $sql = "delete from fin_documento_situacao where id_documeto_situacao = :id_documento_situacal";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id_documento_fiscal", $this->getIdDocumentoSituacao(), PDO::PARAM_INT);
            $this->sucesso = $stmt->execute();
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function select(PDO $pdo){
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }
            $sql = "select id_documento_situacao, nm_situacao,st_ativo from fin_documento_situacao " . $this->filtroSql() . " order by nm_situacao";
            $stmt = $pdo->prepare($sql);
            
            if ($this->getIdDocumentoSituacao()) {
                $stmt->bindValue(':id_documento_situacao', $this->getIdDocumentoSituacao(), PDO::PARAM_INT);
            }
            
            $stmt->execute();
                
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    private function filtroSql(){
        $filtro = "";
        
        if ($this->getIdDocumentoSituacao()) {
            $filtro .= empty($filtro) ? " where id_documento_situacao = :id_documento_situacao" : " and id_documento_situacao = :id_documento_situacao" ;
        }
        
        return $filtro;
    }

}

