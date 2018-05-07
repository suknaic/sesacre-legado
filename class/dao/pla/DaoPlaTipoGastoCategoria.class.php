<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaTipoGastoCategoria.class.php";

class DaoPlaTipoGastoCategoria extends PlaTipoGastoCategoria{
    
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
            $result = $pdo->prepare("INSERT INTO pla_tipo_gasto_categoria (nm_tipo_gasto_categoria, id_tipo_gasto, id_lotacao) "
                    . " VALUES (:nmTipoGastoCategoria, :idTipoGasto, :idLotacao)");                     
            $result->bindValue(":nmTipoGastoCategoria", $this->getNmTipoGastoCategoria(), PDO::PARAM_STR);            
            $result->bindValue(":idTipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);   
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT); 
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_tipo_gasto_categoria SET nm_tipo_gasto_categoria = :nmTipoGastoCategoria"
                    . " , id_lotacao = :idLotacao"                    
                    . " WHERE id_tipo_gasto_categoria = :idTipoGastoCategoria ");
            $result->bindValue(":nmTipoGastoCategoria", $this->getNmTipoGastoCategoria(), PDO::PARAM_STR);            
            $result->bindValue(":idTipoGastoCategoria", $this->getIdTipoGastoCategoria(), PDO::PARAM_INT);   
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);        
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_tipo_gasto_categoria WHERE id_tipo_gasto_categoria = :idTipoGastoCategoria");
            $result->bindValue(":idTipoGastoCategoria", $this->getIdTipoGastoCategoria(), PDO::PARAM_INT);
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
    function retorna($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT *"                
                . " FROM pla_tipo_gasto_categoria"                
                . " WHERE id_tipo_gasto_categoria = :idTipoGastoCategoria";                           
        try {
            
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idTipoGastoCategoria", $this->getIdTipoGastoCategoria(), PDO::PARAM_INT);
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
     * Retorna todas as Informações de Todos os Tipo de Gastos Categoria por um Tipo Gasto especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPorTipoGasto($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT id_tipo_gasto_categoria, nm_tipo_gasto_categoria, "
                . " L.id_lotacao, L.nm_lotacao"                
                . " FROM pla_tipo_gasto_categoria TC"
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = TC.id_lotacao"
                . " WHERE TC.id_tipo_gasto = :idTipoGasto"                
                . " ORDER BY TC.nm_tipo_gasto_categoria";                
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idTipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);   
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

