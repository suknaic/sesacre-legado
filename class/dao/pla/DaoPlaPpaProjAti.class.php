<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPpaProjAti.class.php";

class DaoPlaPpaProjAti extends PlaPpaProjAti{
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_ppa_proj_ati (nm_ppa_proj_ati, id_ppa_prog, tp_ppa_proj_ati, cd_ppa_proj_ati) "
                    . " VALUES (:nmPpaProjAti, :idPpaProg, :tpPpaProjAti, :cdPpaProjAti)");
            $result->bindValue(":nmPpaProjAti", $this->getNmPpaProjAti(), PDO::PARAM_STR);
            $result->bindValue(":idPpaProg", $this->getIdPpaProg(), PDO::PARAM_INT); 
            $result->bindValue(":tpPpaProjAti", $this->getTpPpaProjAti(), PDO::PARAM_STR); 
            $result->bindValue(":cdPpaProjAti", $this->getCdPpaProjAti(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_ppa_proj_ati SET nm_ppa_proj_ati = :nmPpaProjAti, tp_ppa_proj_ati = :tpPpaProjAti "
                    . " , cd_ppa_proj_ati = :cdPpaProjAti"                    
                    . " WHERE id_ppa_proj_ati = :idPpaProjAti ");
            $result->bindValue(":idPpaProjAti", $this->getIdPpaProjAti(), PDO::PARAM_INT);        
            $result->bindValue(":nmPpaProjAti", $this->getNmPpaProjAti(), PDO::PARAM_STR);
            $result->bindValue(":tpPpaProjAti", $this->getTpPpaProjAti(), PDO::PARAM_STR);
            $result->bindValue(":cdPpaProjAti", $this->getCdPpaProjAti(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_ppa_proj_ati WHERE id_ppa_proj_ati = :idPpaProjAti");
            $result->bindValue(":idPpaProjAti", $this->getIdPpaProjAti(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function desativa($pdo){
        try {
            $result = $pdo->prepare("UPDATE pla_ppa_proj_ati SET st_ativo = 0 "
                    . "WHERE id_ppa_proj_ati = :idPpaProjAti ");
            $result->bindValue(":idPpaProjAti", $this->getIdPpaProjAti(), PDO::PARAM_INT);                
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }            
    
    /**
     * Retorna as informações de um Projeto/Atividade do PPA Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaPpaProjAti($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT *"                                        
                . " FROM pla_ppa_proj_ati"
                . " WHERE id_ppa_proj_ati = :idPpaProjAti";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPpaProjAti", $this->getIdPpaProjAti(), PDO::PARAM_INT);            
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
     * Retorna todas as Informações do Projeto/Atividade do PPA Por Ano De Vigencia Inicio e Fim
     * @param type $anoInicio
     * @param type $anoFim
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPpaProjAtiPorVigencia($anoInicio, $anoFim, $pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT PJP.id_ppa_proj_ati, PJP.nm_ppa_proj_ati, PJP.cd_ppa_proj_ati, PJP.tp_ppa_proj_ati"                
                . " FROM pla_ppa_proj_ati PJP"
                . " INNER JOIN pla_ppa_prog PGP ON PGP.id_ppa_prog = PJP.id_ppa_prog"
                . " WHERE PGP.aa_inicio <= :aaInicio AND aa_fim >= :aaFim"
                . " ORDER BY PJP.cd_ppa_proj_ati";              
        try {
            $sth = $pdo->prepare($sql);
            
            $sth->bindValue(":aaInicio", $anoInicio, PDO::PARAM_STR);
            $sth->bindValue(":aaFim", $anoFim, PDO::PARAM_STR);      
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
     * Retorna todos os Projetos/Atividade do PPA por um Programa do PPA
     * @param type $pdo
     * @return boolean
     */
    function retornaPpaProjAtiPorPpaProg($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT PJP.id_ppa_proj_ati, PJP.nm_ppa_proj_ati, PJP.cd_ppa_proj_ati, PJP.tp_ppa_proj_ati"                
                . " FROM pla_ppa_proj_ati PJP"
                . " INNER JOIN pla_ppa_prog PGP ON PGP.id_ppa_prog = PJP.id_ppa_prog"
                . " WHERE PGP.id_ppa_prog = :idPpaProg"
                . " ORDER BY PJP.nm_ppa_proj_ati";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPpaProg", $this->getIdPpaProg(), PDO::PARAM_INT);            
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

