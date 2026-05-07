<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPes.class.php";

class DaoPlaPes extends PlaPes{
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_pes (nm_pes, aa_vigencia_inicio, aa_vigencia_fim) "
                    . " VALUES (:nmPes, :aaVigenciaInicio, :aaVigenciaFim)");
            $result->bindValue(":nmPes", $this->getNmPes(), PDO::PARAM_STR);
            $result->bindValue(":aaVigenciaInicio", $this->getAaVigenciaInicio(), PDO::PARAM_STR);
            $result->bindValue(":aaVigenciaFim", $this->getAaVigenciaFim(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_pes SET nm_pes = :nmPes "
                    . " , aa_vigencia_inicio = :aaVigenciaInicio , aa_vigencia_fim = :aaVigenciaFim "
                    . " WHERE id_pes = :idPes ");
            $result->bindValue(":idPes", $this->getIdPes(), PDO::PARAM_INT);
            $result->bindValue(":nmPes", $this->getNmPes(), PDO::PARAM_STR);
            $result->bindValue(":aaVigenciaInicio", $this->getAaVigenciaInicio(), PDO::PARAM_STR);
            $result->bindValue(":aaVigenciaFim", $this->getAaVigenciaFim(), PDO::PARAM_STR);      
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_pes WHERE id_pes = :idPes");
            $result->bindValue(":idPes", $this->getIdPes(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function desativa($pdo){
        try {
            $result = $pdo->prepare("UPDATE pla_pes SET st_ativo = 0 "
                    . "WHERE id_pes = :idPes ");
            $result->bindValue(":idPes", $this->getIdPes(), PDO::PARAM_INT);                
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    /**
     * Retorna todas as Informações do Plano Estadual de Saúde
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPes($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT id_pes, nm_pes, aa_vigencia_inicio, aa_vigencia_fim"
                . " FROM pla_pes"
                . " ORDER BY nm_pes";              
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
     * Retorna as informações de um PES Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaPes($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT *"                                        
                . " FROM pla_pes"
                . " WHERE id_pes = :idPes";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPes", $this->getIdPes(), PDO::PARAM_INT);            
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
     * Retorna todas as Informações do Plano Estadual de Saúde
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPesAteObjetivo($pdo){
        
        $retorno = FALSE;
                         
        $sql = "SELECT P.id_pes, P.nm_pes, P.aa_vigencia_inicio AS vig_inicio_pes, P.aa_vigencia_fim AS vig_fim_pes"
                . " , E.id_eixo, E.nm_eixo, E.nr_ordem AS ordemEixo"                
                . " , D.id_diretriz, D.nm_diretriz, D.nr_ordem AS ordemDiretriz"
                . " , O.id_objetivo, O.nm_objetivo, O.nr_ordem AS ordemObjetivo"
                . " , A.id_acao, A.nm_acao, A.ds_indicador AS ds_indicador, A.ds_meta_plano AS ds_parceria"
                . " FROM pla_pes P"
                . " LEFT JOIN pla_eixo E ON E.id_pes = P.id_pes"                
                . " LEFT JOIN pla_diretriz D ON D.id_eixo = E.id_eixo"
                . " LEFT JOIN pla_objetivo O ON O.id_diretriz = D.id_diretriz"
                . " LEFT JOIN pla_acao A ON A.id_objetivo = O.id_objetivo"
                . " ORDER BY P.aa_vigencia_inicio, P.nm_pes";
        
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

