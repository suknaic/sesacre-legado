<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaObjetivo.class.php";

class DaoPlaObjetivo extends PlaObjetivo{
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_objetivo (id_diretriz, nm_objetivo, nr_ordem) "
                    . " VALUES (:idDiretriz, :nmObjetivo, :nrOrdem)");            
            $result->bindValue(":idDiretriz", $this->getIdDiretriz(), PDO::PARAM_INT);
            $result->bindValue(":nmObjetivo", $this->getNmObjetivo(), PDO::PARAM_STR);
            $result->bindValue(":nrOrdem", $this->getNrOrdem(), PDO::PARAM_INT);            
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_objetivo SET nm_objetivo = :nmObjetivo "
                    . " , id_diretriz = :idDiretriz, nr_ordem = :nrOrdem "
                    . " WHERE id_objetivo = :idObjetivo ");            
            $result->bindValue(":idObjetivo", $this->getIdObjetivo(), PDO::PARAM_INT);
            $result->bindValue(":idDiretriz", $this->getIdDiretriz(), PDO::PARAM_INT);
            $result->bindValue(":nmObjetivo", $this->getNmObjetivo(), PDO::PARAM_STR);
            $result->bindValue(":nrOrdem", $this->getNrOrdem(), PDO::PARAM_INT);               
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_objetivo WHERE id_objetivo = :idObjetivo");
            $result->bindValue(":idObjetivo", $this->getIdObjetivo(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function desativa($pdo){
        try {
            $result = $pdo->prepare("UPDATE pla_objetivo SET st_ativo = 0 "
                    . "WHERE id_objetivo = :idObjetivo ");
            $result->bindValue(":idObjetivo", $this->getIdObjetivo(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();       
        }
    }
    
        
    
    /**
     * Retorna as informações de um Objetivo Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaObjetivo($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT id_objetivo, id_diretriz, nm_objetivo, nr_ordem, st_ativo"                
                . " FROM pla_objetivo"                
                . " WHERE id_objetivo = :idObjetivo";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idObjetivo", $this->getIdObjetivo(), PDO::PARAM_INT);            
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
     * Retorna todas as Informações do Objetivo Por uma Diretriz Especifica
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosObjetivoPorDiretriz($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT id_objetivo, id_diretriz, nm_objetivo, nr_ordem"                
                . " FROM pla_objetivo"                
                . " WHERE id_diretriz = :idDiretriz"
                . " ORDER BY nr_ordem, nm_objetivo";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idDiretriz", $this->getIdDiretriz(), PDO::PARAM_INT);       
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
     * Retorna      
     * @param type $pdo
     * @return boolean
     */
    function retornaDadosCompleto($pdo){
        
        $retorno = FALSE;
              
        $sql = " SELECT O.id_objetivo, O.nm_objetivo, O.nr_ordem as ordemobjetivo"
                . " ,D.id_diretriz, D.nm_diretriz, D.nr_ordem AS ordemdiretriz"
                . " , E.id_eixo, E.nm_eixo, E.nr_ordem as ordemeixo, P.nm_pes, P.id_pes"
                . " , STRING_AGG(CONCAT(PPA.cd_ppa_proj_ati, ' - ', PPA.nm_ppa_proj_ati), ', ') AS \"Projeto/Atividade do PPA\" "
                . " FROM pla_objetivo O"
                . " INNER JOIN pla_diretriz D ON D.id_diretriz = O.id_diretriz"
                . " INNER JOIN pla_eixo E ON E.id_eixo = D.id_eixo"
                . " INNER JOIN pla_pes P ON P.id_pes = E.id_pes"                
                . " LEFT JOIN pla_eixo_ppa_proj_ati EP ON EP.id_eixo = E.id_eixo"
                . " LEFT JOIN pla_ppa_proj_ati PPA ON PPA.id_ppa_proj_ati = EP.id_ppa_proj_ati"
                . " WHERE O.id_objetivo = :idObjetivo"
                . " GROUP BY O.id_objetivo, O.nm_objetivo, O.nr_ordem"
                    . " ,D.id_diretriz, D.nm_diretriz, D.nr_ordem, E.id_eixo"
                    . ", E.nm_eixo, E.nr_ordem, P.nm_pes, P.id_pes"
                . " ORDER BY \"Projeto/Atividade do PPA\" desc";
        
        try {
            $sth = $pdo->prepare($sql);  
            $sth->bindValue(":idObjetivo", $this->getIdObjetivo(), PDO::PARAM_INT);       
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
    function retornaObjetivoSelect($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT *"                                        
                . " FROM pla_objetivo"
                . " ORDER BY nm_objetivo";                
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

