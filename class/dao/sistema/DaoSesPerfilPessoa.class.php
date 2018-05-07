<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/sistema/SesPerfilPessoa.class.php";

class DaoSesPerfilPessoa extends SesPerfilPessoa{
    
    private $sucesso = null;
    private $msgRetorno = null;  
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO ses_perfil_pessoa (id_perfil, id_pessoa) "
                    . " VALUES (:idPerfil, :idPessoa)");
            $result->bindValue(":idPerfil", $this->getIdPerfil(), PDO::PARAM_INT);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);                
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM ses_perfil_pessoa WHERE id_perfil_pessoa = :idPerfilPessoa");
            $result->bindValue(":idPerfilPessoa", $this->getIdPerfilPessoa(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function deletePerfilPessoa($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM ses_perfil_pessoa "
                    . "WHERE id_perfil = :idPerfil AND id_pessoa = :idPessoa");
            $result->bindValue(":idPerfil", $this->getIdPerfil(), PDO::PARAM_INT);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);     
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function retornaPerfilPessoa($pdo) {
        
        $retorno = FALSE;                    

        $sql = " SELECT id_perfil_pessoa, id_perfil, id_pessoa"                
                . " FROM ses_perfil_pessoa"
                . " WHERE id_pessoa = :idPessoa AND id_perfil = :idPerfil";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPerfil", $this->getIdPerfil(), PDO::PARAM_INT);
            $sth->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);               
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
    
    
    function retornaPerfisPorPessoa($pdo) {
        
        $retorno = FALSE;                    

        $sql = " SELECT id_perfil_pessoa, id_perfil"                
                . " FROM ses_perfil_pessoa"
                . " WHERE id_pessoa = :idPessoa";                
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
     * Verifica se a Pessoa já possui esse Perfil, para que ela não duplique a informação
     * @param type $pdo
     * @return boolean
     */
    function verificaPerfilPessoaExiste($pdo){
        $retorno = FALSE;                    

        $sql = " SELECT id_perfil_pessoa"                
                . " FROM ses_perfil_pessoa"
                . " WHERE id_pessoa = :idPessoa AND id_perfil = :idPerfil";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);   
            $sth->bindValue(":idPerfil", $this->getIdPerfil(), PDO::PARAM_INT);
            $sth->execute();                      
            if ($sth->rowCount() >= 1) {    
                return TRUE;
            }else{                
                return $retorno;
            }      
            return $retorno;
        } catch (PDOException $e) {            
            echo $e->getMessage();
            return $retorno;
        }
    }
    
    
    function retornaPessoaINPerfis($pdo) {
        
        $this->sucesso = FALSE;

        $sql = " SELECT PP.id_perfil_pessoa"
                . " , P.id_pessoa, P.nm_pessoa"
                . " , PER.id_perfil, PER.nm_perfil"
                . " FROM ses_perfil_pessoa PP"
                . " INNER JOIN ses_pessoa P ON P.id_pessoa = PP.id_pessoa"
                . " INNER JOIN ses_perfil PER ON PER.id_perfil = PP.id_perfil"
                . " WHERE PP.id_perfil IN (".$this->getIdPerfil().")"
                . " ORDER BY P.nm_pessoa";                
        try {
            $sth = $pdo->prepare($sql);            
                  
            $sth->execute();                      
            if ($sth->rowCount() >= 1) {    
                $this->sucesso = TRUE;                
                $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);                             
            }else{                
                $this->sucesso = FALSE;
                $this->msgRetorno = "Nenhum Resultado";
            }                  
        } catch (PDOException $e) {            
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = FALSE;
        }    
    }
    
}

