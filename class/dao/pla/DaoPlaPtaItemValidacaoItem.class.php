<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPtaItemValidacaoItem.class.php";

class DaoPlaPtaItemValidacaoItem extends PlaPtaItemValidacaoItem {
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
       
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_pta_item_validacao_item (id_pta_item"
                    . " , id_lotacao, id_pessoa) "
                    . " VALUES (:idPtaItem, :idLotacao, :idPessoa)");            
            $result->bindValue(":idPtaItem", $this->getIdPtaItem(), PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);            
            
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }                   
    
    
}
