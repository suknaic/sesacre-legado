<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinDocDestinatario.class.php";

class DaoFinDocDestinatario extends FinDocDestinatario {

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
                $sql = "insert into fin_doc_destinatario (id_lotacao,id_doc_tipo_destinatario) values (:id_lotacao,:id_doc_tipo_destinatario)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_doc_tipo_destinatario", $this->getIdDocTipoDestinatario(), PDO::PARAM_INT);
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
                $sql = "delete from fin_doc_destinatario where id_doc_destinatario = :id_doc_destinatario";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_destinatario", $this->getIdDocDestinatario(), PDO::PARAM_INT);
                
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
                $sql = "select 
                                id_doc_destinatario,
                                fdtd.id_doc_tipo_destinatario, 
                                nm_doc_tipo_destinatario,
                                sl.id_lotacao,
                                nm_lotacao
                        from 
                                fin_doc_destinatario fdd,
                                fin_doc_tipo_destinatario fdtd,
                                ses_lotacao sl
                        where
                                fdd.id_doc_tipo_destinatario = fdtd.id_doc_tipo_destinatario
                        and	fdd.id_lotacao = sl.id_lotacao ". $this->filtroSql() . " order by id_doc_destinatario";
                $stmt = $pdo->prepare($sql);
                
                if($this->getIdDocDestinatario()){
                    $stmt->bindValue(":id_doc_destinatario", $this->getIdDocDestinatario(), PDO::PARAM_INT);
                }
                
                if ($this->getIdDocTipoDestinatario()) {
                    $stmt->bindValue(":id_doc_tipo_destinatario", $this->getIdDocTipoDestinatario(), PDO::PARAM_INT);
                }

                if ($this->getIdLotacao()) {
                    $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
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
                $sql = "select * from fin_doc_destinatario where id_doc_destinatario = :id_doc_destinatario";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_destinatario", $this->getIdDocDestinatario(), PDO::PARAM_INT);
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
        
        if ($this->getIdDocDestinatario()) {
            $filtro .= " and id_doc_destinatario = :id_doc_destinatario";
        }
        
        if ($this->getIdDocTipoDestinatario()) {
            $filtro .= " and fdd.id_doc_tipo_destinatario = :id_doc_tipo_destinatario";
        }
        
        if ($this->getIdLotacao()) {
            $filtro .= " and fdd.id_lotacao = :id_lotacao";
        }
        
        return $filtro;
    }


}

