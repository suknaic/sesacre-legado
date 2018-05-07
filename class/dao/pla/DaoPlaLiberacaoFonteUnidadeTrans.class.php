<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaLiberacaoFonteUnidadeTrans.class.php";

class DaoPlaLiberacaoFonteUnidadeTrans extends PlaLiberacaoFonteUnidadeTrans {
    
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
            $result = $pdo->prepare("INSERT INTO pla_liberacao_fonte_unidade_trans (id_pessoa"
                    . " , id_liberacao_fonte_unidade, vl_liberacao_fonte_unidade_trans, tp_liberacao_fonte_unidade_trans) "                                        
                    . " VALUES (:idPessoa, :idLiberacaoFonteUnidade, :vlLiberacaoFonteUnidadeTrans"
                    . " , :tpLiberacaoFonteUnidadeTrans)");                                        
            $result->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);            
            $result->bindValue(":idLiberacaoFonteUnidade", $this->getIdLiberacaoFonteUnidade(), PDO::PARAM_INT);   
            $result->bindValue(":vlLiberacaoFonteUnidadeTrans", $this->getVlLiberacaoFonteUnidadeTrans(), PDO::PARAM_STR);
            $result->bindValue(":tpLiberacaoFonteUnidadeTrans", $this->getTpLiberacaoFonteUnidadeTrans(), PDO::PARAM_STR);                              
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

        $sql = " SELECT *"                    
                . " FROM pla_liberacao_fonte_unidade"
                . " WHERE id_liberacao_fonte_unidade = :idLiberacaoFonteUnidade";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idLiberacaoFonteUnidade", $this->getIdLiberacaoFonteUnidade(), PDO::PARAM_INT);
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
