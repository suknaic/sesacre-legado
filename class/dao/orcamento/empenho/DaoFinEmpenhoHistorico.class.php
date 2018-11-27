<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/orcamento/empenho/FinEmpenhoHistoricoTb.class.php";

class DaoFinEmpenhoHistorico extends FinEmpenhoHistoricoTb{
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno(){
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    
    
    function insert($pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        try {                      
            $result = $pdo->prepare("INSERT INTO fin_empenho_historico (id_empenho ,id_pessoa, id_lotacao, id_doc_tipo_lotacao, id_empenho_situacao, id_empenho_status, ds_empenho_historico)"                    
                    . " VALUES (:id_empenho,:id_pessoa, :id_lotacao, :id_doc_tipo_lotacao, :id_empenho_situacao, :id_empenho_status, :ds_empenho_historico);");                                                            
            $result->bindValue(":id_empenho", $this->getIdEmpenho(), PDO::PARAM_INT);
            $result->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);            
            $result->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);            
            $result->bindValue(":id_empenho_situacao", $this->getIdEmpenhoSituacao(), PDO::PARAM_INT);      
            $result->bindValue(":id_empenho_status", $this->getIdEmpenhoStatus(), PDO::PARAM_INT);
            $result->bindValue(":ds_empenho_historico", $this->getDsEmpenhoHistorico(), PDO::PARAM_STR);    
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();            
        }
    }
    
    function historico($pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select
                (to_char(dh_empenho_historico, 'dd/mm/yyyy hh24:mi:ss') || ' - ' || pes.nm_pessoa || ': ' || 
                empSit.nm_empenho_situacao || ' pelo(a) ' || lot.nm_lotacao || '. ' || 
                   case
                      when
                         (hst.ds_empenho_historico is null or hst.ds_empenho_historico = '')
                      then
                         '' 
                      else
                         'Justificativa: ' || hst.ds_empenho_historico 
                   end) as historico 
                from
                   fin_empenho as emp 
                   inner join
                      fin_empenho_historico as hst 
                      on hst.id_empenho = emp.id_empenho 
                   inner join
                      ses_pessoa as pes 
                      on pes.id_pessoa = hst.id_pessoa 
                   inner join
                      ses_lotacao as lot 
                      on lot.id_lotacao = hst.id_lotacao 
                   inner join
                      fin_doc_tipo_lotacao as tipoLot 
                      on tipoLot.id_doc_tipo_lotacao = hst.id_doc_tipo_lotacao 
                   inner join
                      fin_empenho_situacao as empSit 
                      on empSit.id_empenho_situacao = hst.id_empenho_situacao
                where emp.id_empenho = :id_empenho";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_empenho", $this->getIdEmpenho(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {            
                $this->msgRetorno = "Nenhum histórico registrado.";                
            }            
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage(); 
        }
    }
}

