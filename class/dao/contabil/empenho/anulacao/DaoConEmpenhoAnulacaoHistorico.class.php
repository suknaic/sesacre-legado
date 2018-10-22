<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/empenho/anulacao/ConEmpenhoAnulacaoHistorico.class.php";

class DaoConEmpenhoAnulacaoHistorico extends ConEmpenhoAnulacaoHistorico {

    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno(){
        return $this->msgRetorno;
    }   
 
    function getSucesso(){
        return $this->sucesso;
    }
    
    function insert(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "INSERT INTO con_empenho_anulacao_historico (id_empenho_anulacao ,id_empenho_anulacao_situacao, id_empenho_anulacao_status, id_pessoa, ds_empenho_anulacao_historico,id_lotacao, id_doc_tipo_lotacao)"                    
                    . " VALUES (:id_empenho_anulacao,:id_empenho_anulacao_situacao, :id_empenho_anulacao_status, :id_pessoa, :ds_empenho_anulacao_historico, :id_lotacao, :id_doc_tipo_lotacao);";
        try {                      
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);                                                            
                $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_empenho_anulacao_situacao", $this->getIdEmpenhoAnulacaoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_empenho_anulacao_status", $this->getIdEmpenhoAnulacaoStatus(), PDO::PARAM_INT);            
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);            
                $stmt->bindValue(":ds_empenho_anulacao_historico", $this->getDsEmpenhoAnulacaoHistorico(), PDO::PARAM_INT);
                $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true; 
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }           
        } catch (PDOException $e) {         
            $this->msgRetorno = $e->getMessage();            
        }
    }
    
    function lista(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select
                    (to_char(dh_empenho_anulacao_historico, 'dd/mm/yyyy hh24:mi:ss') || ' - ' || nm_pessoa || ': ' anuEmpSit.nm_empenho_anulacao_situacao || ' pelo(a)  ' || lotacao.nm_lotacao || '. Justificativa: ' || anuEmpHst.ds_empenho_anulacao_historico) as historico 
                 from
                    con_empenho_anulacao_historico anuEmpHst 
                    inner join
                       ses_pessoa pessoa 
                       on pessoa.id_pessoa = anuEmpHst.id_pessoa
                    inner join
                       ses_lotacao lotacao
                       on lotacao.id_lotacao = anuEmpHst.id_lotacao
                    left join
                       con_empenho_anulacao_situacao anuEmpSit 
                       on anuEmpSit.id_empenho_anulacao_situacao = anuEmpHst.id_empenho_anulacao_situacao 
                    left join
                       con_empenho_anulacao_status anuEmpSts 
                       on anuEmpSts.id_empenho_anulacao_status = anuEmpHst.id_empenho_anulacao_status
                 where anuEmpHst.id_empenho_anulacao = :id_empenho_anulacao
                 order by anuEmpHst.id_empenho_anulacao_historico";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Sem conexão com o banco de dados.';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();    
        }
    }
    
}