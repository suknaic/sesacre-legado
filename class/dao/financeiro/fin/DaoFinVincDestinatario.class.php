<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinVincDestinatario.class.php";


class DaoFinVincDestinatario extends FinVincDestinatario {

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
                $sql = "insert into fin_vinc_destinatario (id_pessoa, id_lotacao, id_doc_tipo_destinatario) values (:id_pessoa,:id_lotacao,:id_doc_tipo_destinatario)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_pessoa', $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(':id_lotacao', $this->getIdLotacao(), PDO::PARAM_INT);
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
                $sql = "delete from fin_vinc_destinatario where id_vinc_destinatario = :id_vinc_destinatario";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_vinc_destinatario",$this->getIdVincDestinatario(), PDO::PARAM_INT);
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
                            id_vinc_destinatario,
                            fvd.id_doc_tipo_destinatario,
                            fdtd.nm_doc_tipo_destinatario,
                            fvd.id_pessoa,
                            sp.nm_pessoa,
                            fvd.id_lotacao,
                            sl.nm_lotacao 
                         from
                            fin_vinc_destinatario as fvd,
                            fin_doc_tipo_destinatario as fdtd,
                            ses_pessoa as sp,
                            ses_lotacao as sl 
                         where
                            fvd.id_doc_tipo_destinatario = fdtd.id_doc_tipo_destinatario 
                            and fvd.id_pessoa = sp.id_pessoa 
                            and fvd.id_lotacao = sl.id_lotacao
                            ". $this->filtroSql() . "
                         order by fdtd.nm_doc_tipo_destinatario, sl.nm_lotacao, sp.nm_pessoa";
                $stmt = $pdo->prepare($sql);
                
                if($this->getIdVincDestinatario()){
                    $stmt->bindValue(":id_vinc_destinatario", $this->getIdVincDestinatario(), PDO::PARAM_INT);
                }
                
                if ($this->getIdDocTipoDestinatario()) {
                    $stmt->bindValue(":id_doc_tipo_destinatario", $this->getIdDocTipoDestinatario(), PDO::PARAM_INT);
                }

                if ($this->getIdPessoa()) {
                    $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
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
    
    function filtroSql(){
        $filtro = "";
        
        if ($this->getIdVincDestinatario()) {
            $filtro .= " and fvd.id_vinc_destinatario = :id_vinc_destinatario ";
        }
        
        if ($this->getIdDocTipoDestinatario()) {
            $filtro .= " and fvd.id_doc_tipo_destinatario = :id_doc_tipo_destinatario ";
        }
        
        if ($this->getIdPessoa()) {
            $filtro .= " and fvd.id_pessoa = :id_pessoa ";
        }
        
        if ($this->getIdLotacao()) {
            $filtro .= " and fvd.id_lotacao = :id_lotacao ";
        }
        
        return $filtro;
    }
}

