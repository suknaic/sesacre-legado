<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinDocTramitacao.class.php";

class DaoFinDocTramitacao extends FinDocTramitacao {

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
                $sql = "insert into fin_doc_tramitacao (id_doc_tipo_remetente, id_doc_tipo_destinatario, id_documento_situacao, tp_doc_tramitacao) values (:id_doc_tipo_remetente,:id_doc_tipo_destinatario,:id_documento_situacao, :tp_doc_tramitacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_doc_tipo_remetente', $this->getIdDocTipoRemetente(), PDO::PARAM_INT);
                $stmt->bindValue(':id_doc_tipo_destinatario', $this->getIdDocTipoDestinatario(), PDO::PARAM_INT);
                $stmt->bindValue(':id_documento_situacao', $this->getIdDocumentoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(':tp_doc_tramitacao', $this->getTpDocTramitacao(), PDO::PARAM_STR);
                
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function delete(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "delete from fin_doc_tramitacao where id_doc_tramitacao = :id_doc_tramitacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_tramitacao",$this->getIdDocTramitacao(), PDO::PARAM_INT);
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
                            id_doc_tramitacao,
                            remetente.id_doc_tipo_lotacao,
                            remetente.nm_doc_tipo_lotacao,
                            destinatario.id_doc_tipo_lotacao,
                            destinatario.nm_doc_tipo_lotacao,
                            situacao.id_documento_situacao,
                            situacao.nm_documento_sitacao,
                            tramite.tp_doc_tramite 
                         from
                            fin_doc_tramitacao as tramite 
                            inner join
                               fin_doc_tipo_lotacao as remetente 
                               on tramite.id_doc_tipo_remetente = remetente.id_doc_tipo_lotacao 
                            inner join
                               fin_doc_tipo_lotacao as destinatario 
                               on tramite.id_doc_tipo_destinatario = destinatario.id_doc_tipo_lotacao 
                            inner join
                               fin_documento_situacao as situacao 
                               on situacao.id_documento_situacao = tramite.id_documento_situacao";
                $stmt = $pdo->prepare($sql);
                
                if($this->getIdDocTramitacao()){
                    $stmt->bindValue(":id_doc_tramitacao", $this->getIdDocTramitacao(), PDO::PARAM_INT);
                }
                
                if ($this->getIdDocTipoRemetente()) {
                    $stmt->bindValue(":id_doc_tipo_remetente", $this->getIdDocTipoRemetente(), PDO::PARAM_INT);
                }

                 if ($this->getIdDocTipoDestinatario()) {
                    $stmt->bindValue(":id_doc_tipo_destinatario", $this->getIdDocTipoDestinatario(), PDO::PARAM_INT);
                }
                
                if ($this->getIdDocumentoSituacao()) {
                    $stmt->bindValue(":id_documento_situacao", $this->getIdDocumentoSituacao(), PDO::PARAM_INT);
                }
                
                if ($this->getTpDocTramitacao()) {
                    $stmt->bindValue(":tp_doc_tramitacao", $this->getTpDocTramitacao(), PDO::PARAM_STR);
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
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function filtroSql(){
        $filtro = "";
        
        if ($this->getIdDocTramitacao()) {
            $filtro .= " and id_doc_tramitacao = :id_doc_tramitacao ";
        }
        
        if ($this->getIdDocTipoRemetente()) {
            $filtro .= " and id_doc_tipo_remetente = :id_doc_tipo_remetente ";
        }
        
        if ($this->getIdDocTipoDestinatario()) {
            $filtro .= " and id_doc_tipo_destinatario = :id_doc_tipo_destinatario ";
        }
        
        if ($this->getIdDocumentoSituacao()) {
            $filtro .= " and id_documento_situacao = :id_documento_situacao ";
        }
        
        if($this->getTpDocTramitacao()){
            $filtro .= " and tp_doc_tramitacao = :tp_doc_tramitacao ";
        }
        
        return $filtro;
    }

}
