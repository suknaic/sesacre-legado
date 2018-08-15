<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinDocVincEncaminhamento.class.php";


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
                $sql = "insert into fin_doc_vinc_encaminhamento (id_pessoa, id_lotacao, id_doc_tipo_lotacao) values (:id_pessoa,:id_lotacao,:id_doc_tipo_lotacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_pessoa', $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(':id_lotacao', $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(':id_doc_tipo_lotacao', $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
                
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
                $sql = "select
                            id_doc_vinc_encaminhamento,
                            fdve.id_doc_tipo_lotacao,
                            fdtl.nm_doc_tipo_lotacao,
                            fdve.id_pessoa,
                            sp.nm_pessoa,
                            fdve.id_lotacao,
                            sl.nm_lotacao,
                            '1' as tramitacao 
                         from
                            fin_doc_vinc_encaminhamento as fdve,
                            fin_doc_tipo_lotacao as fdtl,
                            ses_pessoa as sp,
                            ses_lotacao as sl 
                         where
                            fdve.id_doc_tipo_lotacao = fdtl.id_doc_tipo_lotacao 
                            and fdve.id_pessoa = sp.id_pessoa 
                            and fdve.id_lotacao = sl.id_lotacao
                            ". $this->filtroSql() . "
                         order by fdtl.nm_doc_tipo_lotacao, sl.nm_lotacao, sp.nm_pessoa";
                $stmt = $pdo->prepare($sql);
                
                if($this->getIdDocVincEncaminhamento()){
                    $stmt->bindValue(":id_doc_vinc_encaminhamento", $this->getIdDocVincEncaminhamento(), PDO::PARAM_INT);
                }
                
                if ($this->getIdDocTipoLotacao()) {
                    $stmt->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
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
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function filtroSql(){
        $filtro = "";
        
        if ($this->getIdDocVincEncaminhamento()) {
            $filtro .= " and fdve.id_doc_vinc_encaminhamento = :id_doc_vinc_encaminhamento ";
        }
        
        if ($this->getIdDocTipoLotacao()) {
            $filtro .= " and fdve.id_doc_tipo_lotacao = :id_doc_tipo_lotacao ";
        }
        
        if ($this->getIdPessoa()) {
            $filtro .= " and fdve.id_pessoa = :id_pessoa ";
        }
        
        if ($this->getIdLotacao()) {
            $filtro .= " and fdve.id_lotacao = :id_lotacao ";
        }
        
        return $filtro;
    }
}

