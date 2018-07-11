<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/FinContratoAditivoTb.class.php";

class DaoFinContratoAditivo extends FinContratoAditivoTb {
    
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
                      
            $result = $pdo->prepare("INSERT INTO fin_contrato_aditivo (id_contrato, id_contrato_motivo, id_contrato_finalidade"
                    . " , id_contrato_instrumento, id_contrato_base_calculo, id_contrato_unidade_calculo"
                    . " , id_contrato_aquisicao, ds_justificativa, nr_aditivo, dt_inicial, dt_final, nr_percentual_indice)"
                    . " VALUES (:idContrato, :idContratoMotivo, :idContratoFinalidade, :idContratoInstrumento"
                    . " , :idContratoBaseCalculo, :idContratoUnidadeCalculo, :idContratoAquisicao, :dsJustificativa"
                    . " , :nrAditivo, :dtInicial, :dtFim, :nrPercentualIndice)");                                        
            $result->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
            $result->bindValue(":idContratoMotivo", $this->getIdContratoMotivo(), PDO::PARAM_INT);
            $result->bindValue(":idContratoFinalidade", $this->getIdContratoFinalidade(), PDO::PARAM_INT);
            $result->bindValue(":idContratoInstrumento", $this->getIdContratoInstrumento(), PDO::PARAM_INT);
            $result->bindValue(":idContratoBaseCalculo", $this->getIdContratoBaseCalculo(), PDO::PARAM_INT);
            $result->bindValue(":idContratoUnidadeCalculo", $this->getIdContratoUnidadeCalculo(), PDO::PARAM_INT);
            $result->bindValue(":idContratoAquisicao", $this->getIdContratoAquisicao(), PDO::PARAM_INT);
            $result->bindValue(":dsJustificativa", $this->getDsJustificativa(), PDO::PARAM_STR);
            $result->bindValue(":nrAditivo", $this->getNrAditivo(), PDO::PARAM_INT);
            $result->bindValue(":dtInicial", $this->getDtInicial(), PDO::PARAM_STR);
            $result->bindValue(":dtFim", $this->getDtFinal(), PDO::PARAM_STR);
            $result->bindValue(":nrPercentualIndice", !empty($this->getNrPercentualIndice()) ? $this->getNrPercentualIndice() : null, PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }    
//    
//    function update($pdo) {
//        try {
//            $result = $pdo->prepare("UPDATE fin_qdd SET aa_qdd = :aaQdd "
//                    . "WHERE id_qdd = :idQdd ");
//            $result->bindValue(":aaQdd", $this->getAaQdd(), PDO::PARAM_INT);
//            $result->bindValue(":idQdd", $this->getIdQdd(), PDO::PARAM_INT);
//            $result->execute();
//            $this->sucesso = true; 
//        } catch (PDOException $e) {
//            $this->sucesso = false;           
//            $this->msgRetorno = $e->getMessage(); 
//        }
//    }
//    
//    function delete($pdo) {
//        try {
//            $result = $pdo->prepare("DELETE FROM fin_qdd WHERE id_qdd = :idQdd");
//            $result->bindValue(":idQdd", $this->getIdQdd(), PDO::PARAM_INT);
//            $result->execute();
//            $this->sucesso = true; 
//        } catch (PDOException $e) {
//            $this->sucesso = false;            
//            $this->msgRetorno = $e->getMessage(); 
//        }
//    }   
    
//    function retornaTodos($pdo) {
//        $this->sucesso = false;
//
//        $sql = " SELECT id_contrato_aditivo, nm_contrato_aditivo"                    
//                . " FROM fin_contrato_aditivo"
//                . " WHERE st_ativo = '1'";
//        try {
//            $result = $pdo->prepare($sql);            
//            $result->execute();
//            if ($result->rowCount() >= 1){
//                $this->sucesso = true; 
//                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
//            } else {
//                $this->sucesso = false;                
//                $this->msgRetorno = "Não encontrou Registros";                
//            }            
//        } catch (PDOException $e) {
//            $this->sucesso = false;            
//            $this->msgRetorno = $e->getMessage(); 
//        }
//    }    
    
    
    function retornaNumeroUltimoAditivo(PDO $pdo) {
        $this->sucesso = false;

               
        $sql = "SELECT COALESCE(CA.nr_aditivo, 0) as numero_ultimo_aditivo"
                . " , c.id_contrato, CA.id_contrato_aditivo"
                . " FROM fin_contrato C"
                . " LEFT JOIN fin_contrato CAUX ON CAUX.id_contrato_aditivo_pai = C.id_contrato"
                . " LEFT JOIN fin_contrato_aditivo CA ON CA.id_contrato = CAUX.id_contrato AND CA.st_ativo = '1'"
                . " WHERE C.id_contrato = :idContrato AND C.tp_contrato = '2'"
                . " ORDER BY CA.id_contrato_aditivo DESC"
                . " LIMIT 1";
        
        try {
            $result = $pdo->prepare($sql);  
            $result->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC)['numero_ultimo_aditivo'];
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