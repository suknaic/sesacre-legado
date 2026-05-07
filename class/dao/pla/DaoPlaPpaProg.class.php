<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPpaProg.class.php";

class DaoPlaPpaProg extends PlaPpaProg{
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_ppa_prog (nm_ppa_prog, cd_ppa_prog, aa_inicio, aa_fim) "
                    . " VALUES (:nmPpaProg, :cdPpaProg, :aaInicio, :aaFim)");
            $result->bindValue(":nmPpaProg", $this->getNmPpaProg(), PDO::PARAM_STR);
            $result->bindValue(":cdPpaProg", $this->getCdPpaProg(), PDO::PARAM_STR);
            $result->bindValue(":aaInicio", $this->getAaInicio(), PDO::PARAM_INT);
            $result->bindValue(":aaFim", $this->getAaFim(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_ppa_prog SET nm_ppa_prog = :nmPpaProg, cd_ppa_prog = :cdPpaProg"
                    . " , aa_inicio = :aaInicio , aa_fim = :aaFim "
                    . " WHERE id_ppa_prog = :idPpaProg ");
            $result->bindValue(":idPpaProg", $this->getIdPpaProg(), PDO::PARAM_INT);
            $result->bindValue(":nmPpaProg", $this->getNmPpaProg(), PDO::PARAM_STR);
            $result->bindValue(":cdPpaProg", $this->getCdPpaProg(), PDO::PARAM_STR);
            $result->bindValue(":aaInicio", $this->getAaInicio(), PDO::PARAM_INT);
            $result->bindValue(":aaFim", $this->getAaFim(), PDO::PARAM_INT);      
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_ppa_prog WHERE id_ppa_prog = :idPpaProg");
            $result->bindValue(":idPpaProg", $this->getIdPpaProg(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function desativa($pdo){
        try {
            $result = $pdo->prepare("UPDATE pla_ppa_prog SET st_ativo = 0 "
                    . "WHERE id_ppa_prog = :idPpaProg ");
            $result->bindValue(":idPpaProg", $this->getIdPpaProg(), PDO::PARAM_INT);                
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    /**
     * Retorna todas as Informações do Programa do PPA
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPpaProg($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT id_ppa_prog, nm_ppa_prog, cd_ppa_prog, aa_inicio, aa_fim"
                . " FROM pla_ppa_prog"
                . " ORDER BY nm_ppa_prog";              
        try {
            $sth = $pdo->prepare($sql);                                  
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
     * Retorna as informações de um Programa do PPA Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaPpaProg($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT *"                                        
                . " FROM pla_ppa_prog"
                . " WHERE id_ppa_prog = :idPpaProg";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPpaProg", $this->getIdPpaProg(), PDO::PARAM_INT);            
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
}

