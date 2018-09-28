<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/FinContItensGrupoTb.class.php";

class DaoFinContItensGrupo extends FinContItensGrupoTb {
    
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
            $result = $pdo->prepare("INSERT INTO fin_cont_itens_grupo (dh_cont_itens_grupo) "
                    . " VALUES (now())");                                                                                           
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }    
    
    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM fin_cont_itens_grupo "
                    . " WHERE id_cont_itens_grupo = :idContItensGrupo");
            $result->bindValue(":idContItensGrupo", $this->getIdContItensGrupo(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }   
                                
}