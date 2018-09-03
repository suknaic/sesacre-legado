<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/liquidacao/ConLiquidacao.class.php";

class DaoConLiquidacao extends ConLiquidacao {
    
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
                      
            $result = $pdo->prepare("INSERT INTO con_liquidacao (nr_liquidacao, id_empenho"
                    . " , id_liquidacao_situacao, id_lotacao, dt_liquidacao, vl_liquidacao"
                    . " , ds_liquidacao)"
                    . " VALUES (:nr_liquidacao, :id_empenho, :id_liquidacao_situacao"
                    . " , :id_lotacao, :dt_liquidacao, :vl_liquidacao, :ds_liquidacao);");                                        
            $result->bindValue(":nr_liquidacao", $this->getNrLiquidacao(), PDO::PARAM_STR);
            $result->bindValue(":id_empenho", $this->getIdEmpenho(), PDO::PARAM_INT);
            $result->bindValue(":id_liquidacao_situacao", $this->getIdLiquidacaoSituacao(), PDO::PARAM_INT);
            $result->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->bindValue(":dt_liquidacao", $this->getDtLiquidacao(), PDO::PARAM_STR);
            $result->bindValue(":vl_liquidacao", $this->getVlLiquidacao(), PDO::PARAM_STR);
            $result->bindValue(":ds_liquidacao", !empty($this->getDsLiquidacao()) ? $this->getDsLiquidacao() : null, PDO::PARAM_STR);                       
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }    
    
    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE con_liquidacao SET nr_liquidacao = :nr_liquidacao"
                    . " , id_lotacao = :id_lotacao, dt_liquidacao = :dt_liquidacao, vl_liquidacao = :vl_liquidacao"
                    . " , ds_liquidacao = :ds_liquidacao"
                    . " WHERE id_liquidacao = :id_liquidacao ");
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->bindValue(":nr_liquidacao", $this->getNrLiquidacao(), PDO::PARAM_STR);                        
            $result->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->bindValue(":dt_liquidacao", $this->getDtLiquidacao(), PDO::PARAM_STR);
            $result->bindValue(":vl_liquidacao", $this->getVlLiquidacao(), PDO::PARAM_STR);
            $result->bindValue(":ds_liquidacao", !empty($this->getDsLiquidacao()) ? $this->getDsLiquidacao() : null, PDO::PARAM_STR);                       
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function desativa($pdo){
        try {
            $result = $pdo->prepare("UPDATE con_liquidacao SET st_ativo = '0'"                    
                    . " WHERE id_liquidacao = :id_liquidacao ");
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);            
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function mudaSituacao($pdo){
        try {
            $result = $pdo->prepare("UPDATE con_liquidacao SET id_liquidacao_situacao = :id_liquidacao_situacao"                    
                    . " WHERE id_liquidacao = :id_liquidacao ");
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);            
            $result->bindValue(":id_liquidacao_situacao", $this->getIdLiquidacaoSituacao(), PDO::PARAM_INT);   
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function retorna($pdo) {
        $this->sucesso = false;
        $sql = " SELECT *"                    
                . " FROM con_liquidacao"
                . " WHERE id_liquidacao = :id_liquidacao";
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
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