<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPreLoaHistorico.class.php";

class DaoPlaPreLoaHistorico extends PlaPreLoaHistorico {
    
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
            $result = $pdo->prepare("INSERT INTO pla_pre_loa_historico (id_pre_loa"
                    . " , id_pessoa, ds_pre_loa_historico, st_pre_loa) "                                        
                    . " VALUES (:idPreLoa, :idPessoa, :dsPreLoaHistorico, :stPreLoa)");                                        
            $result->bindValue(":idPreLoa", $this->getIdPreLoa(), PDO::PARAM_INT);            
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->bindValue(":dsPreLoaHistorico", $this->getDsPreLoaHistorico(), PDO::PARAM_STR);
            $result->bindValue(":stPreLoa", $this->getStPreLoa(), PDO::PARAM_STR);                      
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
                . " , H.ds_pre_loa_historico"
                . " , to_char(H.dh_pre_loa_historico, 'HH24:MI:SS DD/MM/YYYY') AS dh_pre_loa_historico"
                . " , H.st_pre_loa"
                . " FROM pla_pre_loa_historico H"
                . " INNER JOIN ses_pessoa P ON P.id_pessoa = H.id_pessoa"
                . " WHERE H.id_pre_loa = :idPreLoa"
                . " ORDER BY H.dh_pre_loa_historico DESC";
                
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPreLoa", $this->getIdPreLoa(), PDO::PARAM_INT);            
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
