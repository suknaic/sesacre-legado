<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPtaAcaoDet.class.php";

class DaoPlaPtaAcaoDet extends PlaPtaAcaoDet{
        
    function insert($pdo) {
        try {
            
            $result = $pdo->prepare("INSERT INTO pla_pta_acao_det (id_pta, id_acao, nm_pta_acao_det) "
                    . " VALUES (:idPta, :idAcao, :nmPtaAcaoDet)");
            $result->bindValue(":idPta", $this->getIdPta(), PDO::PARAM_INT);            
            $result->bindValue(":idAcao", $this->getIdAcao(), PDO::PARAM_INT);        
            $result->bindValue(":nmPtaAcaoDet", $this->getNmPtaAcaoDet(), PDO::PARAM_STR);            
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_pta_acao_det SET nm_pta_acao_det = :nmPtaAcaoDet "
                    . " , id_acao = :idAcao"                    
                    . " WHERE id_pta_acao_det = :idPtaAcaoDet ");
            $result->bindValue(":idPtaAcaoDet", $this->getIdPtaAcaoDet(), PDO::PARAM_INT);
            $result->bindValue(":idAcao", $this->getIdAcao(), PDO::PARAM_INT);            
            $result->bindValue(":nmPtaAcaoDet", $this->getNmPtaAcaoDet(), PDO::PARAM_STR);            
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_pta_acao_det WHERE id_pta_acao_det = :idPtaAcaoDet");
            $result->bindValue(":idPtaAcaoDet", $this->getIdPtaAcaoDet(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }               
    
    
    /**
     * Retorna as informações de um Registro Especifico
     * @param type $pdo
     * @return boolean
     */
    function retorna($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT id_pta_acao_det, id_pta, id_acao, nm_pta_acao_det"                
                . " FROM pla_pta_acao_det"                
                . " WHERE id_pta_acao_det = :idPtaAcaoDet";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPtaAcaoDet", $this->getIdPtaAcaoDet(), PDO::PARAM_INT);            
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
     * 
     * @param int $idPtaTitulo
     * @param int $idPas
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPorPtaTituloPasPta(int $idPtaTitulo, int $idPas, $pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT PD.id_pta_acao_det, PD.id_pta, PD.id_acao, PD.nm_pta_acao_det"
                . " , A.nm_acao"                
                . " FROM pla_pta_acao_det PD"
                . " INNER JOIN pla_acao A ON A.id_acao = PD.id_acao"
                . " INNER JOIN pla_pta_titulo PT ON PT.id_pta_titulo = :idPtaTitulo"
                . " INNER JOIN pla_pas_acao  PA ON PA.id_pas = :idPas"
                    . " AND PA.id_ppa_proj_ati = PT.id_ppa_proj_ati"
                    . " AND PA.id_acao = PD.id_acao"                
                . " WHERE PD.id_pta = :idPta";                           
        try {
            $sth = $pdo->prepare($sql);        
            $sth->bindValue(":idPta", $this->getIdPta(), PDO::PARAM_INT);            
            $sth->bindValue(":idPtaTitulo", $idPtaTitulo, PDO::PARAM_INT);     
            $sth->bindValue(":idPas", $idPas, PDO::PARAM_INT);     
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
    
    function retornaTodosDetAcaoPorPTAPPaProjAti($idPta, $idPpaProjAti, $pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT PD.id_pta_acao_det, PD.nm_pta_acao_det"                           
                . " FROM pla_pta_acao_det PD"
                . " INNER JOIN pla_pta P ON P.id_pta = :idPta"
                . " INNER JOIN pla_pas_acao PA ON PA.id_acao = PD.id_acao "
                    . " AND PA.id_ppa_proj_ati = :idPpaProjAti"
                    . " AND PA.id_pas = P.id_pas"                
                . " WHERE PD.id_pta = :idPta"
                . " ORDER BY PD.nm_pta_acao_det";                           
        try {
            $sth = $pdo->prepare($sql);        
            $sth->bindValue(":idPta", $idPta, PDO::PARAM_INT);      
            $sth->bindValue(":idPpaProjAti", $idPpaProjAti, PDO::PARAM_INT);
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
     * Retorna todas as Informações do Detalhamento da Ação Até o PES
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosDadosPorPtaAcaoDet($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT "
                . " A.nm_acao, A.ds_indicador, A.ds_meta_plano, A.tp_cadastro"
                . " , CONCAT(O.nr_ordem, '. ', O.nm_objetivo) AS nm_objetivo, O.id_objetivo"
                . " , CONCAT(D.nr_ordem, '. ', D.nm_diretriz) AS nm_diretriz, D.id_diretriz"
                . " , CONCAT(E.nr_ordem, '. ', E.nm_eixo) AS nm_eixo, E.id_eixo"
                . " , A.tp_cadastro"
                . " , CASE A.tp_cadastro WHEN 'U' THEN S.nm_lotacao ELSE '' END as tipo"
                . " FROM pla_pta_acao_det PAD"
                . " INNER JOIN pla_acao A ON A.id_acao = PAD.id_acao"
                . " INNER JOIN pla_objetivo O ON O.id_objetivo = A.id_objetivo"
                . " INNER JOIN pla_diretriz D ON D.id_diretriz = O.id_diretriz"
                . " INNER JOIN pla_eixo E ON E.id_eixo = D.id_eixo"
                . " LEFT JOIN ses_lotacao S ON S.id_lotacao = A.id_lotacao"                                
                . " WHERE PAD.id_pta_acao_det = :idPtaAcaoDet";              
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idPtaAcaoDet", $this->getIdPtaAcaoDet(), PDO::PARAM_INT);
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
    
    
    function apagarDepois($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT DISTINCT PD.nm_pta_acao_det, PD.id_pta_acao_det"                           
                . " FROM pla_pta_acao_det PD"
                . " INNER JOIN pla_pas_acao PA ON PA.id_acao = PD.id_acao"                                
                . " ORDER BY PD.nm_pta_acao_det";                           
        try {
            $sth = $pdo->prepare($sql);                    
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
        
    
    
    
    
    
}

