<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPasPessoaLotacao.class.php";

class DaoPlaPasPessoaLotacao extends PlaPasPessoaLotacao{
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_pas_pessoa_lotacao (id_pessoa, id_lotacao) "
                    . " VALUES (:idPessoa, :idLotacao)");
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);                
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_pas_pessoa_lotacao WHERE id_pas_pessoa_lotacao = :idPasPessoaLotacao");
            $result->bindValue(":idPasPessoaLotacao", $this->getIdPasPessoaLotacao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }       
    
    /**
     * Retorna todas as Informações
     * @param type $pdo
     * @return boolean
     */
    function retornaTodos($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT PPL.id_pas_pessoa_lotacao, P.id_pessoa, P.nm_pessoa"
                . " , L.id_lotacao, L.nm_lotacao"
                . " FROM pla_pas_pessoa_lotacao PPL"
                . " INNER JOIN ses_pessoa P ON P.id_pessoa = PPL.id_pessoa"
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = PPL.id_lotacao"
                . " ORDER BY L.nm_lotacao, P.nm_pessoa";        
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
     * Retorna as informações de um Registro Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaPasPessoaLotacao($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT id_pas_pessoa_lotacao, id_pessoa, id_lotacao"                
                . " FROM pla_pas_pessoa_lotacao"                
                . " WHERE id_pas_pessoa_lotacao = :idPasPessoaLotacao";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPasPessoaLotacao", $this->getIdPasPessoaLotacao(), PDO::PARAM_INT);            
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
    
    function retornaLotacaoAutorizadas($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT L.nm_lotacao, L.id_lotacao"                
                . " FROM pla_pas_pessoa_lotacao PPL"
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = PPL.id_lotacao"                
                . " WHERE PPL.id_pessoa = :idPessoa";                           
        try {
            $sth = $pdo->prepare($sql);        
            $sth->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);            
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
     * verifica e Retorna 
     * @param type $pdo
     * @return boolean
     */
    function retornaPermissaoPessoaLotacao($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT id_pas_pessoa_lotacao"                
                . " FROM pla_pas_pessoa_lotacao"                
                . " WHERE id_pessoa = :idPessoa"
                    . " AND id_lotacao = :idLotacao";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $sth->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);            
            $sth->execute();                      
            if ($sth->rowCount() >= 1) {          
                return $sth->fetch(PDO::FETCH_ASSOC);                             
            }else{                
                return $retorno;
            }      
            return $retorno;
        } catch (PDOException $e) {            
            //echo $e->getMessage();
            return $retorno;
        }  
    }
    

    /**
     * Verifica se uma pessoa tem permissão para acessar determinado Pas
     * @param int $idPessoa
     * @param int $idPas
     * @param type $pdo
     * @return boolean
     */
    function retornaPermissaoPessoaPas($idPessoa, $idPas, $pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT PL.id_pas_pessoa_lotacao"                
                . " FROM pla_pas_pessoa_lotacao PL"
                . " INNER JOIN pla_pas P ON P.id_lotacao = PL.id_lotacao"                
                . " WHERE PL.id_pessoa = :idPessoa"
                    . " AND P.id_pas = :idPas";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPessoa", $idPessoa, PDO::PARAM_INT);
            $sth->bindValue(":idPas", $idPas, PDO::PARAM_INT);            
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

