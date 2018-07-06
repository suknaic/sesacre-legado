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

//    function insert($pdo) {
//        try {
//            $result = $pdo->prepare("INSERT INTO fin_qdd (aa_qdd) "
//                    . " VALUES (:aaQdd)");                                        
//            $result->bindValue(":aaQdd", $this->getAaQdd(), PDO::PARAM_INT);                                        
//            $result->execute();
//            $this->sucesso = true;            
//        } catch (PDOException $e) {
//            $this->sucesso = false;            
//            $this->msgRetorno = $e->getMessage();            
//        }
//    }    
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
    
    
    function retornaUltimoAditivo($pdo) {
        $this->sucesso = false;

        $sql = " SELECT count(CA.id_contrato_aditivo) AS quantidade"                    
                . " FROM fin_contrato_aditivo CA"
                . " INNER JOIN fin_contrato C ON C.id_contrato_aditivo_pai = CA.id_contrato"
                . " WHERE CA.id_contrato = :idContrato AND C.st_ativo = '1'"
                . " AND C.tp_contrato = '2' AND C.sq_contrato > 0";
        
        $sql = "SELECT COALESCE(CA.nr_aditivo, 0) as ultimo_aditivo"
                . " , c.ID_CONTRATO, CA.id_contrato_aditivo"
                . " FROM fin_contrato C"
                . " LEFT JOIN fin_contrato CAUX ON CAUX.id_contrato_aditivo_pai = C.id_contrato"
                . " LEFT JOIN fin_contrato_aditivo CA ON CA.id_contrato = CAUX.id_contrato AND CA.st_ativo = '1'"
                . " WHERE C.id_contrato = 1253 AND C.tp_contrato = '2'"
                . " ORDER BY CA.id_contrato_aditivo DESC"
                . " LIMIT 1";
        
        try {
            $result = $pdo->prepare($sql);  
            $result->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC)['quantidade'];
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