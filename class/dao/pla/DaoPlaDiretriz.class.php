<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaDiretriz.class.php";

class DaoPlaDiretriz extends PlaDiretriz{
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_diretriz (id_eixo, nm_diretriz, nr_ordem) "
                    . " VALUES (:idEixo, :nmDiretriz, :nrOrdem)");            
            $result->bindValue(":idEixo", $this->getIdEixo(), PDO::PARAM_INT);
            $result->bindValue(":nmDiretriz", $this->getNmDiretriz(), PDO::PARAM_STR);
            $result->bindValue(":nrOrdem", $this->getNrOrdem(), PDO::PARAM_INT);            
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_diretriz SET nm_diretriz = :nmDiretriz "
                    . " , id_eixo = :idEixo, nr_ordem = :nrOrdem "
                    . " WHERE id_diretriz = :idDiretriz ");            
            $result->bindValue(":idDiretriz", $this->getIdDiretriz(), PDO::PARAM_INT);
            $result->bindValue(":idEixo", $this->getIdEixo(), PDO::PARAM_INT);
            $result->bindValue(":nmDiretriz", $this->getNmDiretriz(), PDO::PARAM_STR);
            $result->bindValue(":nrOrdem", $this->getNrOrdem(), PDO::PARAM_INT);               
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_diretriz WHERE id_diretriz = :idDiretriz");
            $result->bindValue(":idDiretriz", $this->getIdDiretriz(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function desativa($pdo){
        try {
            $result = $pdo->prepare("UPDATE pla_diretriz SET st_ativo = 0 "
                    . "WHERE id_diretriz = :idDiretriz ");
            $result->bindValue(":idDiretriz", $this->getIdDiretriz(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();       
        }
    }
    
        
    
    /**
     * Retorna as informações de uma Diretriz Especifica
     * @param type $pdo
     * @return boolean
     */
    function retornaDiretriz($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT id_diretriz, id_eixo, nm_diretriz, nr_ordem, st_ativo"                
                . " FROM pla_diretriz"                
                . " WHERE id_diretriz = :idDiretriz";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idDiretriz", $this->getIdDiretriz(), PDO::PARAM_INT);            
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
     * Retorna todas as Informações da Diretriz Por um Eixo Especifico     
     * @param type $pdo
     * @return boolean
     */
    function retornaTodasDiretrizesPorEixo($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT D.id_diretriz, D.id_eixo, D.nm_diretriz, D.nr_ordem"                
                . " FROM pla_diretriz D"                
                . " WHERE D.id_eixo = :idEixo"
                . " ORDER BY D.nr_ordem, D.nm_diretriz";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idEixo", $this->getIdEixo(), PDO::PARAM_INT);       
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
        
        $sql = " SELECT D.id_diretriz, D.nm_diretriz, D.nr_ordem AS ordemdiretriz"
                . " , E.id_eixo, E.nm_eixo, E.nr_ordem as ordemeixo, P.nm_pes, P.id_pes"
                . " , STRING_AGG(CONCAT(PPA.cd_ppa_proj_ati, ' - ', PPA.nm_ppa_proj_ati), ', ') AS \"Projeto/Atividade do PPA\" "
                . " FROM pla_diretriz D"
                . " INNER JOIN pla_eixo E ON E.id_eixo = D.id_eixo"
                . " INNER JOIN pla_pes P ON P.id_pes = E.id_pes"                
                . " LEFT JOIN pla_eixo_ppa_proj_ati EP ON EP.id_eixo = E.id_eixo"
                . " LEFT JOIN pla_ppa_proj_ati PPA ON PPA.id_ppa_proj_ati = EP.id_ppa_proj_ati"
                . " WHERE D.id_diretriz = :idDiretriz"
                . " GROUP BY D.id_diretriz, D.nm_diretriz, D.nr_ordem, E.id_eixo, E.nm_eixo, E.nr_ordem, P.nm_pes, P.id_pes"
                . " ORDER BY \"Projeto/Atividade do PPA\" desc";
        
        try {
            $sth = $pdo->prepare($sql);  
            $sth->bindValue(":idDiretriz", $this->getIdDiretriz(), PDO::PARAM_INT);       
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

