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
    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM fin_contrato_aditivo WHERE id_contrato_aditivo = :idContratoAditivo");
            $result->bindValue(":idContratoAditivo", $this->getIdContratoAditivo(), PDO::PARAM_INT);
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
                . " FROM fin_contrato_aditivo"
                . " WHERE id_contrato_aditivo = :idContratoAditivo";
        try {
            $result = $pdo->prepare($sql);            
            $result->bindValue(":idContratoAditivo", $this->getIdContratoAditivo(), PDO::PARAM_INT);
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
    
    
    function retornaNumeroUltimoAditivo(PDO $pdo) {
        $this->sucesso = false;
               
        $sql = "SELECT COALESCE(CA.nr_aditivo, 0) as numero_ultimo_aditivo"
                . " , C.id_contrato, C.nr_contrato"
                . " , CA.id_contrato_aditivo, CAUX.id_contrato as id_contrato_ultimo"
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
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
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
                $stmt->bindValue(":idContratoAditivoPai", $this->getIdContrato(), PDO::PARAM_INT);
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
               
        $sql = "SELECT C.id_contrato, F.id_fornecedor, CA.id_contrato_aditivo, CA.nr_aditivo"                
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
        
    
    public function todosItens($pdo = null) {
        if ($pdo != null) {
            try {
                $sql = "SELECT C.id_contrato, CI.id_cont_itens, CI.qt_itens, CI.vl_itens"
                        . " , CI.id_cont_itens_aditivo"
                        . " , NULL AS id_contrato_motivo, NULL AS id_contrato_finalidade"
                        . " , NULL AS id_contrato_instrumento, NULL AS id_contrato_base_calculo"
                        . " , NULL AS id_contrato_unidade_calculo, NULL AS id_contrato_aquisicao"
                        . " , NULL AS nr_percentual_indice, 'contrato' AS tipo"
                        . " FROM fin_contrato C"
                        . " INNER JOIN fin_fornecedor F ON F.id_contrato = C.id_contrato"
                        . " INNER JOIN fin_cont_itens CI ON CI.id_fornecedor = F.id_fornecedor"
                        . " WHERE C.id_contrato = :idContrato AND C.id_contrato_aditivo_pai IS NULL"
                        . " AND C.tp_contrato = '2' AND C.st_ativo = '1'"
                        . " UNION ALL"
                        . " SELECT C.id_contrato, CI.id_cont_itens, CI.qt_itens, CI.vl_itens"
                        . " , CI.id_cont_itens_aditivo"
                        . " , CA.id_contrato_motivo, CA.id_contrato_finalidade, CA.id_contrato_instrumento, CA.id_contrato_base_calculo"
                        . " , CA.id_contrato_unidade_calculo, CA.id_contrato_aquisicao"
                        . " , CA.nr_percentual_indice, 'aditivo' AS tipo"
                        . " FROM fin_contrato C"
                        . " INNER JOIN fin_contrato_aditivo CA ON CA.id_contrato = C.id_contrato"
                        . " INNER JOIN fin_fornecedor F ON F.id_contrato = C.id_contrato"
                        . " INNER JOIN fin_cont_itens CI ON CI.id_fornecedor = F.id_fornecedor"
                        . " WHERE C.id_contrato_aditivo_pai = :idContrato AND C.tp_contrato = '2'"
                        . " AND C.st_ativo = '1'"
                        . " ORDER BY id_contrato DESC";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
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
    
    public function retornaUltimoContratoAditivo(PDO $pdo = null){
        $this->sucesso = false;
        try{
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();  
            }
            
            $sql = "SELECT C.id_contrato, 'contrato' AS tipo"
                . " FROM fin_contrato C"
                . " WHERE C.id_contrato = :idContrato AND C.id_contrato_aditivo_pai IS NULL"
                . " AND C.tp_contrato = '2' AND C.st_ativo = '1'"
                . " UNION"
                . " SELECT C.id_contrato, 'aditivo_valor' AS tipo"
                . " FROM fin_contrato C"
                . " INNER JOIN fin_contrato_aditivo CA ON CA.id_contrato = C.id_contrato"
                . " WHERE C.id_contrato_aditivo_pai = :idContrato AND C.tp_contrato = '2'"
                . " AND C.st_ativo = '1'"
                . " ORDER BY id_contrato DESC"
                . " LIMIT 1";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
            
            
            
            
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }                
    }
    
    public function retornaTodosGestoresFiscaisSubs(PDO $pdo = null){
        
        $this->sucesso = false;
        try{
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();  
            }
            
            $sql = "SELECT G.id_pessoa, G.tp_gestor as tipo"
                . " , 'gestor' as tabela, P.nm_pessoa"
                . " FROM fin_gestor G"
                . " INNER JOIN ses_pessoa P ON P.id_pessoa = G.id_pessoa"
                . " WHERE G.id_contrato = :idContrato"
                . " UNION ALL"
                . " SELECT F.id_pessoa, F.tp_fiscal as tipo"
                . " , 'fiscal' as tabela, P.nm_pessoa"
                . " FROM fin_fiscal F"
                . " INNER JOIN ses_pessoa P ON P.id_pessoa = F.id_pessoa"
                . " WHERE F.id_contrato = :idContrato"
                . " UNION ALL"
                . " SELECT S.id_pessoa, to_number(S.tp_sub_fiscal, '99G999D9S') as tipo"
                . " , 'sub_fiscal' as tabela, P.nm_pessoa"
                . " FROM fin_sub_fiscal S"
                . " INNER JOIN ses_pessoa P ON P.id_pessoa = S.id_pessoa"
                . " WHERE S.id_contrato = :idContrato";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "";
                $this->sucesso = false;
            }

        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }                    
    }
    
    
    public function dadosCompletoAditivo(PDO $pdo = null){
        $this->sucesso = false;
        try{
            if(empty($pdo)){
                $conexao = new Conexao();
                $pdo = $conexao->connect();  
            }
            
            $sql = "SELECT C.id_contrato, C.nr_contrato"
                    . " , to_char(C.dt_publicacao, 'DD/MM/YYYY') as dt_publicacao"
                    . " , to_char(C.dt_assinatura, 'DD/MM/YYYY') as dt_assinatura"
                    . " , to_char(C.dt_ini_vigencia_contrato, 'DD/MM/YYYY') as dt_ini_vigencia_contrato"
                    . " , to_char(C.dt_fim_vigencia_contrato, 'DD/MM/YYYY') as dt_fim_vigencia_contrato"
                    . " , C.fl_servico_continuado, F.id_fornecedor, P.nm_pessoa"
                    . " , TG.nm_tipo_gasto"
                    . " , CA.ds_justificativa, CA.dt_inicial, CA.dt_final, CA.nr_percentual_indice"
                    . " , CM.nm_contrato_motivo, CF.nm_contrato_finalidade, CI.nm_contrato_instrumento"
                    . " , CB.nm_contrato_base_calculo, CU.nm_contrato_unidade_calculo"
                    . " , CAQ.nm_contrato_aquisicao"                    
                    . " FROM fin_contrato C"
                    . " INNER JOIN fin_contrato_aditivo CA ON CA.id_contrato = C.id_contrato"
                    . " INNER JOIN fin_fornecedor F ON F.id_contrato = C.id_contrato"
                    . " INNER JOIN ses_pessoa P ON P.id_pessoa = F.id_pessoa"
                    . " INNER JOIN fin_contrato_motivo CM ON CM.id_contrato_motivo = CA.id_contrato_motivo"
                    . " LEFT JOIN fin_contrato_finalidade CF ON CF.id_contrato_finalidade = CA.id_contrato_finalidade"
                    . " LEFT JOIN fin_contrato_instrumento CI ON CI.id_contrato_instrumento = CA.id_contrato_instrumento"
                    . " LEFT JOIN fin_contrato_base_calculo CB ON CB.id_contrato_base_calculo = CA.id_contrato_base_calculo"
                    . " LEFT JOIN fin_contrato_unidade_calculo CU ON CU.id_contrato_unidade_calculo = CA.id_contrato_unidade_calculo"
                    . " LEFT JOIN fin_contrato_aquisicao CAQ ON CAQ.id_contrato_aquisicao = CA.id_contrato_aquisicao"
                    . " INNER JOIN pla_tipo_gasto TG ON TG.id_tipo_gasto = C.id_tipo_gasto"                    
                    . " WHERE C.id_contrato = :idContrato AND C.st_ativo ='1'"
                    . " AND C.tp_contrato = '2' AND C.sq_contrato > 0";                    

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "";
                $this->sucesso = false;
            }

        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }
    
    
    public function todosItensHistorico($pdo = null){
        if ($pdo != null){
            try{
                $sql = "SELECT C.id_contrato, C.nr_contrato, CI.id_cont_itens, CI.qt_itens, CI.vl_itens"
                        . " , CI.id_cont_itens_aditivo"
                        . " , NULL AS nm_contrato_motivo"
                        . " , NULL AS nr_percentual_indice, 'contrato' AS tipo"
                        . " , NULL AS id_aditivo_contrato, NULL AS nr_aditivo"
                        . " , CI.nr_item, CI.nr_lote, CI.nm_marca"
                        . " , CI.nm_modelo, CI.ds_itens"
                        . " , MAT.nm_material, MAT.nm_desc_material"
                        . " , MAT.cd_elemento_despesa, MAT.tp_material"
                        . " FROM fin_contrato C"
                        . " INNER JOIN fin_fornecedor F ON F.id_contrato = C.id_contrato"
                        . " INNER JOIN fin_cont_itens CI ON CI.id_fornecedor = F.id_fornecedor"
                        . " INNER JOIN pla_material MAT ON MAT.id_material = CI.id_material"
                        . " WHERE C.id_contrato = :idContrato AND C.id_contrato_aditivo_pai IS NULL"
                        . " AND C.tp_contrato = '2' AND C.st_ativo = '1'"
                        . " UNION ALL"
                        . " SELECT C.id_contrato, C.nr_contrato, CI.id_cont_itens, CI.qt_itens, CI.vl_itens"
                        . " , CI.id_cont_itens_aditivo"
                        . " , CM.nm_contrato_motivo"
                        . " , CA.nr_percentual_indice, 'aditivo_valor' AS tipo"
                        . " , CA.id_contrato_aditivo, CA.nr_aditivo"                    
                        . " , CI.nr_item, CI.nr_lote, CI.nm_marca"
                        . " , CI.nm_modelo, CI.ds_itens"                                                
                        . " , MAT.nm_material, MAT.nm_desc_material"
                        . " , MAT.cd_elemento_despesa, MAT.tp_material"
                        . " FROM fin_contrato C"
                        . " INNER JOIN fin_contrato_aditivo CA ON CA.id_contrato = C.id_contrato"
                        . " INNER JOIN fin_contrato_motivo CM ON CM.id_contrato_motivo = CA.id_contrato_motivo"
                        . " INNER JOIN fin_fornecedor F ON F.id_contrato = C.id_contrato"
                        . " INNER JOIN fin_cont_itens CI ON CI.id_fornecedor = F.id_fornecedor"
                        . " INNER JOIN pla_material MAT ON MAT.id_material = CI.id_material"                      
                        . " WHERE C.id_contrato_aditivo_pai = :idContrato AND C.tp_contrato = '2'"
                        . " AND C.st_ativo = '1'"
                        . " ORDER BY id_contrato ASC";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0){
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else{
                    $this->sucesso = false;
                }
            } catch (PDOException $e){
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }
    
        

}