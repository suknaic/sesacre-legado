<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinAdministracaoSolicitacao.class.php";

class DaoFinAdministracaoSolicitacao extends FinAdministracaoSolicitacao {
    private $sucesso = false;
    private $msgRetorno = null;
    
    function getSucesso(){
        return $this->sucesso;
    }
    
    function getMsgRetorno(){
        return $this->msgRetorno;
    }
    
    function insert(PDO $pdo = null){
        if (!empty($pdo)) {
            $sql = "insert into fin_administracao_solicitacao(id_tipo_administracao,id_tipo_solicitacao) values (:id_tipo_administracao,:id_tipo_solicitacao)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id_tipo_administracao", $this->getIdTipoAdministracao(), PDO::PARAM_INT);
            $stmt->bindValue(":id_tipo_solicitacao", $this->getIdTipoSolicitacao(), PDO::PARAM_INT);
            
            $stmt->execute();
            $this->sucesso = true;
        } else {
            $this->msgRetorno = 'Sem conexão com o banco de dados';
        }
    }
    
    function delete(PDO $pdo = null){
        if (!empty($pdo)) {
            $sql = "delete from fin_administracao_solicitacao where id_administracao_solicitacao = :id_administracao_solicitacao";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id_administracao_solicitacao", $this->getIdAdministracaoSolicitacao(), PDO::PARAM_INT);
            
            $stmt->execute();
            $this->sucesso = true;
        } else {
            $this->msgRetorno = 'Sem conexão com o banco de dados';
        }
    }
}

