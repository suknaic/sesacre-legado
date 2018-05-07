<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPas.class.php";

class DaoPlaPas extends PlaPas{
    
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
            $result = $pdo->prepare("INSERT INTO pla_pas (id_pes, id_lotacao, nm_pas, dt_inicio, dt_fim, id_pessoa_resp, id_pessoa_exec, ds_observacao) "
                    . " VALUES (:idPes, :idLotacao, :nmPas, :dtInicio, :dtFim, :idPessoaResp, :idPessoaExec, :dsObservacao)");
            $result->bindValue(":idPes", $this->getIdPes(), PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->bindValue(":nmPas", $this->getNmPas(), PDO::PARAM_STR);
            $result->bindValue(":dtInicio", $this->getDtInicio(), PDO::PARAM_STR);
            $result->bindValue(":dtFim", $this->getDtFim(), PDO::PARAM_STR);
            $result->bindValue(":idPessoaResp", $this->getIdPessoaResp(), PDO::PARAM_INT);
            $result->bindValue(":idPessoaExec", $this->getIdPessoaExec(), PDO::PARAM_INT);
            $result->bindValue(":dsObservacao", $this->getDsObservacao(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_pas SET id_pes = :idPes "
                    . " , id_lotacao = :idLotacao, nm_pas = :nmPas, dt_inicio = :dtInicio, dt_fim = :dtFim"
                    . " , id_pessoa_resp = :idPessoaResp, id_pessoa_exec = :idPessoaExec"
                    . " , ds_observacao = :dsObservacao"
                    . " WHERE id_pas = :idPas ");
            $result->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);
            $result->bindValue(":idPes", $this->getIdPes(), PDO::PARAM_INT);
            $result->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->bindValue(":nmPas", $this->getNmPas(), PDO::PARAM_STR);
            $result->bindValue(":dtInicio", $this->getDtInicio(), PDO::PARAM_STR);
            $result->bindValue(":dtFim", $this->getDtFim(), PDO::PARAM_STR);
            $result->bindValue(":idPessoaResp", $this->getIdPessoaResp(), PDO::PARAM_INT);
            $result->bindValue(":idPessoaExec", $this->getIdPessoaExec(), PDO::PARAM_INT);
            $result->bindValue(":dsObservacao", $this->getDsObservacao(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_pas WHERE id_pas = :idPas");
            $result->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }
    
    function mudarStatus($pdo) {
        $this->sucesso = false;
        try {
            $result = $pdo->prepare("UPDATE pla_pas SET st_pas = :stPas "                    
                    . " WHERE id_pas = :idPas ");
            $result->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);            
            $result->bindValue(":stPas", $this->getStPas(), PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();            
        }
    }
    
    /**
     * Retorna todas as Informações
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosDadosPorPas($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT P.id_pas, P.nm_pas"
                . " , to_char(P.dt_inicio, 'DD/MM/YYYY') AS dt_inicio"
                . " , to_char(P.dt_fim, 'DD/MM/YYYY') AS dt_fim"
                . " , P.ds_observacao, P.st_pas"
                . " , PES.id_pes, PES.nm_pes"
                . " , PE.id_pessoa AS id_pessoa_exec, PE.nm_pessoa AS nm_pessoa_exec"
                . " , PR.id_pessoa AS id_pessoa_resp, PR.nm_pessoa AS nm_pessoa_resp"
                . " , L.id_lotacao, L.nm_lotacao"
                . " FROM pla_pas P"
                . " INNER JOIN pla_pes PES ON PES.id_pes = P.id_pes"
                . " INNER JOIN ses_pessoa PR ON PR.id_pessoa = P.id_pessoa_resp"
                . " INNER JOIN ses_pessoa PE ON PE.id_pessoa = P.id_pessoa_exec"
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = P.id_lotacao"
                . " WHERE P.id_pas = :idPas";                

        
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                return $sth->fetch(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }
    
    
    /**
     * Retorna as informações de um Registro Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaPas($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT id_pas, id_pes, id_lotacao, nm_pas, dt_inicio, dt_fim"
                . " , id_pessoa_resp, id_pessoa_exec, ds_observacao, st_pas, st_ativo"                
                . " FROM pla_pas"                
                . " WHERE id_pas = :idPas";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_INT);            
            $sth->execute();                      
            if ($sth->rowCount() >= 1) {        
                return $sth->fetch(PDO::FETCH_ASSOC);            
            }else{               
                return $retorno;
            }      
            return $retorno;
        } catch (PDOException $e) {           
            echo $e->getMessage();
            return $retorno;
        }  
    }
    
    /**
     * Retorna todos os Pas de um Ano especifico
     * @param type $ano
     * @param type $pdo
     * @return boolean
     */
    function retornaDadosPasPorAno($ano, $pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT P.id_pas, P.nm_pas"
                . " , to_char(P.dt_inicio, 'DD/MM/YYYY') AS dt_inicio"
                . " , to_char(P.dt_fim, 'DD/MM/YYYY') AS dt_fim"
                . " , P.ds_observacao"
                . " , PES.id_pes, PES.nm_pes"
                . " , PE.id_pessoa AS id_pessoa_exec, PE.nm_pessoa AS nm_pessoa_exec"
                . " , PR.id_pessoa AS id_pessoa_resp, PR.nm_pessoa AS nm_pessoa_resp"
                . " , L.id_lotacao, L.nm_lotacao"
                . " FROM pla_pas P"
                . " INNER JOIN pla_pes PES ON PES.id_pes = P.id_pes"
                . " INNER JOIN ses_pessoa PR ON PR.id_pessoa = P.id_pessoa_resp"
                . " INNER JOIN ses_pessoa PE ON PE.id_pessoa = P.id_pessoa_exec"
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = P.id_lotacao"
                . " WHERE to_char(P.dt_inicio, 'YYYY') = :ano"
                . " ORDER BY L.nm_lotacao";                
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":ano", $ano, PDO::PARAM_STR);
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }                
    }
    
