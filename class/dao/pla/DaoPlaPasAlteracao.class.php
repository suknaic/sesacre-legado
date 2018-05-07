<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPasAlteracao.class.php";

class DaoPlaPasAlteracao extends PlaPasAlteracao {
    
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
            $result = $pdo->prepare("INSERT INTO pla_pas_alteracao (id_pessoa"
                    . " , id_pas, ds_tela, ds_pas_alteracao, tp_pas_alteracao, id_pta_titulo, id_pta, id_pta_item) "                                        
                    . " VALUES (:idPessoa, :idPas, :dsTela, :dsPasAlteracao, :tpPasAlteracao, :idPtaTitulo, :idPta, :idPtaItem)");                                        
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);
            $result->bindValue(":dsTela", $this->getDsTela(), PDO::PARAM_STR);
            $result->bindValue(":dsPasAlteracao", $this->getDsPasAlteracao(), PDO::PARAM_STR);
            $result->bindValue(":tpPasAlteracao", $this->getTpPasAlteracao(), PDO::PARAM_STR);        
            $result->bindValue(":idPtaTitulo", empty($this->getIdPtaTitulo()) ? NULL : $this->getIdPtaTitulo(), PDO::PARAM_INT);
            $result->bindValue(":idPta", empty($this->getIdPta()) ? NULL : $this->getIdPta(), PDO::PARAM_INT);
            $result->bindValue(":idPtaItem", empty($this->getIdPtaItem()) ? NULL : $this->getIdPtaItem(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }      
    
    function retornaPorPreLoa($pdo){

        $this->sucesso = false;

        $sql = " SELECT P.id_pessoa, P.nm_pessoa"
                . " , PAS.ds_tela, PAS.ds_pas_alteracao"
                . " , to_char(PAS.dh_pas_alteracao, 'HH24:MI:SS DD/MM/YYYY') AS dh_pas_alteracao"
                . " , PAS.tp_pas_alteracao"
                . " FROM pla_pas_alteracao PAS"
                . " INNER JOIN ses_pessoa P ON P.id_pessoa = PAS.id_pessoa"
                . " WHERE PAS.id_pas = :idPas"
                . " ORDER BY PAS.dh_pas_alteracao DESC";
                
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
