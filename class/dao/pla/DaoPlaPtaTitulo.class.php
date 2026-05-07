<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPtaTitulo.class.php";

class DaoPlaPtaTitulo extends PlaPtaTitulo{
        
    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO pla_pta_titulo (id_pta, nm_pta_titulo, id_programa_trabalho, id_ppa_proj_ati, ds_objeto, ds_justificativa) "
                    . " VALUES (:idPta, :nmPtaTitulo, :idProgramaTrabalho, :idPpaProjAti, :dsObjeto, :dsJustificativa)");
            $result->bindValue(":idPta", $this->getIdPta(), PDO::PARAM_INT);            
            $result->bindValue(":nmPtaTitulo", $this->getNmPtaTitulo(), PDO::PARAM_STR);
            $result->bindValue(":idProgramaTrabalho", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
            $result->bindValue(":idPpaProjAti", $this->getIdPpaProjAti(), PDO::PARAM_INT);            
            $result->bindValue(":dsObjeto", $this->getDsObjeto(), PDO::PARAM_STR);
            $result->bindValue(":dsJustificativa", $this->getDsJustificativa(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE pla_pta_titulo SET nm_pta_titulo = :nmPtaTitulo "
                    . " , id_programa_trabalho = :idProgramaTrabalho, id_ppa_proj_ati = :idPpaProjAti"
                    . " , ds_objeto = :dsObjeto, ds_justificativa = :dsJustificativa"                    
                    . " WHERE id_pta_titulo = :idPtaTitulo ");
            $result->bindValue(":idPtaTitulo", $this->getIdPtaTitulo(), PDO::PARAM_INT);            
            $result->bindValue(":nmPtaTitulo", $this->getNmPtaTitulo(), PDO::PARAM_STR);
            $result->bindValue(":idProgramaTrabalho", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
            $result->bindValue(":idPpaProjAti", $this->getIdPpaProjAti(), PDO::PARAM_INT);            
            $result->bindValue(":dsObjeto", $this->getDsObjeto(), PDO::PARAM_STR);
            $result->bindValue(":dsJustificativa", $this->getDsJustificativa(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_pta_titulo WHERE id_pta_titulo = :idPtaTitulo");
            $result->bindValue(":idPtaTitulo", $this->getIdPtaTitulo(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();            
        }
    }       
    
    /**
     * Retorna todas as Informações
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosDadosPorPtaTitulo($pdo){
        
        $retorno = FALSE;
        
        $sql = " SELECT PT.nm_pta_titulo "
                . " , to_char(P.dt_inicio, 'DD/MM/YYYY') AS dt_inicio"
                . " , to_char(P.dt_fim, 'DD/MM/YYYY') AS dt_fim"                
                . " , P.id_pta, P.nm_pta"
                . " , PAS.id_pas, PAS.nm_pas"
                . " , PPA.nm_ppa_proj_ati, PPA.id_ppa_proj_ati"
                . " , VPT.id_programa_trabalho, VPT.ds_programa_trabalho, VPT.programa_trabalho"                                
                . " , PT.ds_objeto, PT.ds_justificativa"
                . " , L.id_lotacao, L.nm_lotacao"
                . " FROM pla_pta_titulo PT"
                . " INNER JOIN pla_pta P ON P.id_pta = PT.id_pta"
                . " INNER JOIN pla_pas PAS ON PAS.id_pas = P.id_pas"
                . " INNER JOIN view_programa_trabalho VPT ON VPT.id_programa_trabalho = PT.id_programa_trabalho"
                . " INNER JOIN pla_ppa_proj_ati PPA ON PPA.id_ppa_proj_ati = PT.id_ppa_proj_ati"
                . " INNER JOIN ses_lotacao L ON L.id_lotacao = PAS.id_lotacao"                
                . " WHERE PT.id_pta_titulo = :idPtaTitulo";                
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idPtaTitulo", $this->getIdPtaTitulo(), PDO::PARAM_INT);
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
    function retorna($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT id_pta_titulo, id_pta, nm_pta_titulo, id_programa_trabalho, id_ppa_proj_ati, ds_objeto, ds_justificativa, st_ativo"
                . " FROM pla_pta_titulo" 
                . " WHERE id_pta_titulo = :idPtaTitulo";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":idPtaTitulo", $this->getIdPtaTitulo(), PDO::PARAM_INT);            
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
    
    
   
    
    
    
               
    
}