    /**
     * Retorna todos os Pas de um Ano especifico
     * @param int $idLotacao
     * @param string $ano
     * @param type $pdo
     * @return boolean
     */
    function retornaDadosPasPorLotacaoAno($idLotacao, $ano, $pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT P.id_pas, P.nm_pas"
                . " , to_char(P.dt_inicio, 'DD/MM/YYYY') AS dt_inicio"
                . " , to_char(P.dt_fim, 'DD/MM/YYYY') AS dt_fim"
                . " , P.ds_observacao"
                . " , PES.id_pes, PES.nm_pes"
                . " , PE.id_pessoa AS id_pessoa_exec, PE.nm_pessoa AS nm_pessoa_exec"
                . " , PR.id_pessoa AS id_pessoa_resp, PR.nm_pessoa AS nm_pessoa_resp"
                . " , L.id_lotacao, L.nm_lotacao"
                . " FROM pla_pas P"
                . " INNER JOIN pla_pes PES ON PES.id_pes = P.id_pes"
                . " INNER JOIN ses_pessoa PR ON PR.id_pessoa = P.id_pessoa_resp"
                . " INNER JOIN ses_pessoa PE ON PE.id_pessoa = P.id_pessoa_exec"
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = P.id_lotacao"
                . " WHERE to_char(P.dt_inicio, 'YYYY') = :ano AND P.id_lotacao = :idLotacao"
                . " ORDER BY L.nm_lotacao";                
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":ano", $ano, PDO::PARAM_STR);
            $sth->bindValue(":idLotacao", $idLotacao, PDO::PARAM_INT);
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }                
    }
    
    /**
     * Retorna todos os Pas de uma Lotação especifica
     * @param int $idLotacao     
     * @param type $pdo
     * @return boolean
     */
    function retornaDadosPasPorLotacao($idLotacao, $pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT P.id_pas, P.nm_pas"
                . " , to_char(P.dt_inicio, 'DD/MM/YYYY') AS dt_inicio"
                . " , to_char(P.dt_fim, 'DD/MM/YYYY') AS dt_fim"
                . " , P.ds_observacao"
                . " , PES.id_pes, PES.nm_pes"
                . " , PE.id_pessoa AS id_pessoa_exec, PE.nm_pessoa AS nm_pessoa_exec"
                . " , PR.id_pessoa AS id_pessoa_resp, PR.nm_pessoa AS nm_pessoa_resp"
                . " , L.id_lotacao, L.nm_lotacao"
                . " FROM pla_pas P"
                . " INNER JOIN pla_pes PES ON PES.id_pes = P.id_pes"
                . " INNER JOIN ses_pessoa PR ON PR.id_pessoa = P.id_pessoa_resp"
                . " INNER JOIN ses_pessoa PE ON PE.id_pessoa = P.id_pessoa_exec"
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = P.id_lotacao"
                . " WHERE P.id_lotacao = :idLotacao"
                . " ORDER BY P.dt_inicio DESC";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idLotacao", $idLotacao, PDO::PARAM_INT);
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }                
    }  
    
    function retornaPasPlanejamentoValidar($pdo){
        
        $this->sucesso = false;
        
        $sql = " SELECT P.id_pas, P.nm_pas"                                             
                . " , L.id_lotacao, L.nm_lotacao"
                . " FROM pla_pas P"                              
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = P.id_lotacao"
                . " WHERE P.st_pas = :stPas"
                . " ORDER BY L.nm_lotacao";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":stPas", $this->getStPas(), PDO::PARAM_STR);
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);                
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();            
        }                
    } 
    
    /**
     * 
     * @param string $status
     * @param int $ano
     * @param type $pdo
     */
    function retornaPasPlanejamentoLiberar(string $status, int $ano, $pdo){
        
        $this->sucesso = false;
        
        $sql = " SELECT P.id_pas, P.nm_pas, P.st_pas"                                             
                . " , L.id_lotacao, L.nm_lotacao"
                . " FROM pla_pas P"                               
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = P.id_lotacao"
                . " WHERE P.st_pas IN (".$status.")"
                . " AND to_char(P.dt_inicio, 'YYYY') = :ano"
                . " ORDER BY P.st_pas DESC, L.nm_lotacao";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":ano", $ano, PDO::PARAM_STR);
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);                
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();            
        }                
    } 
    
    /**
     * Retorna Pas que não estejam Autorizadas em um Determinado Ano
     * @param int $ano
     * @param type $pdo
     */
    function retornaPasNaoAutorizadasPorAno(int $ano, $pdo){
        
        $this->sucesso = false;        
        
        $sql = " SELECT P.id_pas, P.nm_pas, P.st_pas"                                             
                . " , L.id_lotacao, L.nm_lotacao"
                . " FROM pla_pas P"                              
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = P.id_lotacao"
                . " WHERE P.st_pas <> :stPas OR P.st_pas IS NULL"
                . " AND to_char(P.dt_inicio, 'YYYY') = :ano"
                . " ORDER BY L.nm_lotacao";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":ano", $ano, PDO::PARAM_STR);
            $sth->bindValue(":stPas", $this->getStPas(), PDO::PARAM_STR);
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);                
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();            
        }                
    }
    
    /**
     * Retorna todas as PAS de um certo ano que estão autorizadas
     * @param int $ano
     * @param type $pdo
     */
    function retornaPasAutorizadasPorAno(int $ano, $pdo){
        
        $this->sucesso = false;        
        
        $sql = " SELECT P.id_pas, P.nm_pas, P.st_pas"                                             
                . " , L.id_lotacao, L.nm_lotacao"
                . " FROM pla_pas P"                              
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = P.id_lotacao"
                . " WHERE P.st_pas = :stPas"
                . " AND to_char(P.dt_inicio, 'YYYY') = :ano"
                . " ORDER BY L.nm_lotacao";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":ano", $ano, PDO::PARAM_STR);
            $sth->bindValue(":stPas", $this->getStPas(), PDO::PARAM_STR);
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);                
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();            
        }                
    }
    
    
    function retornaPasNaoCriadasPorAno(int $ano, $pdo){
        
        $this->sucesso = false;        
        
        $sql = " SELECT L.nm_lotacao"                                             
                . " , COALESCE(json_object_agg(PE.id_pessoa, PE.nm_pessoa ORDER BY (PE.nm_pessoa)) FILTER (WHERE PE.id_pessoa IS NOT NULL), '[]') AS nm_pessoa"
                . " FROM pla_pas_pessoa_lotacao PL"
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = PL.id_lotacao"
                . " INNER JOIN ses_pessoa PE ON PE.id_pessoa = PL.id_pessoa"
                . " LEFT JOIN pla_pas P ON P.id_lotacao = PL.id_lotacao"
                    . " AND to_char(P.dt_inicio, 'YYYY') = :ano"                                              
                . " WHERE P.id_pas IS NULL"                
                . " GROUP by L.id_lotacao";                
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":ano", $ano, PDO::PARAM_STR);            
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);                
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();            
        }                
    }
    
    
    
    function retornaSimulacaoPreLOAPorAno(int $ano, string $stPtaItem, $pdo){
        
        $this->sucesso = false;        
        
        $sql = " SELECT  SUM(PI.qt_pta_item*PI.vl_pta_item) AS Valor"
                . " , VPT.id_programa_trabalho, VPT.programa_trabalho, VPT.ds_programa_trabalho"
                . " , VDE.id_despesa_elemento, VDE.cd_despesa_elemento"
                . " , F.id_fonte, F.nr_fonte"
                . " FROM pla_pas PAS"
                . " INNER JOIN pla_pta PTA ON PTA.id_pas = PAS.id_pas "
                    . " AND PTA.st_ativo = '1'"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta = PTA.id_pta "
                    . " AND PT.st_ativo = '1'"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo "
                    . " AND PI.st_pta_item = :stPtaItem"
                . " INNER JOIN pla_material M ON M.id_material = PI.id_material"
                . " INNER JOIN view_despesa VD ON VD.id_despesa = M.id_despesa"
                . " INNER JOIN view_despesa_elemento VDE ON VDE.id_despesa_elemento = VD.id_despesa_elemento"
                . " INNER JOIN view_programa_trabalho VPT ON VPT.id_programa_trabalho = PT.id_programa_trabalho"
                . " INNER JOIN fin_fonte F ON F.id_fonte = PI.id_fonte"
                . " WHERE PAS.st_pas = :stPas AND PAS.st_ativo = '1'"
                . " AND to_char(PAS.dt_inicio, 'YYYY') = :ano"
                . " GROUP BY VPT.id_programa_trabalho, VPT.programa_trabalho, VPT.ds_programa_trabalho"
                . " , VDE.id_despesa_elemento, VDE.cd_despesa_elemento, F.id_fonte"
                . " ORDER BY VPT.ds_programa_trabalho, VDE.cd_despesa_elemento, F.nr_fonte";
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":ano", $ano, PDO::PARAM_STR);
            $sth->bindValue(":stPas", $this->getStPas(), PDO::PARAM_STR);
            $sth->bindValue(":stPtaItem", $stPtaItem, PDO::PARAM_STR);
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);                
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();            
        }                
    }
    
    
    function retornaValoresPASLiberadoFonteUnidade($pdo){
        
        $this->sucesso = false;        
        
        $sql = " SELECT PAS.id_pas, PAS.id_lotacao, PAS.dt_inicio"
                . " , LIB.vl_liberado AS vl_liberado"
                . " , SUM(PI.vl_pta_item*PI.qt_pta_item) as valor_pta"
                . " FROM pla_pas PAS"
                . " INNER JOIN pla_pta PTA ON PTA.id_pas = PAS.id_pas"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta = PTA.id_pta"
                . " INNER JOIN pla_pta_item PI ON PI.id_pta_titulo = PT.id_pta_titulo"
                . " INNER JOIN (SELECT SUM(LFU.vl_inicial+LFU.vl_suplementado-LFU.vl_reduzido) AS vl_liberado"
                                . " , LFU.id_lotacao, LF.aa_liberacao_fonte"
                            . " FROM pla_liberacao_fonte_unidade LFU"
                            . " INNER JOIN pla_liberacao_fonte LF ON LF.id_liberacao_fonte = LFU.id_liberacao_fonte"
                            . " GROUP BY LFU.id_lotacao, LF.aa_liberacao_fonte"
                            . " ) AS LIB ON LIB.id_lotacao = PAS.id_lotacao "
                                    . " AND LIB.aa_liberacao_fonte = cast(to_char(PAS.dt_inicio, 'YYYY') as int)"
                . " WHERE PAS.id_pas = :idPas AND PI.st_pta_item >= '1'"
                . " GROUP BY PAS.id_pas, LIB.vl_liberado";  			 
          
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPas", $this->getIdPas(), PDO::PARAM_STR);            
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetch(PDO::FETCH_ASSOC);                
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();            
        }                
    }
    
    
    function retornaTodasLotacoes($pdo){
        
        $this->sucesso = false;        
        
        $sql = "SELECT DISTINCT L.id_lotacao, L.nm_lotacao"
                . " FROM pla_pas P "
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = P.id_lotacao"
                . " ORDER BY L.nm_lotacao";		 
          
        try {
            $sth = $pdo->prepare($sql);                                
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);                
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();            
        }                
    }
    
        
}

