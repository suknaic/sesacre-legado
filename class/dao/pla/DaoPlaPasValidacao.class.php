<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPasValidacao.class.php";

class DaoPlaPasValidacao extends PlaPasValidacao {
    
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
            $result = $pdo->prepare("INSERT INTO pla_pas_validacao (id_pas"
                    . " , id_pessoa,  ds_pas_validacao, st_pas_validacao) "
                    . " VALUES (:idPas, :idPessoa, :dsPasValidacao, :stPasValidacao)");            
            $result->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);                   
            $result->bindValue(":dsPasValidacao", $this->getDsPasValidacao() === '' ? null : $this->getDsPasValidacao(), PDO::PARAM_STR);                   
            $result->bindValue(":stPasValidacao", $this->getStPasValidacao(), PDO::PARAM_STR);
            
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }
       
        
    function retornaMensagensPorPas(PDO $pdo){

        $this->sucesso = false;

        $sql = " SELECT "                                      
                . " P.nm_pessoa, PV.ds_pas_validacao"
                . " , to_char(PV.dh_pas_validacao, 'HH24:MI:SS DD/MM/YYYY') AS dh_pas_validacao"
                . " , PV.st_pas_validacao"                
                . " FROM pla_pas_validacao PV"
                . " INNER JOIN ses_pessoa P ON P.id_pessoa = PV.id_pessoa"                                                                        
                . " WHERE PV.id_PAS = :idPas "                   
                . " ORDER BY PV.dh_pas_validacao DESC";
        
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);                           
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
