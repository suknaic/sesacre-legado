<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/orcamento/empenho/FinEmpenhoAnotacaoTb.class.php";

class DaoFinEmpenhoAnotacao extends FinEmpenhoAnotacao {

    private $sucesso = false;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    function getSucesso() {
        return $this->sucesso;
    }

    public function insert(PDO $pdo = null) {
        try {
            if(!empty($pdo)){
                $sql = "insert into fin_empenho_anotacao (id_pessoa,id_empenho,ds_empenho_anotacao) values (:id_pessoa, :id_empenho, :ds_empenho_anotacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":id_empenho", $this->getIdEmpenho(), PDO::PARAM_INT);
                $stmt->bindValue(":ds_empenho_anotacao", $this->getDsEmpenhoAnotacao(), PDO::PARAM_STR);
                
                $stmt->execute();
                $this->sucesso = true;
            }  else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function selectPorId(PDO $pdo = null){
        try {
            if(!empty($pdo)){
                $sql = "select id_empenho_anotacao, ds_empenho_anotacao,dh_empenho_anotacao,id_pessoa,id_empenho from fin_empenho_anotacao where id_empenho_anotacao = :id_empenho_anotacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anotacao",$this->getIdEmpenhoAnotacao(), PDO::PARAM_INT);
                
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhuma anotação encontrada.';
                    $this->sucesso = false;
                }
            }  else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function selectPorEmpenho(PDO $pdo = null){
        try {
            if(!empty($pdo)){
                $sql = "SELECT
                            id_empenho_anotacao,
                            to_char(dh_empenho_anotacao, 'DD/MM/YYYY HH24:MI:SS') AS dh_empenho_anotacao,
                            ds_empenho_anotacao,
                            fea.id_pessoa,
                            sp.nm_pessoa,
                            id_empenho
                          FROM fin_empenho_anotacao fea,
                               ses_pessoa sp
                          WHERE id_empenho = :id_empenho
                          AND fea.id_pessoa = sp.id_pessoa
                          ORDER BY id_empenho_anotacao desc";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho",$this->getIdEmpenho(), PDO::PARAM_INT);
                
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhuma anotação encontrada.';
                    $this->sucesso = false;
                }
            }  else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    

}

