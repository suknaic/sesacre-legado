<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/rh/SesContratoRecadastramento.class.php";

class DaoSesContratoRecadastramento extends SesContratoRecadastramento {
    
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
            $result = $pdo->prepare("INSERT INTO ses_contrato_recadastramento (id_contrato, id_pessoa, is_recadastramento, aa_recadastramento) "
                    . " VALUES (:id_contrato, :id_pessoa, :is_recadastramento, :aa_recadastramento)");                                        
            $result->bindValue(":id_contrato", $this->getIdContrato(), PDO::PARAM_INT);
            $result->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->bindValue(":is_recadastramento", $this->getIsRecadastramento(), PDO::PARAM_BOOL);
            $result->bindValue(":aa_recadastramento", $this->getAaRecadastramento(), PDO::PARAM_INT);                  
            
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }    
    
    function desativa($pdo) {
        try {
            echo $this->getIdContratoRecadastramento();
            $result = $pdo->prepare("UPDATE ses_contrato_recadastramento SET is_ativo = FALSE "
                    . " WHERE id_contrato = :id_contrato ");
            $result->bindValue(":id_contrato", $this->getIdContrato(), PDO::PARAM_INT);            
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function retornaRecadastramentoAtivoPorContratoAno($pdo) {                

        $sql = " SELECT id_contrato_recadastramento, to_char(dh_contrato_recadastramento, 'dd/mm/YYYY') as dh_contrato_recadastramento"
                . " FROM ses_contrato_recadastramento"
                . " WHERE is_ativo "
                . " AND id_contrato = :id_contrato"
                . " AND aa_recadastramento = :aa_recadastramento";
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":id_contrato", $this->getIdContrato(), PDO::PARAM_INT);
            $result->bindValue(":aa_recadastramento", $this->getAaRecadastramento(), PDO::PARAM_INT);
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