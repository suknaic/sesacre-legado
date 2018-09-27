<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/FinContItensSaldoTb.class.php";

class DaoFinContItensSaldo extends FinContItensSaldoTb {
    
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
            $result = $pdo->prepare("INSERT INTO fin_cont_itens_saldo (id_cont_itens_grupo, id_cont_itens"
                    . " , id_cont_itens_original, vl_cont_itens_saldo, ds_cont_itens_saldo) "
                    . " VALUES (:id_cont_itens_grupo, :id_cont_itens, :id_cont_itens_original"
                    . " , :vl_cont_itens_saldo, :ds_cont_itens_saldo)");                                        
            $result->bindValue(":id_cont_itens_grupo", $this->getIdContItensGrupo(), PDO::PARAM_INT);                                        
            $result->bindValue(":id_cont_itens", $this->getIdContItens(), PDO::PARAM_INT);  
            $result->bindValue(":id_cont_itens_original", $this->getIdContItensOriginal(), PDO::PARAM_INT);  
            $result->bindValue(":vl_cont_itens_saldo", $this->getVlContItensSaldo(), PDO::PARAM_STR);  
            $result->bindValue(":ds_cont_itens_saldo", $this->getDsContItensSaldo(), PDO::PARAM_STR);  
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }    
//    
//    function update($pdo) {
//        try {
//            $result = $pdo->prepare("UPDATE fin_qdd SET aa_qdd = :aaQdd "
//                    . "WHERE id_qdd = :idQdd ");
//            $result->bindValue(":aaQdd", $this->getAaQdd(), PDO::PARAM_INT);
//            $result->bindValue(":idQdd", $this->getIdQdd(), PDO::PARAM_INT);
//            $result->execute();
//            $this->sucesso = true; 
//        } catch (PDOException $e) {
//            $this->sucesso = false;           
//            $this->msgRetorno = $e->getMessage(); 
//        }
//    }
//    
//    function delete($pdo) {
//        try {
//            $result = $pdo->prepare("DELETE FROM fin_qdd WHERE id_qdd = :idQdd");
//            $result->bindValue(":idQdd", $this->getIdQdd(), PDO::PARAM_INT);
//            $result->execute();
//            $this->sucesso = true; 
//        } catch (PDOException $e) {
//            $this->sucesso = false;            
//            $this->msgRetorno = $e->getMessage(); 
//        }
//    }   
    
    function retornaUltimoGrupoParaContItensOriginal($pdo) {
        $this->sucesso = false;

        $sql = " SELECT id_cont_itens_grupo"                    
                . " FROM fin_cont_itens_saldo"
                . " WHERE id_cont_itens_original = :idContItensOriginal"
                . " ORDER BY id_cont_itens_grupo DESC"
                . " LIMIT 1";
        try {
            $result = $pdo->prepare($sql);    
            $result->bindValue(":idContItensOriginal", $this->getIdContItensOriginal(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }   
    
    function retornaPorContItensOriginal($pdo) {
        $this->sucesso = false;

        $sql = " SELECT id_cont_itens_saldo, id_cont_itens_grupo, id_cont_itens"
                . " , id_cont_itens_original, vl_cont_itens_saldo, dh_cont_itens_saldo"
                . " , ds_cont_itens_saldo"                    
                . " FROM fin_cont_itens_saldo"
                . " WHERE id_cont_itens_original = :idContItensOriginal";                
        try {
            $result = $pdo->prepare($sql);    
            $result->bindValue(":idContItensOriginal", $this->getIdContItensOriginal(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    } 
    
    function retornaPorContItensOriginalGrupo($pdo) {
        $this->sucesso = false;

        $sql = " SELECT id_cont_itens_saldo, id_cont_itens_grupo, id_cont_itens"
                . " , id_cont_itens_original, vl_cont_itens_saldo, dh_cont_itens_saldo"
                . " , ds_cont_itens_saldo"                    
                . " FROM fin_cont_itens_saldo"
                . " WHERE id_cont_itens_original = :idContItensOriginal"
                . " AND id_cont_itens_grupo = :idContItensGrupo";                
        try {
            $result = $pdo->prepare($sql);    
            $result->bindValue(":idContItensOriginal", $this->getIdContItensOriginal(), PDO::PARAM_INT);
            $result->bindValue(":idContItensGrupo", $this->getIdContItensGrupo(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
       
    
       
        
}