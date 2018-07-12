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
                . " INNER JOIN fin_contrato CAUX ON CAUX.id_contrato_aditivo_pai = C.id_contrato AND CAUX.st_ativo = '1'"
                . " INNER JOIN fin_contrato_aditivo CA ON CA.id_contrato = CAUX.id_contrato AND CA.st_ativo = '1'"
                . " WHERE C.id_contrato = :idContrato AND C.tp_contrato = '2'"
                . " ORDER BY CAUX.id_contrato DESC"
                . " LIMIT 1";
        
        try {
            $result = $pdo->prepare($sql);  
            $result->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC)['numero_ultimo_aditivo'];
            } else {
                $this->sucesso = true;                
                $this->msgRetorno = 0;                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    } 
    
    function retornaProximoSequencialAditivo(PDO $pdo) {
        $this->sucesso = false;
               
        $sql = "SELECT (COALESCE(MAX(CAUX.sq_contrato), 0) + 1) as sequencia"                
                . " FROM fin_contrato C"
                . " LEFT JOIN fin_contrato CAUX ON CAUX.id_contrato_aditivo_pai = C.id_contrato"                
                . " WHERE C.id_contrato = :idContrato AND C.tp_contrato = '2'"
                . " GROUP BY C.id_contrato";
                        
        try {
            $result = $pdo->prepare($sql);  
            $result->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC)['sequencia'];
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não foi possível localizar o próximo Aditivo";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    
    public function buscaTodosAditivosPorcontrato($pdo = null) {
        if ($pdo != null) {
            try {
                $sql = "SELECT C.id_contrato, C.nr_contrato, C.ds_objeto"                        
                        . " , (SELECT trim(to_char(COALESCE(SUM(CI.qt_itens*CI.vl_itens), 0), '999G999G990D9999')) FROM fin_cont_itens CI WHERE CI.id_fornecedor = F.id_fornecedor) AS Valor"
                        . " , F.id_fornecedor"
                        . " , CM.nm_contrato_motivo"                                                
                        . " , to_char(C.dt_publicacao, 'DD/MM/YYYY') as dt_publicacao"
                        . " , to_char(C.dt_ini_vigencia_contrato, 'DD/MM/YYYY') as dt_ini_vigencia_contrato"
                        . " , to_char(C.dt_fim_vigencia_contrato, 'DD/MM/YYYY') as dt_fim_vigencia_contrato"                        
                        . " FROM fin_contrato C"
                        . " INNER JOIN (SELECT DISTINCT ON (id_contrato) id_contrato, id_fornecedor, id_pessoa"
                            . " FROM fin_fornecedor"
                            . " ORDER BY id_contrato, id_fornecedor ASC ) F ON F.id_contrato = C.id_contrato"
                        . " INNER JOIN fin_contrato_aditivo CA ON CA.id_contrato = C.id_contrato"
                        . " INNER JOIN fin_contrato_motivo CM ON CM.id_contrato_motivo = CA.id_contrato_motivo"
                        . " WHERE C.id_contrato_aditivo_pai = :idContratoAditivoPai AND C.st_ativo = '1' "
                        . " AND C.sq_contrato > 0 AND C.tp_contrato = '2'";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idContratoAditivoPai", $this->getIdContrato(), PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (PDOException $e) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }
    
    
    function retornaIdsDoContratoPraRemover(PDO $pdo) {
        $this->sucesso = false;
               
        $sql = "SELECT C.id_contrato, F.id_fornecedor, CA.id_contrato_aditivo"                
                . " FROM fin_contrato C"
                . " INNER JOIN (SELECT DISTINCT ON (id_contrato) id_contrato, id_fornecedor, id_pessoa"
                        . " FROM fin_fornecedor"
                        . " ORDER BY id_contrato, id_fornecedor ASC ) F ON F.id_contrato = C.id_contrato"
                . " INNER JOIN fin_contrato_aditivo CA ON CA.id_contrato = C.id_contrato"                
                . " WHERE C.id_contrato = :idContrato AND C.tp_contrato = '2'";                
                        
        try {
            $result = $pdo->prepare($sql);  
            $result->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1){
                $this->sucesso = true; 
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;                
                $this->msgRetorno = "Não foi possível localizar o próximo Aditivo";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }
        
        

}