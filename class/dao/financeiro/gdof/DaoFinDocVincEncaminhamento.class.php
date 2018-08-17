<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinDocVincEncaminhamento.class.php";


class DaoFinDocVincEncaminhamento extends FinDocVincEncaminhamento {

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
                $sql = "insert into fin_doc_vinc_encaminhamento (id_pessoa, id_doc_lotacao) values (:id_pessoa,:id_doc_lotacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_pessoa', $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(':id_doc_lotacao', $this->getIdDocLotacao(), PDO::PARAM_INT);
                
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
                $sql = "delete from fin_doc_vinc_encaminhamento where id_doc_vinc_encaminhamento = :id_doc_vinc_encaminhamento";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_doc_vinc_encaminhamento",$this->getIdDocVincEncaminhamento(), PDO::PARAM_INT);
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
                //Filtro para indicar se é '1 - Encaminhar' ou '2 - Receber'.
                //Como o resultado da consulta é referente ao union de 2 tabelas(fin_doc_vinc_encaminhamento e fin_doc_vinc_recebimento)
                //foi adicionado esse filtro que é passado por parametro
                $filtroTipo = "";
                if($idTipoTramitacao > 0) {
                    $filtroTipo = " where id_tipo_tramitacao = :id_tipo_tramitacao ";
                }
                
                $sql = "with encaminhamento_recebimento as 
                        (
                           select
                              id_doc_vinc_encaminhamento as id_tramitacao,
                              fdl.id_doc_lotacao,
                              fdl.id_doc_tipo_lotacao,
                              fdtl.nm_doc_tipo_lotacao,
                              fdve.id_pessoa,
                              sp.nm_pessoa,
                              fdl.id_lotacao,
                              sl.nm_lotacao,
                              1 as id_tipo_tramitacao,
                              'Encaminhar' as ds_tramitacao 
                           from
                              fin_doc_vinc_encaminhamento as fdve,
                              fin_doc_lotacao as fdl,
                              fin_doc_tipo_lotacao as fdtl,
                              ses_pessoa as sp,
                              ses_lotacao as sl 
                           where
                              fdve.id_doc_lotacao = fdl.id_doc_lotacao 
                              and fdl.id_lotacao = sl.id_lotacao 
                              and fdve.id_pessoa = sp.id_pessoa 
                              and fdl.id_doc_tipo_lotacao = fdtl.id_doc_tipo_lotacao 
                           Union All
                           select
                              id_doc_vinc_recebimento as id_tramitacao,
                              fdl.id_doc_lotacao,
                              fdl.id_doc_tipo_lotacao,
                              fdtl.nm_doc_tipo_lotacao,
                              fdvr.id_pessoa,
                              sp.nm_pessoa,
                              fdl.id_lotacao,
                              sl.nm_lotacao,
                              2 as id_tipo_tramitacao,
                              'Receber' as ds_tramitacao 
                           from
                              fin_doc_vinc_recebimento as fdvr,
                              fin_doc_lotacao as fdl,
                              fin_doc_tipo_lotacao as fdtl,
                              ses_pessoa as sp,
                              ses_lotacao as sl 
                           where
                              fdvr.id_doc_lotacao = fdl.id_doc_lotacao 
                              and fdl.id_lotacao = sl.id_lotacao 
                              and fdvr.id_pessoa = sp.id_pessoa 
                              and fdl.id_doc_tipo_lotacao = fdtl.id_doc_tipo_lotacao 
                        )
                        select
                           * 
                        from
                           encaminhamento_recebimento " . $this->filtroSql($filtroTipo) . " order by nm_lotacao,nm_pessoa,ds_tramitacao";
                $stmt = $pdo->prepare($sql);
                
                if ($idTipoTramitacao > 0) { //Indica se é '1 - Encaminhar' ou '2 - Receber'
                    $stmt->bindValue(":id_tipo_tramitacao",$idTramitacao,PDO::PARAM_INT);
                }
                
                if($this->getIdDocVincEncaminhamento()){
                    $stmt->bindValue(":id_tramitacao", $this->getIdDocVincEncaminhamento(), PDO::PARAM_INT);
                }
                
                if ($this->getIdDocLotacao()) {
                    $stmt->bindValue(":id_doc_lotacao", $this->getIdDocLotacao(), PDO::PARAM_INT);
                }

                if ($this->getIdPessoa()) {
                    $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
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
    
    function filtroSql(string $filtro = ""){
        
        if ($this->getIdDocVincEncaminhamento()) {
            $filtro .= empty($filtro) ? " where id_tramitacao = :id_tramitacao " : " and id_tramitacao = :id_tramitacao ";
        }
        
        if ($this->getIdDocLotacao()) {
            $filtro .= empty($filtro) ? " where id_doc_lotacao = :id_doc_lotacao " : " and id_doc_lotacao = :id_doc_lotacao ";
        }
        
        if ($this->getIdPessoa()) {
            $filtro .= empty($filtro) ? " where id_pessoa = :id_pessoa " : " and id_pessoa = :id_pessoa ";
        }

        
        return $filtro;
    }
}

