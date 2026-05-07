<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPasAcao.class.php";

class DaoPlaPasAcao extends PlaPasAcao{
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_pas_acao (id_pas, id_acao, id_ppa_proj_ati, ds_parceria"
                    . " , ds_meta_programacao, ds_indicador_programacao) "
                    . " VALUES (:idPas, :idAcao, :idPppaProjAti, :dsParceria, :dsMetaProgramacao, :dsIndicadorProgramacao)");
            $result->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);
            $result->bindValue(":idAcao", $this->getIdAcao(), PDO::PARAM_INT);
            $result->bindValue(":idPppaProjAti", $this->getIdPpaProjAti(), PDO::PARAM_INT);
            $result->bindValue(":dsParceria", $this->getDsParceria(), PDO::PARAM_STR);
            $result->bindValue(":dsMetaProgramacao", $this->getDsMetaProgramacao(), PDO::PARAM_STR);
            $result->bindValue(":dsIndicadorProgramacao", $this->getDsIndicadorProgramacao(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_pas_acao SET id_acao = :idAcao "
                    . " , id_ppa_proj_ati = :idPppaProjAti , ds_parceria = :dsParceria"
                    . " ,  ds_meta_programacao = :dsMetaProgramacao, ds_indicador_programacao = :dsIndicadorProgramacao"
                    . " WHERE id_pas_acao = :idPasAcao ");
            $result->bindValue(":idPasAcao", $this->getIdPasAcao(), PDO::PARAM_INT);            
            $result->bindValue(":idAcao", $this->getIdAcao(), PDO::PARAM_INT);
            $result->bindValue(":idPppaProjAti", $this->getIdPpaProjAti(), PDO::PARAM_INT);
            $result->bindValue(":dsParceria", $this->getDsParceria(), PDO::PARAM_STR);
            $result->bindValue(":dsMetaProgramacao", $this->getDsMetaProgramacao(), PDO::PARAM_STR);
            $result->bindValue(":dsIndicadorProgramacao", $this->getDsIndicadorProgramacao(), PDO::PARAM_STR);     
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_pas_acao WHERE id_pas_acao = :idPasAcao");
            $result->bindValue(":idPasAcao", $this->getIdPasAcao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function desativa($pdo){
        try {
            $result = $pdo->prepare("UPDATE pla_pas_acao SET st_ativo = 0 "
                    . "WHERE id_pas_acao = :idPasAcao ");
            $result->bindValue(":idPasAcao", $this->getIdPasAcao(), PDO::PARAM_INT);          
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
          
    
    /**
     * Retorna as informações de um Pas Acao
     * @param type $pdo
     * @return boolean
     */
    function retorna($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT *"                                        
                . " FROM pla_pas_acao"
                . " WHERE id_pas_acao = :idPasAcao";                
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":idPasAcao", $this->getIdPasAcao(), PDO::PARAM_INT);           
            $result->execute();                      
            if ($result->rowCount() >= 1) {          
                return $result->fetch(PDO::FETCH_ASSOC);                             
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
     * Retorna todas as Informações Por um PAS
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPorPas($pdo){
        
        $retorno = FALSE;
                         
        $sql = "SELECT PA.id_pas_acao, PA.id_pas, PA.id_acao, PA.id_ppa_proj_ati"
                . " , PA.ds_parceria, PA.ds_meta_programacao, PA.ds_indicador_programacao"
                . " , A.nm_acao, E.nm_eixo, PPA.nm_ppa_proj_ati"
                . " , A.tp_cadastro"
                . " , CASE A.tp_cadastro WHEN 'U' THEN S.nm_lotacao ELSE '' END as tipo"
                . " FROM pla_pas_acao PA"
                . " INNER JOIN pla_acao A ON A.id_acao = PA.id_acao"
                . " INNER JOIN pla_objetivo O ON O.id_objetivo = A.id_objetivo"
                . " INNER JOIN pla_diretriz D ON D.id_diretriz = O.id_diretriz"
                . " INNER JOIN pla_eixo E ON E.id_eixo = D.id_eixo"
                . " INNER JOIN pla_ppa_proj_ati PPA ON PPA.id_ppa_proj_ati = PA.id_ppa_proj_ati"
                . " LEFT JOIN ses_lotacao S ON S.id_lotacao = A.id_lotacao"                
                . " WHERE PA.id_pas = :idPas";
        
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
    
    function retornaDadosCompleto($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT PA.id_pas_acao, PA.id_acao, PA.id_ppa_proj_ati, PA.ds_parceria"
                . " , PA.ds_meta_programacao, PA.ds_indicador_programacao"
                . " , E.id_eixo"                                        
                . " FROM pla_pas_acao PA"
                . " INNER JOIN pla_acao A ON A.id_acao = PA.id_acao"
                . " INNER JOIN pla_objetivo O ON O.id_objetivo = A.id_objetivo"
                . " INNER JOIN pla_diretriz D ON D.id_diretriz = O.id_diretriz"
                . " INNER JOIN pla_eixo E ON E.id_eixo = D.id_eixo"
                . " WHERE PA.id_pas_acao = :idPasAcao";                
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":idPasAcao", $this->getIdPasAcao(), PDO::PARAM_INT);           
            $result->execute();                      
            if ($result->rowCount() >= 1) {          
                return $result->fetch(PDO::FETCH_ASSOC);                             
            }else{                
                return $retorno;
            }      
            return $retorno;
        } catch (PDOException $e) {            
            echo $e->getMessage();
            return $retorno;
        }  
    } 
    
    function retornaAcaoPorPas($pdo){
        
        $retorno = FALSE;
                         
        $sql = "SELECT DISTINCT ON (PA.id_acao) PA.id_acao, PA.id_pas_acao, PA.id_pas"
                . " , PA.ds_parceria, PA.ds_meta_programacao, PA.ds_indicador_programacao"
                . " , A.nm_acao"                
                . " FROM pla_pas_acao PA"
                . " INNER JOIN pla_acao A ON A.id_acao = PA.id_acao"                
                . " WHERE PA.id_pas = :idPas";                
        
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
    
    function retornaPpaProjAtiPorPas($pdo){
        
        $retorno = FALSE;
                         
        $sql = "SELECT DISTINCT ON (PA.id_ppa_proj_ati) PA.id_ppa_proj_ati"
                . " , PPA.nm_ppa_proj_ati, PPA.cd_ppa_proj_ati"                
                . " FROM pla_pas_acao PA"
                . " INNER JOIN pla_ppa_proj_ati PPA ON PPA.id_ppa_proj_ati = PA.id_ppa_proj_ati"                
                . " WHERE PA.id_pas = :idPas";
                
        
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
    
    function retornaAcaoPorPpaProjAti($pdo){
        
        $retorno = FALSE;
                         
        $sql = "SELECT DISTINCT ON (PA.id_acao) PA.id_acao"                
                . " , A.nm_acao"                
                . " FROM pla_pas_acao PA"
                . " INNER JOIN pla_acao A ON A.id_acao = PA.id_acao"                
                . " WHERE PA.id_ppa_proj_ati = :idPpaProjAti"
                . " AND PA.id_pas = :idPas";                
        
        try {
            $sth = $pdo->prepare($sql);      
            $sth->bindValue(":idPpaProjAti", $this->getIdPpaProjAti(), PDO::PARAM_INT); 
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
    
}

