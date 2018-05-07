<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPta.class.php";

class DaoPlaPta extends PlaPta{
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_pta (id_pas, nm_pta, dt_inicio, dt_fim) "
                    . " VALUES (:idPas, :nmPta, :dtInicio, :dtFim)");
            $result->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);            
            $result->bindValue(":nmPta", $this->getNmPta(), PDO::PARAM_STR);
            $result->bindValue(":dtInicio", $this->getDtInicio(), PDO::PARAM_STR);
            $result->bindValue(":dtFim", $this->getDtFim(), PDO::PARAM_STR);            
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_pta SET nm_pta = :nmPta "
                    . " , dt_inicio = :dtInicio, dt_fim = :dtFim"                                        
                    . " WHERE id_pta = :idPta ");
            $result->bindValue(":idPta", $this->getIdPta(), PDO::PARAM_INT);            
            $result->bindValue(":nmPta", $this->getNmPta(), PDO::PARAM_STR);
            $result->bindValue(":dtInicio", $this->getDtInicio(), PDO::PARAM_STR);
            $result->bindValue(":dtFim", $this->getDtFim(), PDO::PARAM_STR);            
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_pta WHERE id_pta = :idPta");
            $result->bindValue(":idPta", $this->getIdPta(), PDO::PARAM_INT);
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
    function retornaPta($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT id_pta, id_pas, nm_pta, dt_inicio, dt_fim, st_ativo"                
                . " FROM pla_pta"                
                . " WHERE id_pta = :idPta";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPta", $this->getIdPta(), PDO::PARAM_INT);            
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
     * Retorna todas as Informações do PTA Por um PAS Especifica
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPtaPorPas($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT id_pta, id_pas, nm_pta"
                . " , to_char(dt_inicio, 'DD/MM/YYYY') AS dt_inicio"
                . " , to_char(dt_fim, 'DD/MM/YYYY') AS dt_fim"                          
                . " FROM pla_pta"                
                . " WHERE id_pas = :idPas"
                . " ORDER BY nm_pta";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);       
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
    
    function retornaTodosPtaPorPasAgrupadoTitulo($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT P.id_pta, P.nm_pta"
                . " , to_char(P.dt_inicio, 'DD/MM/YYYY') AS dt_inicio"
                . " , to_char(P.dt_fim, 'DD/MM/YYYY') AS dt_fim"
                . " , COALESCE(json_object_agg(PT.id_pta_titulo, PT.nm_pta_titulo) FILTER (WHERE PT.id_pta_titulo IS NOT NULL), '[]') AS \"titulos\" "                
                . " FROM pla_pta P"
                . " LEFT JOIN pla_pta_titulo PT ON PT.id_pta = P.id_pta"                
                . " WHERE P.id_pas = :idPas"
                . " GROUP BY P.id_pta, P.nm_pta, dt_inicio, dt_fim"
                . " ORDER BY P.nm_pta";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);       
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
     * Retorna todas as Informações do PTA e seus indicadores Por um PAS Especifica
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPtaIndicadorPorPas($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT P.id_pta, P.id_pas, P.nm_pta, P.id_pas"
                . " , to_char(P.dt_inicio, 'DD/MM/YYYY') AS dt_inicio"
                . " , to_char(P.dt_fim, 'DD/MM/YYYY') AS dt_fim"
                . " , PT.nm_pta_titulo, PT.id_pta_titulo"
                . " FROM pla_pta P"
                . " LEFT JOIN pla_pta_titulo PT ON PT.id_pta = P.id_pta"
                . " WHERE P.id_pas = :idPas"
                . " ORDER BY P.nm_pta";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1){
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

