<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinDocParmTramitacao.class.php";

class DaoFinDocParmTramitacao extends FinDocParmTramitacao {

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
                $sql = "insert into fin_doc_parm_tramitacao (id_doc_tipo_remetente, id_doc_tipo_destinatario, id_documento_situacao, tp_doc_parm_tramitacao) values (:id_doc_tipo_remetente,:id_doc_tipo_destinatario,:id_documento_situacao, :tp_doc_parm_tramitacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_doc_tipo_remetente', $this->getIdDocTipoRemetente(), PDO::PARAM_INT);
                $stmt->bindValue(':id_doc_tipo_destinatario', $this->getIdDocTipoDestinatario(), PDO::PARAM_INT);
                $stmt->bindValue(':id_documento_situacao', $this->getIdDocumentoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(':tp_doc_parm_tramitacao', $this->getTpDocParmTramitacao(), PDO::PARAM_STR);
                
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
                $sql = "delete from fin_doc_parm_tramitacao where id_doc_parm_tramitacao = :id_doc_parm_tramitacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_parm_tramitacao",$this->getIdDocParmTramitacao(), PDO::PARAM_INT);
                $this->sucesso = $stmt->execute();
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function retornaTodosParmTipoLotacao(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select
                        id_doc_parm_tramitacao,
                        id_doc_tipo_remetente,
                        id_doc_tipo_destinatario,
                        tp_doc_parm_tramitacao,
                        id_documento_situacao 
                     from
                        fin_doc_parm_tramitacao 
                     where
                        (
                           id_doc_tipo_remetente = :id_doc_tipo_remetente 
                           or id_doc_tipo_destinatario = :id_doc_tipo_destinatario
                        )";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_doc_tipo_remetente', $this->getIdDocTipoRemetente(), PDO::PARAM_INT);
                $stmt->bindValue(':id_doc_tipo_destinatario', $this->getIdDocTipoDestinatario(), PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
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
                            id_doc_parm_tramitacao,
                            remetente.id_doc_tipo_lotacao as id_tipo_remetente,
                            remetente.nm_doc_tipo_lotacao as nm_tipo_remetente,
                            destinatario.id_doc_tipo_lotacao as id_tipo_destinatario,
                            destinatario.nm_doc_tipo_lotacao as nm_tipo_destinatario,
                            situacao.id_documento_situacao,
                            situacao.nm_situacao,
                            case
                               when
                                  tramite.tp_doc_parm_tramitacao = '1' 
                               then
                                  'Encaminhar' 
                               when
                                  tramite.tp_doc_parm_tramitacao = '2' 
                               then
                                  'Receber' 
                            end
                            as tramitacao 
                         from
                            fin_doc_parm_tramitacao as tramite 
                            inner join
                               fin_doc_tipo_lotacao as remetente 
                               on tramite.id_doc_tipo_remetente = remetente.id_doc_tipo_lotacao 
                            inner join
                               fin_doc_tipo_lotacao as destinatario 
                               on tramite.id_doc_tipo_destinatario = destinatario.id_doc_tipo_lotacao 
                            inner join
                               fin_documento_situacao as situacao 
                               on situacao.id_documento_situacao = tramite.id_documento_situacao " . $this->filtroSql();
                $stmt = $pdo->prepare($sql);
                
                if($this->getIdDocParmTramitacao()){
                    $stmt->bindValue(":id_doc_parm_tramitacao", $this->getIdDocParmTramitacao(), PDO::PARAM_INT);
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
                
                if ($this->getTpDocParmTramitacao()) {
                    $stmt->bindValue(":tp_doc_parm_tramitacao", $this->getTpDocParmTramitacao(), PDO::PARAM_STR);
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
        
        if ($this->getIdDocParmTramitacao()) {
            $filtro .= empty($filtro) ? " where id_doc_parm_tramitacao = :id_doc_parm_tramitacao " : " and id_doc_parm_tramitacao = :id_doc_parm_tramitacao " ;
        }
        
        if ($this->getIdDocTipoRemetente()) {
            $filtro .= empty($filtro) ? " where id_doc_tipo_remetente = :id_doc_tipo_remetente " : " and id_doc_tipo_remetente = :id_doc_tipo_remetente ";
        }
        
        if ($this->getIdDocTipoDestinatario()) {
            $filtro .= empty($filtro) ? " where id_doc_tipo_destinatario = :id_doc_tipo_destinatario " : " and id_doc_tipo_destinatario = :id_doc_tipo_destinatario ";
        }
        
        if ($this->getIdDocumentoSituacao()) {
            $filtro .= empty($filtro) ? " where id_documento_situacao = :id_documento_situacao " : " and id_documento_situacao = :id_documento_situacao ";
        }
        
        if($this->getTpDocParmTramitacao()){
            $filtro .= empty($filtro) ? " where tp_doc_parm_tramitacao = :tp_doc_parm_tramitacao " : " and tp_doc_parm_tramitacao = :tp_doc_parm_tramitacao ";
        }
        
        return $filtro;
    }

}
