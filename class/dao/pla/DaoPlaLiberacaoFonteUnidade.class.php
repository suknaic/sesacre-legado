<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaLiberacaoFonteUnidade.class.php";

class DaoPlaLiberacaoFonteUnidade extends PlaLiberacaoFonteUnidade {
    
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
            $result = $pdo->prepare("INSERT INTO pla_liberacao_fonte_unidade (id_liberacao_fonte"
                    . " , id_lotacao, id_programa_trabalho, id_despesa_elemento, vl_inicial) "                                        
                    . " VALUES (:idLiberacaoFonte, :idLotacao, :idProgramaTrabalho, :idDespesaElemento, :vlInicial)");                                        
            $result->bindValue(":idLiberacaoFonte", $this->getIdLiberacaoFonte(), PDO::PARAM_INT);            
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);   
            $result->bindValue(":idProgramaTrabalho", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
            $result->bindValue(":idDespesaElemento", $this->getIdDespesaElemento(), PDO::PARAM_INT);
            $result->bindValue(":vlInicial", $this->getVlInicial(), PDO::PARAM_STR);                     
            $result->execute();            
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }    
       
      
    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_liberacao_fonte_unidade WHERE id_liberacao_fonte_unidade = :idLiberacaoFonteUnidade");
            $result->bindValue(":idLiberacaoFonteUnidade", $this->getIdLiberacaoFonteUnidade(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage(); 
        }
    }  
     
    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_liberacao_fonte_unidade SET vl_inicial = :vlInicial"                    
                    . " WHERE id_liberacao_fonte_unidade = :idLiberacaoFonteUnidade ");
            $result->bindValue(":idLiberacaoFonteUnidade", $this->getIdLiberacaoFonteUnidade(), PDO::PARAM_INT);
            $result->bindValue(":vlInicial", $this->getVlInicial(), PDO::PARAM_STR);                   
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function updateSuplementado($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_liberacao_fonte_unidade SET vl_suplementado = :vlSuplementado"                    
                    . " WHERE id_liberacao_fonte_unidade = :idLiberacaoFonteUnidade ");
            $result->bindValue(":idLiberacaoFonteUnidade", $this->getIdLiberacaoFonteUnidade(), PDO::PARAM_INT);
            $result->bindValue(":vlSuplementado", $this->getVlSuplementado(), PDO::PARAM_STR);                   
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;           
            $this->msgRetorno = $e->getMessage(); 
        }
    }
    
    function updateReduzido($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_liberacao_fonte_unidade SET vl_reduzido = :vlReduzido"                    
                    . " WHERE id_liberacao_fonte_unidade = :idLiberacaoFonteUnidade ");
            $result->bindValue(":idLiberacaoFonteUnidade", $this->getIdLiberacaoFonteUnidade(), PDO::PARAM_INT);
            $result->bindValue(":vlReduzido", $this->getVlReduzido(), PDO::PARAM_STR);                   
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
    
    function existeDuplicidade(PDO $pdo) { 
        $this->sucesso = false;

        $sql = " SELECT id_liberacao_fonte_unidade"                     
                . " FROM pla_liberacao_fonte_unidade"                
                . " WHERE id_liberacao_fonte = :idLiberacaoFonte "
                . " AND id_lotacao = :idLotacao AND id_programa_trabalho = :idProgramaTrabalho"
                . " AND id_despesa_elemento = :idDespesaElemento";
        try {
            $result = $pdo->prepare($sql);  
            $result->bindValue(":idLiberacaoFonte", $this->getIdLiberacaoFonte(), PDO::PARAM_STR);
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->bindValue(":idProgramaTrabalho", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
            $result->bindValue(":idDespesaElemento", $this->getIdDespesaElemento(), PDO::PARAM_INT);
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
    
    function retornaDadosLiberacaoFonte($pdo) {

        $this->sucesso = false;

        $sql = " SELECT LFU.id_liberacao_fonte_unidade, LFU.id_liberacao_fonte"
                . " , LFU.vl_inicial, LFU.vl_suplementado, LFU.vl_reduzido"
                . " , (LFU.vl_inicial+LFU.vl_suplementado-LFU.vl_reduzido) AS vl_total"
                . " , CONCAT(PT.cd_programa_trabalho, ' - ', PT.ds_programa_trabalho) AS programa_trabalho"
                . " , PT.id_programa_trabalho"
                . " , DE.cd_despesa_elemento, DE.id_despesa_elemento"
                . " , S.nm_lotacao, S.id_lotacao"                
                . " FROM pla_liberacao_fonte_unidade LFU"
                . " INNER JOIN view_programa_trabalho PT ON PT.id_programa_trabalho = LFU.id_programa_trabalho"
                . " INNER JOIN view_despesa_elemento DE ON DE.id_despesa_elemento = LFU.id_despesa_elemento"
                . " INNER JOIN ses_lotacao S ON S.id_lotacao = LFU.id_lotacao"
                . " WHERE LFU.id_liberacao_fonte = :idLiberacaoFonte "
                . " ORDER BY S.nm_lotacao, PT.cd_programa_trabalho, DE.cd_despesa_elemento";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idLiberacaoFonte", $this->getIdLiberacaoFonte(), PDO::PARAM_INT);
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
    
    function retornaFontePorLotacaoAnoProgTrab(int $ano, $pdo) {

        $this->sucesso = false;

        $sql = " SELECT DISTINCT F.id_fonte, F.nr_fonte"                        
                . " FROM pla_liberacao_fonte_unidade LFU"
                . " INNER JOIN pla_liberacao_fonte LF ON LF.id_liberacao_fonte = LFU.id_liberacao_fonte"
                    . " AND LF.aa_liberacao_fonte = :aaLiberacaoFonte"
                . " INNER JOIN fin_fonte F ON F.id_fonte = LF.id_fonte"                
                . " WHERE LFU.id_lotacao = :idLotacao AND LFU.id_programa_trabalho = :idProgramaTrabalho"
                . " ORDER BY F.nr_fonte";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":aaLiberacaoFonte",$ano, PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->bindValue(":idProgramaTrabalho", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
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
    
    function retornaPorLotacaoAnoProgTrab(int $ano, $pdo) {

        $this->sucesso = false;

        $sql = " SELECT LFU.id_liberacao_fonte_unidade, F.id_fonte, F.nr_fonte"
                . " , (LFU.vl_inicial+LFU.vl_suplementado-LFU.vl_reduzido) AS vl_total"
                . " , DE.id_despesa_elemento, DE.cd_despesa_elemento"
                . " FROM pla_liberacao_fonte_unidade LFU"
                . " INNER JOIN pla_liberacao_fonte LF ON LF.id_liberacao_fonte = LFU.id_liberacao_fonte"
                    . " AND LF.aa_liberacao_fonte = :aaLiberacaoFonte"
                . " INNER JOIN fin_fonte F ON F.id_fonte = LF.id_fonte"
                . " INNER JOIN view_despesa_elemento DE ON DE.id_despesa_elemento = LFU.id_despesa_elemento"                
                . " WHERE LFU.id_lotacao = :idLotacao AND LFU.id_programa_trabalho = :idProgramaTrabalho"
                . " ORDER BY F.nr_fonte, DE.cd_despesa_elemento";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":aaLiberacaoFonte",$ano, PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->bindValue(":idProgramaTrabalho", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
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
    
    function retornaPorLotacaoAno(int $ano, $pdo) {

        $this->sucesso = false;

        $sql = " SELECT LFU.id_liberacao_fonte_unidade, F.id_fonte, F.nr_fonte"
                . " , (LFU.vl_inicial+LFU.vl_suplementado-LFU.vl_reduzido) AS vl_total"
                . " , DE.id_despesa_elemento, DE.cd_despesa_elemento"
                . " FROM pla_liberacao_fonte_unidade LFU"
                . " INNER JOIN pla_liberacao_fonte LF ON LF.id_liberacao_fonte = LFU.id_liberacao_fonte"
                    . " AND LF.aa_liberacao_fonte = :aaLiberacaoFonte"
                . " INNER JOIN fin_fonte F ON F.id_fonte = LF.id_fonte"
                . " INNER JOIN view_despesa_elemento DE ON DE.id_despesa_elemento = LFU.id_despesa_elemento"                
                . " WHERE LFU.id_lotacao = :idLotacao"
                . " ORDER BY F.nr_fonte, DE.cd_despesa_elemento";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":aaLiberacaoFonte",$ano, PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);            
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
    
    
    
    function existeLiberacaoParaItemDoPTA(int $idProgramaTrabalho, int $idLotacao
            , int $ano, int $idFonte, int $idDespesa, PDO $pdo) { 
        $this->sucesso = false;

        $sql = " SELECT id_liberacao_fonte_unidade"                     
                . " FROM pla_liberacao_fonte_unidade LFU"                
                . " INNER JOIN pla_liberacao_fonte LF ON LF.id_liberacao_fonte = LFU.id_liberacao_fonte"
                    . " AND LF.id_fonte = :idFonte "
                    . " AND LF.aa_liberacao_fonte = :aaLiberacaoFonte"
                . " INNER JOIN view_despesa D ON D.id_despesa = :idDespesa "
                    . " AND D.id_despesa_elemento = LFU.id_despesa_elemento"
                . " WHERE LFU.id_lotacao = :idLotacao AND LFU.id_programa_trabalho = :idProgramaTrabalho";                                
        try {
            $result = $pdo->prepare($sql);  
            $result->bindValue(":idFonte", $idFonte, PDO::PARAM_STR);
            $result->bindValue(":aaLiberacaoFonte", $ano, PDO::PARAM_INT);
            $result->bindValue(":idDespesa", $idDespesa, PDO::PARAM_INT);
            $result->bindValue(":idProgramaTrabalho", $idProgramaTrabalho, PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $idLotacao, PDO::PARAM_INT);
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
    
    
    function retornaValorAtuaPtaQdd(int $ano, int $idFonte, $pdo){

        $this->sucesso = false;
        
        $sql = "SELECT FONTE.id_fonte, FONTE.nr_fonte"
                . " , CONCAT(PT.cd_programa_trabalho, ' - ', PT.ds_programa_trabalho) AS programa_trabalho"
                . " , DE.cd_despesa_elemento, DE.id_despesa_elemento"
                . " , SUM(LFU.vl_inicial+LFU.vl_suplementado-LFU.vl_reduzido) AS vl_atualizado"
                . " , PTA.vl_total_pta AS vl_pta"
                . " , (QV.vl_qdd_inicial+QV.vl_qdd_suplementado-QV.vl_qdd_reduzido) AS vl_qdd_atual"
                . " , QV.vl_saldo AS vl_qdd_saldo"
                . " FROM pla_liberacao_fonte_unidade LFU"
                . " INNER JOIN pla_liberacao_fonte LF ON LF.id_liberacao_fonte = LFU.id_liberacao_fonte"
                . " INNER JOIN fin_fonte FONTE ON FONTE.id_fonte = LF.id_fonte"
                . " LEFT JOIN ("
                    . " SELECT PTA.id_programa_trabalho, PI.id_fonte, D.id_despesa_elemento"
                    . " , SUM(PI.qt_pta_item*PI.vl_pta_item) AS vl_total_pta"
                    . " FROM pla_pta_titulo PTA"
                    . " INNER JOIN pla_pta P ON P.id_pta = PTA.id_pta AND to_char(P.dt_inicio, 'YYYY') = :ano"
                    . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PTA.id_pta_titulo"
                    . " INNER JOIN pla_material M ON M.id_material = PI.id_material"
                    . " INNER JOIN fin_despesa D ON D.id_despesa = M.id_despesa"
                    . " WHERE PTA.st_ativo = '1' AND PI.st_pta_item >= '1'"
                    . " AND PI.id_fonte = :idFonte"
                    . " GROUP BY PTA.id_programa_trabalho, PI.id_fonte, D.id_despesa_elemento"
                    . " ) AS PTA ON PTA.id_programa_trabalho = LFU.id_programa_trabalho"
                    . " AND PTA.id_fonte = LF.id_fonte AND PTA.id_despesa_elemento = LFU.id_despesa_elemento"
                . " LEFT JOIN fin_qdd_valor QV ON QV.id_programa_trabalho = LFU.id_programa_trabalho"
                    . " AND QV.id_fonte = LF.id_fonte AND QV.id_despesa_elemento = LFU.id_despesa_elemento"
                . " LEFT JOIN fin_qdd QDD ON QDD.id_qdd = QV.id_qdd AND QDD.aa_qdd = :anoInt"
                . " INNER JOIN view_programa_trabalho PT ON PT.id_programa_trabalho = LFU.id_programa_trabalho"
                . " INNER JOIN view_despesa_elemento DE ON DE.id_despesa_elemento = LFU.id_despesa_elemento"
                . " WHERE LF.aa_liberacao_fonte = :anoInt AND LF.id_fonte = :idFonte"
                . " GROUP BY FONTE.id_fonte, PT.id_programa_trabalho, DE.id_despesa_elemento, CONCAT(PT.cd_programa_trabalho, ' - ', PT.ds_programa_trabalho), DE.cd_despesa_elemento, PTA.vl_total_pta, QV.id_qdd_valor"
                . " ORDER BY FONTE.nr_fonte, CONCAT(PT.cd_programa_trabalho, ' - ', PT.ds_programa_trabalho), DE.cd_despesa_elemento";




        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":ano", $ano, PDO::PARAM_STR);
            $result->bindValue(":idFonte", $idFonte, PDO::PARAM_INT);            
            $result->bindValue(":anoInt", $ano, PDO::PARAM_INT);
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
