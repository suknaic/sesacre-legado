<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaLiberacaoFonte.class.php";

class DaoPlaLiberacaoFonte extends PlaLiberacaoFonte {
    
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
            $result = $pdo->prepare("INSERT INTO pla_liberacao_fonte (id_fonte"
                    . " , aa_liberacao_fonte, vl_liberacao_fonte) "                                        
                    . " VALUES (:idFonte, :aaLiberacaoFonte, :vlLiberacaoFonte)");                                        
            $result->bindValue(":idFonte", $this->getIdFonte(), PDO::PARAM_INT);            
            $result->bindValue(":aaLiberacaoFonte", $this->getAaLiberacaoFonte(), PDO::PARAM_INT);            
            $result->bindValue(":vlLiberacaoFonte", $this->getVlLiberacaoFonte(), PDO::PARAM_STR);                      
            $result->execute();            
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }      
    
    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_liberacao_fonte WHERE id_liberacao_fonte = :idLiberacaoFonte");
            $result->bindValue(":idLiberacaoFonte", $this->getIdLiberacaoFonte(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }   
    
    function update($pdo) {
        try {
            
            $result = $pdo->prepare("UPDATE pla_liberacao_fonte SET id_fonte = :idFonte"
                    . " , aa_liberacao_fonte = :aaLiberacaoFonte"
                    . " , vl_liberacao_fonte = :vlLiberacaoFonte"
                    . " WHERE id_liberacao_fonte = :idLiberacaoFonte ");
            $result->bindValue(":idLiberacaoFonte", $this->getIdLiberacaoFonte(), PDO::PARAM_INT);
            $result->bindValue(":idFonte", $this->getIdFonte(), PDO::PARAM_INT);       
            $result->bindValue(":aaLiberacaoFonte", $this->getAaLiberacaoFonte(), PDO::PARAM_INT);            
            $result->bindValue(":vlLiberacaoFonte", $this->getVlLiberacaoFonte(), PDO::PARAM_STR);       
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

        $sql = " SELECT *"                    
                . " FROM pla_liberacao_fonte"
                . " WHERE id_liberacao_fonte = :idLiberacaoFonte";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idLiberacaoFonte", $this->getIdLiberacaoFonte(), PDO::PARAM_INT);
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
   
     
                
    function retornaPorAno(PDO $pdo) { 
        $this->sucesso = false;

        $sql = " SELECT LF.id_liberacao_fonte, LF.id_fonte, LF.vl_liberacao_fonte"
                . " , F.nr_fonte"                    
                . " FROM pla_liberacao_fonte LF"
                . " INNER JOIN fin_fonte F ON F.id_fonte = LF.id_fonte"
                . " WHERE LF.aa_liberacao_fonte = :aaLiberacaoFonte";
        try {
            $result = $pdo->prepare($sql);  
            $result->bindValue(":aaLiberacaoFonte", $this->getAaLiberacaoFonte(), PDO::PARAM_STR);
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
    
    function retornaDadosCompleto(PDO $pdo) { 
        $this->sucesso = false;

        $sql = " SELECT LF.id_liberacao_fonte, LF.id_fonte, LF.vl_liberacao_fonte"
                . " , F.nr_fonte, LF.aa_liberacao_fonte"                    
                . " FROM pla_liberacao_fonte LF"
                . " INNER JOIN fin_fonte F ON F.id_fonte = LF.id_fonte"
                . " WHERE LF.id_liberacao_fonte = :idLiberacaoFonte";
        try {
            $result = $pdo->prepare($sql);  
            $result->bindValue(":idLiberacaoFonte", $this->getIdLiberacaoFonte(), PDO::PARAM_STR);
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
    
    function retornaTodos(PDO $pdo) { 
        $this->sucesso = false;

        $sql = " SELECT LF.id_liberacao_fonte, LF.id_fonte, LF.vl_liberacao_fonte"
                . " , LF.aa_liberacao_fonte"
                . " , F.nr_fonte"                    
                . " FROM pla_liberacao_fonte LF"
                . " INNER JOIN fin_fonte F ON F.id_fonte = LF.id_fonte"
                . " ORDER BY LF.aa_liberacao_fonte, F.nr_fonte";
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
    
    function existeDuplicidade(PDO $pdo) { 
        $this->sucesso = false;

        $sql = " SELECT LF.id_liberacao_fonte, LF.id_fonte, LF.aa_liberacao_fonte"                     
                . " FROM pla_liberacao_fonte LF"                
                . " WHERE LF.aa_liberacao_fonte = :aaLiberacaoFonte "
                . " AND LF.id_fonte = :idFonte";
        try {
            $result = $pdo->prepare($sql);  
            $result->bindValue(":aaLiberacaoFonte", $this->getAaLiberacaoFonte(), PDO::PARAM_STR);
            $result->bindValue(":idFonte", $this->getIdFonte(), PDO::PARAM_INT);
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
}
