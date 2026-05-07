<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinConvenio.class.php";

class DaoFinConvenio extends FinConvenio{
         
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    
    /**
     * Retorna todas os Convenios Por Uma Fonte
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPorFonte($pdo){
        
        $this->sucesso = false;
        
        $sql = " SELECT "                
                . " C.id_convenio, C.nm_convenio"                
                . " FROM fin_convenio C"
                . " WHERE C.id_fonte = :idFonte"                
                . " ORDER BY C.nm_convenio";                
        try {
            $sth = $pdo->prepare($sql);    
            $sth->bindValue(":idFonte", $this->getIdFonte(), PDO::PARAM_INT);            
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);                
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "Nenhum Registro";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();            
        }
    }
                
    
}

