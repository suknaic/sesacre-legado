<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/sistema/SesPais.class.php";

class DaoSesPais extends SesPais{
    
    
    function insert(SesPais $pais, $pdo) { 
        try {
            $result = $pdo->prepare("INSERT INTO ses_pais (nm_sigla, nm_pais) "
                    . "VALUES (:nmSigla, :nmPais)");            
            $result->bindValue(":nmSigla", $pais->getNmSigla(), PDO::PARAM_STR); 
            $result->bindValue(":nmPais", $pais->getNmPais(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update(SesPais $pais, $pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_pais SET nm_pais = :nmPais, nm_sigla = :nmSigla "
                    . "WHERE id_pais = :idPais ");
            $result->bindValue(":idPais", $pais->getIdPais(), PDO::PARAM_INT);
            $result->bindValue(":nmPais", $pais->getNmPais(), PDO::PARAM_STR);
            $result->bindValue(":nmSigla", $pais->getNmSigla(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete(SesPais $pais, $pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM ses_pais WHERE id_pais = :idPais");
            $result->bindValue(":idPais", $pais->getIdPais(), PDO::PARAM_INT);
            $result->execute();

            return "Sucesso";
        } catch (PDOException $e) {
            return $e;
        }
    }
    
    function desativa(SesPais $pais, $pdo){
        try {
            $result = $pdo->prepare("UPDATE ses_pais SET st_ativo = 0 "
                    . "WHERE id_pais = :idPais ");
            $result->bindValue(":idPais", $pais->getIdPais(), PDO::PARAM_INT);                  
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function retornaPaises($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT *"                                        
                . " FROM ses_pais"
                . " ORDER BY nm_pais";                
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
    
    
    
    function retornaPais($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT *"                                        
                . " FROM ses_pais"
                . " WHERE id_pais = :idPais";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPais", $this->getIdPais(), PDO::PARAM_INT);            
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
     * Retorna Informação do Vinculo caso o nome seja igual
     * Caso seja passado um ID Vinculo, esse ID será desconsiderado na busca 
     * @param SesVinculo $vinculo
     * @param type $pdo
     * @return boolean/Object
     */
    function buscaPaisPorNome(SesPais $pais, $pdo) {        
        $retorno = false;                    
        $semPais = "";
        if($pais->getIdPais() != NULL || $pais->getIdPais() != ""){
            $semGrupo = " AND id_pais <> :idPais";
        }        
        $sql = " SELECT "
                . " id_pais, nm_pais"
                . " FROM ses_pais"
                . " WHERE nm_pais = :nmPais"
                . $semPais
                . "";       
        try {
            $sth = $pdo->prepare($sql);                      
            $sth->bindValue(":nmPais", $pais->getNmPais(), PDO::PARAM_STR);
             if($pais->getIdPais() != NULL || $pais->getIdPais() != ""){
                $sth->bindValue(":idPais", $pais->getIdPais(), PDO::PARAM_INT);            
            }
            $sth->execute();            
            if ($sth->rowCount() >= 1) {                
                return $sth->fetchAll(PDO::FETCH_ASSOC);                             
            }else{                
                return $retorno;
            }      
            return $retorno;
        } catch (PDOException $e) {            
            //echo $e->getMessage();
            return $retorno;
        }
    
    }
    function retornaPaisesSelect($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT *"                                        
                . " FROM ses_pais"
                . " ORDER BY nm_pais";                
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
    
    public function verificaSiglaPais($pdo) {
        try {
            $sql = $pdo->prepare('SELECT nm_pais FROM ses_pais WHERE nm_sigla = :sigla');
            $sql->bindValue(':sigla', $this->getNmSigla(), PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return $e;
        }
    }
    
}

