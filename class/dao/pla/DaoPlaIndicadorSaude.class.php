<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaIndicadorSaude.class.php";

class DaoPlaIndicadorSaude extends PlaIndicadorSaude{
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_indicador_saude (nm_indicador_saude, "
                    . " aa_indicador_saude, cd_nota, tp_indicador_saude, ds_meta, ds_unidade) "
                    . " VALUES (:nmIndicadorSaude, :aaIndicadorSaude, :cdNota, :tpIndicadorSaude, "
                    . " :dsMeta, :dsUnidade)");
            $result->bindValue(":nmIndicadorSaude", $this->getNmIndicadorSaude(), PDO::PARAM_STR);
            $result->bindValue(":aaIndicadorSaude", $this->getAaIndicadorSaude(), PDO::PARAM_INT);
            $result->bindValue(":cdNota", $this->getCdNota(), PDO::PARAM_STR);
            $result->bindValue(":tpIndicadorSaude", $this->getTpIndicadorSaude(), PDO::PARAM_STR);
            $result->bindValue(":dsMeta", $this->getDsMeta(), PDO::PARAM_STR);
            $result->bindValue(":dsUnidade", $this->getDsUnidade(), PDO::PARAM_STR);                       
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_indicador_saude SET nm_indicador_saude = :nmIndicadorSaude "
                    . " , aa_indicador_saude = :aaIndicadorSaude , cd_nota = :cdNota"
                    . " , tp_indicador_saude = :tpIndicadorSaude , ds_meta = :dsMeta"
                    . " , ds_unidade = :dsUnidade"
                    . " WHERE id_indicador_saude = :idIndicadorSaude ");
            $result->bindValue(":idIndicadorSaude", $this->getIdIndicadorSaude(), PDO::PARAM_INT);
            $result->bindValue(":nmIndicadorSaude", $this->getNmIndicadorSaude(), PDO::PARAM_STR);
            $result->bindValue(":aaIndicadorSaude", $this->getAaIndicadorSaude(), PDO::PARAM_INT);
            $result->bindValue(":cdNota", $this->getCdNota(), PDO::PARAM_STR);
            $result->bindValue(":tpIndicadorSaude", $this->getTpIndicadorSaude(), PDO::PARAM_STR);
            $result->bindValue(":dsMeta", $this->getDsMeta(), PDO::PARAM_STR);
            $result->bindValue(":dsUnidade", $this->getDsUnidade(), PDO::PARAM_STR);        
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_indicador_saude WHERE id_indicador_saude = :idIndicadorSaude");
            $result->bindValue(":idIndicadorSaude", $this->getIdIndicadorSaude(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function desativa($pdo){
        try {
            $result = $pdo->prepare("UPDATE pla_indicador_saude SET st_ativo = 0 "
                    . "WHERE id_indicador_saude = :idIndicadorSaude ");
            $result->bindValue(":idIndicadorSaude", $this->getIdIndicadorSaude(), PDO::PARAM_INT);         
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    /**
     * Retorna todas as Informações dos Indicadores de Saúde
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosIndicadores($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT id_indicador_saude, nm_indicador_saude, aa_indicador_saude, cd_nota"
                . " , tp_indicador_saude, ds_meta, ds_unidade, st_ativo"
                . " FROM pla_indicador_saude"
                . " ORDER BY cd_nota, nm_indicador_saude";              
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
     * Retorna as informações de um Indicador de Saúde Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaIndicadorSaude($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT *"                                        
                . " FROM pla_indicador_saude"
                . " WHERE id_indicador_saude = :idIndicadorSaude";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idIndicadorSaude", $this->getIdIndicadorSaude(), PDO::PARAM_INT);                
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
     * Retorna todas as Informações dos Indicadores de Saúde Por Ano
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosIndicadorSaudePorAno($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT id_indicador_saude, nm_indicador_saude, aa_indicador_saude, cd_nota"
                . " , tp_indicador_saude, ds_meta, ds_unidade, st_ativo"
                . " FROM pla_indicador_saude"
                . " WHERE aa_indicador_saude = :aaIndicadorSaude"
                . " ORDER BY cd_nota, nm_indicador_saude";          
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":aaIndicadorSaude", $this->getAaIndicadorSaude(), PDO::PARAM_INT);            
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

