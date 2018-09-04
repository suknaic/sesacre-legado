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
        try {                      
            $result = $pdo->prepare("INSERT INTO con_liquidacao_historico (id_pessoa, id_lotacao, id_doc_tipo_lotacao, id_liquidacao_situacao, ds_liquidacao)"                    
                    . " VALUES (:id_pessoa, :id_lotacao, :id_doc_tipo_lotacao, :id_liquidacao_situacao, :ds_liquidacao);");                                                            
            $result->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);            
            $result->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);            
            $result->bindValue(":id_liquidacao_situacao", $this->getIdLiquidacaoSituacao(), PDO::PARAM_INT);            
            $result->bindValue(":ds_liquidacao", $this->getDsLiquidacao(), PDO::PARAM_STR);    
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }            
    

    
//    function retorna($pdo){
//        $this->sucesso = false;
//        $sql = " SELECT *"                    
//                . " FROM con_liquidacao_historico"
//                . " WHERE id_liquidacao_historico = :id_liquidacao_historico";
//        try {
//            $result = $pdo->prepare($sql);            
//            $result->bindValue(":id_liquidacao_historico", $this->getIdLiquidacaoHistorico(), PDO::PARAM_INT);
//            $result->execute();
//            if ($result->rowCount() >= 1){
//                $this->sucesso = true; 
//                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
//            } else {
//                $this->sucesso = false;                
//                $this->msgRetorno = "Não encontrou Registros";                
//            }            
//        } catch (PDOException $e) {
//            $this->sucesso = false;            
//            $this->msgRetorno = $e->getMessage(); 
//        }
//    }   
//    
//    function retornaPorPessoa($pdo){
//        $this->sucesso = false;
//        $sql = " SELECT id_liquidacao_pes_lot, id_pessoa, id_lotacao"                    
//                . " FROM con_liquidacao_pes_lot"
//                . " WHERE id_pessoa = :id_pessoa";
//        try {
//            $result = $pdo->prepare($sql);            
//            $result->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
//            $result->execute();
//            if ($result->rowCount() >= 1){
//                $this->sucesso = true; 
//                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
//            } else {
//                $this->sucesso = false;                
//                $this->msgRetorno = "Não encontrou Registros";                
//            }            
//        } catch (PDOException $e) {
//            $this->sucesso = false;            
//            $this->msgRetorno = $e->getMessage(); 
//        }
//    }   
//    
//    function retornaPorLotacao($pdo){
//        $this->sucesso = false;
//        $sql = " SELECT id_liquidacao_pes_lot, id_pessoa, id_lotacao"                    
//                . " FROM con_liquidacao_pes_lot"
//                . " WHERE id_lotacao = :id_lotacao";
//        try {
//            $result = $pdo->prepare($sql);            
//            $result->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
//            $result->execute();
//            if ($result->rowCount() >= 1){
//                $this->sucesso = true; 
//                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
//            } else {
//                $this->sucesso = false;                
//                $this->msgRetorno = "Não encontrou Registros";                
//            }            
//        } catch (PDOException $e){
//            $this->sucesso = false;            
//            $this->msgRetorno = $e->getMessage(); 
//        }
//    }
}

