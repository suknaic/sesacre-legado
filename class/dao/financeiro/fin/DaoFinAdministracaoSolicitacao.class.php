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
        try {
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
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function delete(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "delete from fin_administracao_solicitacao where id_administracao_solicitacao = :id_administracao_solicitacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_administracao_solicitacao", $this->getIdAdministracaoSolicitacao(), PDO::PARAM_INT);

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
    
    function select(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "SELECT fas.id_administracao_solicitacao,fas.id_tipo_administracao,fas.id_tipo_solicitacao,fta.nm_tipo_administracao, fts.nm_tipo_solicitacao
                        FROM fin_administracao_solicitacao fas,
                             fin_tipo_administracao fta,
                             fin_tipo_solicitacao fts
                        WHERE fas.id_tipo_administracao = fta.id_tipo_administracao
                          AND fas.id_tipo_solicitacao = fts.id_tipo_solicitacao
                          ORDER BY fas.id_tipo_administracao, fas.id_tipo_solicitacao";
                $stmt = $pdo->prepare($sql);
                
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
}

