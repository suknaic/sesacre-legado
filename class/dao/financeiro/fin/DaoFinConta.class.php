<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinConta.class.php";

class DaoFinConta extends FinConta{
                     
    
    /**
     * Retorna as informações de um Registro Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaConta($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT id_conta, id_conta_financeira, id_fonte_tipo, id_fonte, id_portaria_ds, id_convenio"                
                . " FROM fin_conta"                
                . " WHERE id_conta = :idConta";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idConta", $this->getIdConta(), PDO::PARAM_INT);            
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

