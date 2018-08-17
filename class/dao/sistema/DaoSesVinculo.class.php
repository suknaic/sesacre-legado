<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/sistema/SesVinculo.class.php";

class DaoSesVinculo extends SesVinculo{
    
    function insert(SesVinculo $vinculo, $pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO ses_vinculo (nm_vinculo) "
                    . "VALUES (:nmVinculo)");
            $result->bindValue(":nmVinculo", $vinculo->getNmVinculo(), PDO::PARAM_STR);            
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update(SesVinculo $vinculo, $pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_vinculo SET nm_vinculo = :nmVinculo "
                    . "WHERE id_vinculo = :idVinculo ");
            $result->bindValue(":idVinculo", $vinculo->getIdVinculo(), PDO::PARAM_INT);
            $result->bindValue(":nmVinculo", $vinculo->getNmVinculo(), PDO::PARAM_STR);           
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete(SesVinculo $vinculo, $pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM ses_vinculo WHERE id_vinculo = :idVinculo");
            $result->bindValue(":idVinculo", $vinculo->getIdVinculo(), PDO::PARAM_INT);
            $result->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function desativar(SesVinculo $vinculo, $pdo){
        try {
            $result = $pdo->prepare("UPDATE ses_vinculo SET st_ativo = 0 
                                            WHERE id_vinculo = :idVinculo ");
            $result->bindValue(":idVinculo", $vinculo->getIdVinculo(), PDO::PARAM_INT);                  
            $result->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function ativar($pdo){
        try {
            $result = $pdo->prepare("UPDATE ses_vinculo SET st_ativo = 1 
                                            WHERE id_vinculo = :idVinculo ");
            $result->bindValue(":idVinculo", $this->getIdVinculo(), PDO::PARAM_INT);                  
            $result->execute();
            return TRUE;
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function retornaVinculos($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT id_vinculo, nm_vinculo, st_ativo"                                        
                . " FROM ses_vinculo"
                . " ORDER BY nm_vinculo";                
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
    
    
    
    function retornaVinculo($pdo){
        
        $retorno = FALSE;                    
        
        $sql = " SELECT *"                                        
                . " FROM ses_vinculo"
                . " WHERE id_vinculo = :idVinculo";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idVinculo", $this->getIdVinculo(), PDO::PARAM_INT);            
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
    function buscaVinculoPorNome(SesVinculo $vinculo, $pdo) {        
        $retorno = false;                    
        $semVinculo = "";
        if($vinculo->getIdVinculo() != NULL || $vinculo->getIdVinculo() != ""){
            $semGrupo = " AND id_vinculo <> :idVinculo";
        }        
        $sql = " SELECT "
                . " id_vinculo, nm_vinculo"
                . " FROM ses_vinculo"
                . " WHERE nm_vinculo = :nmVinculo"
                . $semVinculo
                . "";       
        try {
            $sth = $pdo->prepare($sql);                      
            $sth->bindValue(":nmVinculo", $vinculo->getNmVinculo(), PDO::PARAM_STR);
             if($vinculo->getIdVinculo() != NULL || $vinculo->getIdVinculo() != ""){
                $sth->bindValue(":idVinculo", $vinculo->getIdVinculo(), PDO::PARAM_INT);            
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
    
    
}

