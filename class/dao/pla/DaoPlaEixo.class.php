<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaEixo.class.php";

class DaoPlaEixo extends PlaEixo{
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_eixo (id_pes, nm_eixo, nr_ordem) "
                    . " VALUES (:idPes, :nmEixo, :nrOrdem)");
            $result->bindValue(":idPes", $this->getIdPes(), PDO::PARAM_INT);            
            $result->bindValue(":nmEixo", $this->getNmEixo(), PDO::PARAM_STR);
            $result->bindValue(":nrOrdem", $this->getNrOrdem(), PDO::PARAM_INT);            
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_eixo SET nm_eixo = :nmEixo "
                    . " , id_pes = :idPes , nr_ordem = :nrOrdem "
                    . " WHERE id_eixo = :idEixo ");
            $result->bindValue(":idEixo", $this->getIdEixo(), PDO::PARAM_INT);
            $result->bindValue(":idPes", $this->getIdPes(), PDO::PARAM_INT);            
            $result->bindValue(":nmEixo", $this->getNmEixo(), PDO::PARAM_STR);
            $result->bindValue(":nrOrdem", $this->getNrOrdem(), PDO::PARAM_INT);      
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_eixo WHERE id_eixo = :idEixo");
            $result->bindValue(":idEixo", $this->getIdEixo(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function desativa($pdo){
        try {
            $result = $pdo->prepare("UPDATE pla_eixo SET st_ativo = 0 "
                    . "WHERE id_eixo = :idEixo ");
            $result->bindValue(":idEixo", $this->getIdEixo(), PDO::PARAM_INT);
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
    function retornaEixo($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT *"                
                . " FROM pla_eixo"                
                . " WHERE id_eixo = :idEixo";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idEixo", $this->getIdEixo(), PDO::PARAM_INT);            
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
     * Retorna todas as Informações do Eixo Por um Pes Especifico     
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosEixosPorPes($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT E.id_eixo, E.nm_eixo, E.nr_ordem"
                . " , STRING_AGG(CONCAT(PPA.cd_ppa_proj_ati, ' - ', PPA.nm_ppa_proj_ati), ', ') AS \"Projeto/Atividade do PPA\" "
                . " FROM pla_eixo E"
                . " INNER JOIN pla_pes P ON P.id_pes = E.id_pes"
                . " LEFT JOIN pla_eixo_ppa_proj_ati EP ON EP.id_eixo = E.id_eixo"
                . " LEFT JOIN pla_ppa_proj_ati PPA ON PPA.id_ppa_proj_ati = EP.id_ppa_proj_ati"
                . " WHERE P.id_pes = :idPes"
                . " GROUP BY E.id_eixo, E.nm_eixo, E.nr_ordem"
                . " ORDER BY E.nr_ordem, E.nm_eixo";
        try {
            $sth = $pdo->prepare($sql);  
            $sth->bindValue(":idPes", $this->getIdPes(), PDO::PARAM_INT);       
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
     * Retorna Dados de um unico Eixo contendo todos os dados que completa um Eixo 
     * @param type $pdo
     * @return boolean
     */
    function retornaDadosCompleto($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT E.nm_eixo, E.nr_ordem, P.nm_pes"
                . " , STRING_AGG(CONCAT(PPA.cd_ppa_proj_ati, ' - ', PPA.nm_ppa_proj_ati), ', ') AS \"Projeto/Atividade do PPA\" "
                . " FROM pla_eixo E"
                . " INNER JOIN pla_pes P ON P.id_pes = E.id_pes"                
                . " LEFT JOIN pla_eixo_ppa_proj_ati EP ON EP.id_eixo = E.id_eixo"
                . " LEFT JOIN pla_ppa_proj_ati PPA ON PPA.id_ppa_proj_ati = EP.id_ppa_proj_ati"
                . " WHERE E.id_eixo = :idEixo"
                . " GROUP BY E.id_eixo, E.nm_eixo, E.nr_ordem, P.nm_pes"
                . " ORDER BY \"Projeto/Atividade do PPA\"";                     
        try {
            $sth = $pdo->prepare($sql);  
            $sth->bindValue(":idEixo", $this->getIdEixo(), PDO::PARAM_INT);       
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
    
    function retornaDadosParaEdicao($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT E.id_eixo, E.nm_eixo, E.nr_ordem"
                . " , COALESCE(json_object_agg(PPA.id_ppa_proj_ati, CONCAT(PPA.cd_ppa_proj_ati, ' - ', PPA.nm_ppa_proj_ati)) FILTER (WHERE PPA.id_ppa_proj_ati IS NOT NULL), '[]') AS \"ppa_proj_ati\" "
                //. " , STRING_AGG(EP.id_ppa_proj_ati, ', ') AS \"idsPpaProjAti\" "
                // . " , STRING_AGG(PPA.nm_ppa_proj_ati, ', ') AS \"nomesPpaProjAti\" "
                . " FROM pla_eixo E"                
                . " LEFT JOIN pla_eixo_ppa_proj_ati EP ON EP.id_eixo = E.id_eixo"
                . " LEFT JOIN pla_ppa_proj_ati PPA ON PPA.id_ppa_proj_ati = EP.id_ppa_proj_ati"
                . " WHERE E.id_eixo = :idEixo"
                . " GROUP BY E.id_eixo, E.nm_eixo, E.nr_ordem";                
        try {
            $sth = $pdo->prepare($sql);  
            $sth->bindValue(":idEixo", $this->getIdEixo(), PDO::PARAM_INT);       
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

