<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPreLoa.class.php";

class DaoPlaPreLoa extends PlaPreLoa {
    
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
            $result = $pdo->prepare("INSERT INTO pla_pre_loa (aa_pre_loa"
                    . " , st_pre_loa) "                                        
                    . " VALUES (:aaPreLoa, :stPreLoa)");                                        
            $result->bindValue(":aaPreLoa", $this->getAaPreLoa(), PDO::PARAM_INT);            
            $result->bindValue(":stPreLoa", $this->getStPreLoa(), PDO::PARAM_STR);                      
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }      
    
    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_pre_loa WHERE id_pre_loa = :idPreLoa");
            $result->bindValue(":idPreLoa", $this->getIdPreLoa(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }   
    
    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_pre_loa SET st_ativo = 0 "
                    . "WHERE id_pre_loa = :idPreLoa ");
            $result->bindValue(":idPreLoa", $this->getIdPreLoa(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function mudaStatus($pdo) {
        try {            
            
            $result = $pdo->prepare("UPDATE pla_pre_loa SET st_pre_loa = :stPreLoa "
                    . "WHERE id_pre_loa = :idPreLoa ");
            $result->bindValue(":idPreLoa", $this->getIdPreLoa(), PDO::PARAM_INT);
            $result->bindValue(":stPreLoa", $this->getStPreLoa(), PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }

    /**
     * Retorna as informações de um Registro Especifico
     * @param type $pdo
     * @return boolean
     */
    function retorna($pdo) {

        $this->sucesso = false;

        $sql = " SELECT id_pre_loa, aa_pre_loa, st_pre_loa, st_ativo"                    
                . " FROM pla_pre_loa"
                . " WHERE id_pre_loa = :idPreLoa";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPreLoa", $this->getIdPreLoa(), PDO::PARAM_INT);
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
    
    function verificaExistePorAno($pdo) {    
        $this->sucesso = false;

        $sql = " SELECT id_pre_loa, aa_pre_loa, st_pre_loa"                    
                . " FROM pla_pre_loa"
                . " WHERE aa_pre_loa = :aaPreLoa AND st_ativo = '1'";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":aaPreLoa", $this->getAaPreLoa(), PDO::PARAM_INT);
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
    
    function retornaPreLoaInStatus($status, PDO $pdo) {    
        $this->sucesso = false;

        $sql = " SELECT id_pre_loa, aa_pre_loa, st_pre_loa"                    
                . " FROM pla_pre_loa"
                . " WHERE st_pre_loa IN (".$status.") AND st_ativo = '1'";
        try {
            $result = $pdo->prepare($sql);            
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
    
    function retornaTodosAnos(PDO $pdo) {    
        $this->sucesso = false;

        $sql = " SELECT DISTINCT aa_pre_loa"                    
                . " FROM pla_pre_loa"
                . " WHERE st_ativo = '1'";
        try {
            $result = $pdo->prepare($sql);            
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
