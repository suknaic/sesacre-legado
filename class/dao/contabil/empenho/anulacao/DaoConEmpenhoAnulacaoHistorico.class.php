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
        $sql = "INSERT INTO con_empenho_anulacao_historico (id_empenho_anulacao ,id_empenho_anulacao_situacao, id_empenho_anulacao_status, id_pessoa, ds_empenho_anulacao_historico)"                    
                    . " VALUES (:id_empenho_anulacao,:id_empenho_anulacao_situacao, :id_empenho_anulacao_status, :id_pessoa, :ds_empenho_anulacao_historico);";
        try {                      
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);                                                            
                $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_empenho_anulacao_situacao", $this->getIdEmpenhoAnulacaoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_empenho_anulacao_status", $this->getIdEmpenhoAnulacaoStatus(), PDO::PARAM_INT);            
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);            
                $stmt->bindValue(":ds_empenho_anulacao_historico", $this->getDsEmpenhoAnulacaoHistorico(), PDO::PARAM_INT);            
                $stmt->execute();
                $this->sucesso = true; 
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }           
        } catch (PDOException $e) {         
            $this->msgRetorno = $e->getMessage();            
        }
    }
    

}