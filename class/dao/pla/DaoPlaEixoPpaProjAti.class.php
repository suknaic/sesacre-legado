<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaEixoPpaProjAti.class.php";

class DaoPlaEixoPpaProjAti extends PlaEixoPpaProjAti{
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_eixo_ppa_proj_ati (id_eixo, id_ppa_proj_ati) "
                    . " VALUES (:idEixo, :idPpaProjAti)");
            $result->bindValue(":idEixo", $this->getIdEixo(), PDO::PARAM_INT);            
            $result->bindValue(":idPpaProjAti", $this->getIdPpaProjAti(), PDO::PARAM_INT);                      
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }   

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_eixo_ppa_proj_ati WHERE id_eixo_ppa_proj_ati = :idEixoPpaProjAti");
            $result->bindValue(":idEixoPpaProjAti", $this->getIdEixoPpaProjAti(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }        
            
    
    /**
     * Retorna as informações de um Eixo Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaEixoPpaProjAti($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT *"                
                . " FROM pla_eixo_ppa_proj_ati"                
                . " WHERE id_eixo_ppa_proj_ati = :idEixoPpaProjAti";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idEixoPpaProjAti", $this->getIdEixoPpaProjAti(), PDO::PARAM_INT);            
            $sth->execute();                      
            if ($sth->rowCount() >= 1) {          
                return $sth->fetch(PDO::FETCH_ASSOC);                             
            }else{                
                return $retorno;
            }      
            return $retorno;
        } catch (PDOException $e) {            
            echo $e->getMessage();
            return $retorno;
        }  
    } 
    
    
    /**
     * Retorna todos os Dados por um Eixo Especifico
     * @param int $idEixo
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPorEixo(int $idEixo, $pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT EP.id_eixo_ppa_proj_ati, EP.id_eixo"
                . " , EP.id_ppa_proj_ati, PP.nm_ppa_proj_ati, PP.cd_ppa_proj_ati, PP.tp_ppa_proj_ati"                
                . " FROM pla_eixo_ppa_proj_ati EP"
                . " INNER JOIN pla_ppa_proj_ati PP ON PP.id_ppa_proj_ati = EP.id_ppa_proj_ati"
                . " WHERE EP.id_eixo = :idEixo";
        try {
            $sth = $pdo->prepare($sql);  
            $sth->bindValue(":idEixo", $idEixo, PDO::PARAM_INT);       
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }
    
    /**
     * Retorna todos os Dados por um Projeto/Atividade do PPA
     * @param int $idPpaProjAti
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPorPpaProjAti(int $idPpaProjAti, $pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT EP.id_eixo_ppa_proj_ati, EP.id_eixo"
                . " , EP.id_ppa_proj_ati, E.id_pes, E.nr_ordem, E.nm_eixo"                
                . " FROM pla_eixo_ppa_proj_ati EP"
                . " INNER JOIN pla_eixo E ON E.id_eixo = EP.id_eixo"
                . " WHERE EP.id_ppa_proj_ati = :idPpaProjAti"
                . " ORDER BY E.nr_ordem";
        try {
            $sth = $pdo->prepare($sql);  
            $sth->bindValue(":idPpaProjAti", $idPpaProjAti, PDO::PARAM_INT);       
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }
    
    
    /**
     * 
     * @param string $idPpaProjAti
     * @param int $idEixo
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPorPpaProjAtiINEixo(string $idPpaProjAti, int $idEixo, $pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT id_eixo_ppa_proj_ati"               
                . " FROM pla_eixo_ppa_proj_ati"                
                . " WHERE id_ppa_proj_ati IN (".$idPpaProjAti.") AND id_eixo = :idEixo";
        try {
            $sth = $pdo->prepare($sql);  
            $sth->bindValue(":idEixo", $idEixo, PDO::PARAM_INT);  
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }
    
}

