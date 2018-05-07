<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPtaItemValidacao.class.php";

class DaoPlaPtaItemValidacao extends PlaPtaItemValidacao {
    
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
            $result = $pdo->prepare("INSERT INTO pla_pta_item_validacao (id_pas"
                    . " , id_tipo_gasto_categoria, id_pessoa, ds_pta_item_validacao, st_pta_item_validacao) "
                    . " VALUES (:idPas, :idTipoGastoCategoria, :idPessoa, :dsPtaItemValidacao, :stPtaItemValidacao)");            
            $result->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);
            $result->bindValue(":idTipoGastoCategoria", $this->getIdTipoGastoCategoria(), PDO::PARAM_INT);
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->bindValue(":dsPtaItemValidacao", $this->getDsPtaItemValidacao(), PDO::PARAM_STR);                   
            $result->bindValue(":stPtaItemValidacao", $this->getStPtaItemValidacao(), PDO::PARAM_INT);
            
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }
       
        
    function retornaMensagensPorPasINTipo(string $tipos, PDO $pdo){

        $this->sucesso = false;

        $sql = " SELECT "                      
                . " PIV.id_tipo_gasto_categoria"
                . " , P.nm_pessoa, PIV.ds_pta_item_validacao"
                . " , to_char(PIV.dh_pta_item_validacao, 'HH24:MI:SS DD/MM/YYYY') AS dh_pta_item_validacao"
                . " , PIV.st_pta_item_validacao"                
                . " FROM pla_pta_item_validacao PIV"
                . " INNER JOIN ses_pessoa P ON P.id_pessoa = PIV.id_pessoa"                                                                        
                . " WHERE PIV.id_PAS = :idPas "
                    . " AND PIV.id_tipo_gasto_categoria IN (".$tipos.")"
                . " ORDER BY PIV.id_tipo_gasto_categoria, PIV.dh_pta_item_validacao DESC";
        
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);                           
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    
}
