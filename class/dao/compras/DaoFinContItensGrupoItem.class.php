<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/FinContItensGrupoItemTb.class.php";

class DaoFinContItensGrupoItem extends FinContItensGrupoItemTb {
    
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
            $result = $pdo->prepare("INSERT INTO fin_cont_itens_grupo_item (id_cont_itens_grupo, id_cont_itens) "
                    . " VALUES (:idContItensGrupo, :idContItens)");                                        
            $result->bindValue(":idContItensGrupo", $this->getIdContItensGrupo(), PDO::PARAM_INT);                                       
            $result->bindValue(":idContItens", $this->getIdContItens(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }    

    
    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM fin_cont_itens_grupo_item "
                    . " WHERE id_cont_itens_grupo_item = :id_cont_itens_grupo_item");
            $result->bindValue(":id_cont_itens_grupo_item", $this->getIdContItensGrupoItem(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }                                    

}