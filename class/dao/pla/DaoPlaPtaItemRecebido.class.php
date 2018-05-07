<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPtaItemRecebido.class.php";

class DaoPlaPtaItemRecebido extends PlaPtaItemRecebido {
    
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
            
            $result = $pdo->prepare("INSERT INTO pla_pta_item_recebido (id_ordem_destino"
                    . " , id_pta_acao_det, dh_recebido, ds_pta_item_recebido, qt_pta_item_recebido) "                                        
                    . " VALUES (:idOrdemDestino, :idPtaAcaoDet, :dhRecebido, :dsPtaItemRecebido, :qtPtaItemRecebido)");                                        
            $result->bindValue(":idOrdemDestino", $this->getIdOrdemDestino(), PDO::PARAM_INT);            
            $result->bindValue(":idPtaAcaoDet", $this->getIdPtaAcaoDet(), PDO::PARAM_INT);
            $result->bindValue(":dhRecebido", $this->getDhRecebido(), PDO::PARAM_STR);
            $result->bindValue(":dsPtaItemRecebido", $this->getDsPtaItemRecebido(), PDO::PARAM_STR);
            $result->bindValue(":qtPtaItemRecebido", $this->getQtPtaItemRecebido(), PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }      
    
    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_pta_item_recebido WHERE id_pta_item_recebido = :idPtaItemRecebido");
            $result->bindValue(":idPtaItemRecebido", $this->getIdPtaItemRecebido(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }   
    
    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_pta_item_recebido SET st_ativo = 0 "
                    . "WHERE id_pta_item_recebido = :idPtaItemRecebido ");
            $result->bindValue(":idPtaItemRecebido", $this->getIdPtaItemRecebido(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }        

    /**
     * Retorna as informações de um Registro Especifico
     * @param type $pdo
     * @return boolean
     */
    function retorna($pdo) {

        $this->sucesso = false;

        $sql = " SELECT id_pta_item_recebido, id_ordem_destino, id_pta_acao_det, dh_recebido"
                . " , ds_pta_item_recebido, qt_pta_item_recebido, id_tipo_gasto, id_tipo_gasto_categoria"
                . " , dh_pta_item_recebido, st_ativo"                    
                . " FROM pla_pta_item_recebido"
                . " WHERE id_pta_item_recebido = :idPtaItemRecebido";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPtaItemRecebido", $this->getIdPtaItemRecebido(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
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
