<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaUnidadeMedida.class.php";

class DaoPlaUnidadeMedida extends PlaUnidadeMedida{
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_unidade_medida (nm_unidade_medida) "
                    . " VALUES (:nmUnidadeMedida)");                      
            $result->bindValue(":nmUnidadeMedida", $this->getNmUnidadeMedida(), PDO::PARAM_STR);            
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_unidade_medida SET nm_unidade_medida = :nmUnidadeMedida "                    
                    . " WHERE id_unidade_medida = :idUnidadeMedida");
            $result->bindValue(":idUnidadeMedida", $this->getIdUnidadeMedida(), PDO::PARAM_INT);            
            $result->bindValue(":nmUnidadeMedida", $this->getNmUnidadeMedida(), PDO::PARAM_STR);            
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_unidade_medida WHERE id_unidade_medida = :idUnidadeMedida");
            $result->bindValue(":idUnidadeMedida", $this->getIdUnidadeMedida(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }       
          
    
    /**
     * Retorna as informações de um Registro Especifico
     * @param type $pdo
     * @return boolean
     */
    function retorna($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT id_unidade_medida, nm_unidade_medida, st_ativo"
                . " FROM pla_unidade_medida"                
                . " WHERE id_unidade_medida = :idUnidadeMedida";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idUnidadeMedida", $this->getIdUnidadeMedida(), PDO::PARAM_INT);            
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
     * Retorna todas as Informações de Todos as Unidades de Medida
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPlaUnidadeMedida($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT id_unidade_medida, nm_unidade_medida"                
                . " FROM pla_unidade_medida"                
                . " ORDER BY nm_unidade_medida";                
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
    
   
    
}

