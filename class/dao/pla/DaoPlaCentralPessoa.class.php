<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaCentralPessoa.class.php";

class DaoPlaCentralPessoa extends PlaCentralPessoa {
    
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
            $result = $pdo->prepare("INSERT INTO pla_central_pessoa (id_pessoa"
                    . " , id_lotacao) "                                        
                    . " VALUES (:idPessoa, :idLotacao)");                                        
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);            
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);                      
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }  

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_central_pessoa WHERE id_central_pessoa = :idCentralPessoa");
            $result->bindValue(":idCentralPessoa", $this->getIdCentralPessoa(), PDO::PARAM_INT);
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

        $sql = " SELECT id_central_pessoa, id_pessoa, id_lotacao"                    
                . " FROM pla_central_pessoa"
                . " WHERE id_central_pessoa = :idCentralPessoa";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idCentralPessoa", $this->getIdCentralPessoa(), PDO::PARAM_INT);
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

/**
     * Retorna as informações de um Registro Especifico Por Uma Pessoa
     * @param type $pdo
     * @return boolean
     */
    function retornaPorPessoa($pdo) {

        $this->sucesso = false;

        $sql = " SELECT id_central_pessoa, id_pessoa, id_lotacao"                    
                . " FROM pla_central_pessoa"
                . " WHERE id_pessoa = :idPessoa";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
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
    
    function verificaPessoaCentral($pdo) {
        
        if($pdo == null){
            $conexao = new Conexao();            
            /* @var $pdo PDO */
            $pdo = $conexao->connect();            
        }  

        $this->sucesso = false;

        $sql = " SELECT id_central_pessoa"                    
                . " FROM pla_central_pessoa"
                . " WHERE id_pessoa = :idPessoa AND id_lotacao = :idLotacao";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = true;
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = false;
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function retornaTodos($pdo) {
        
        if($pdo == null){
            $conexao = new Conexao();            
            /* @var $pdo PDO */
            $pdo = $conexao->connect();            
        }  

        $this->sucesso = false;

        $sql = " SELECT CP.id_central_pessoa"
                . " , P.id_pessoa, P.nm_pessoa"
                . " , L.id_lotacao, L.nm_lotacao"                    
                . " FROM pla_central_pessoa CP"
                . " INNER JOIN ses_pessoa P ON P.id_pessoa = CP.id_pessoa"
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = CP.id_lotacao"
                . " ORDER BY P.nm_pessoa, L.nm_lotacao";
        try {
            $result = $pdo->prepare($sql);            
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = false;
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
       
    
}
