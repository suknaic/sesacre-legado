<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/liquidacao/ConLiquidacaoHistorico.class.php";

class DaoConLiquidacaoHistorico extends ConLiquidacaoHistorico{
    
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
            $result = $pdo->prepare("INSERT INTO con_liquidacao_historico (id_liquidacao ,id_pessoa, id_lotacao, id_doc_tipo_lotacao, id_liquidacao_status ,id_liquidacao_situacao, ds_liquidacao)"                    
                    . " VALUES (:id_liquidacao,:id_pessoa, :id_lotacao, :id_doc_tipo_lotacao, :id_liquidacao_status ,:id_liquidacao_situacao, :ds_liquidacao);");                                                            
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);            
            $result->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);            
            $result->bindValue(":id_liquidacao_status", $this->getIdLiquidacaoStatus(), PDO::PARAM_INT);
            $result->bindValue(":id_liquidacao_situacao", $this->getIdLiquidacaoSituacao(), PDO::PARAM_INT);            
            $result->bindValue(":ds_liquidacao", $this->getDsLiquidacao(), PDO::PARAM_STR);    
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
                (to_char(dh_liquidacao_historico, 'dd/mm/yyyy hh24:mi:ss') || ' - ' || pes.nm_pessoa || ': ' || liqSit.nm_liquidacao_situacao || ' pelo(a) ' || lot.nm_lotacao || '. ' || 
                   case
                      when
                         (hst.ds_liquidacao is null or hst.ds_liquidacao = '')
                      then
                         '' 
                      else
                         'Justificativa: ' || hst.ds_liquidacao 
                   end
                ) as historico 
                from
                   con_liquidacao as liq 
                   inner join
                      con_liquidacao_historico as hst 
                      on hst.id_liquidacao = liq.id_liquidacao 
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
                      con_liquidacao_situacao as liqSit 
                      on liqSit.id_liquidacao_situacao = hst.id_liquidacao_situacao 
                where
                   liq.id_liquidacao = :id_liquidacao";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {            
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage(); 
        }
    }
}

