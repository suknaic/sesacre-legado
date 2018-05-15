<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaDiariaHistorico.class.php";

class DaoDiaDiariaHistorico extends DiaDiariaHistorico {

    private $sucesso = false;
    private $msgRetorno = null;
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function setSucesso($sucesso) {
        $this->sucesso = $sucesso;
    }

    function setMsgRetorno($msgRetorno) {
        $this->msgRetorno = $msgRetorno;
    }

    public function select(PDO $pdo = null){
        try {
            if (true) {
                $sql = "select id_diaria_historico, id_diaria,id_pessoa,ds_diaria_historico,dh_diaria_historico where id_diaria = :id_diaria";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria", $this->getIdDiaria());
                
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function insert(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "insert into dia_diaria_historico (id_diaria,id_pessoa,ds_diaria_historico ) "
                        . "values (:id_diaria,:id_pessoa,:ds_diaria_historico )";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria", $this->getIdDiaria(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":ds_diaria_historico", $this->getDsDiariaHistorico(), PDO::PARAM_STR);
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
    
    public function update(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "update dia_diaria_historico "
                        . "set id_diaria = :id_diaria, "
                        . "id_pessoa = :id_pessoa, "
                        . "ds_diaria_historico = :ds_diaria_historico "
                        . "where id_diaria_historico = :id_diaria_historico";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria", $this->getIdDiaria(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":ds_diaria_historico", $this->getDsDiariaHistorico(), PDO::PARAM_STR);
                $stmt->bindValue(":id_diaria_historico", $this->getIdDiariaHistorico(), PDO::PARAM_INT);
                
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

    public function delete(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "delete from dia_diaria_historico where id_diaria_historico = :id_diaria_historico";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria_historico",$this->getIdDiariaHistorico(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function historico(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT id_diaria_historico,
                                ddh.id_diaria,
                                ddh.id_pessoa,
                                p.nm_pessoa,
                                dh_diaria_historico,
                                ds_diaria_historico
                         FROM dia_diaria_historico ddh,
                              ses_pessoa p
                         WHERE p.id_pessoa = ddh.id_pessoa
                           AND ddh.id_diaria = :id_diaria order by dh_diaria_historico desc";
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindValue(":id_diaria", $this->getIdDiaria(),PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
            
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
}

