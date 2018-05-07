<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/pla/PlaPreLoaValores.class.php";

class DaoPlaPreLoaValores extends PlaPreLoaValores {
    
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
            $result = $pdo->prepare("INSERT INTO pla_pre_loa_valores (id_pre_loa"
                    . " , id_programa_trabalho, id_despesa_elemento, id_fonte, vl_pre_loa_valores) "                                        
                    . " VALUES (:idPreLoa, :idProgramaTrabalho, :idDespesaElemento, :idFonte, :vlPreLoaValores)");                                        
            $result->bindValue(":idPreLoa", $this->getIdPreLoa(), PDO::PARAM_INT);            
            $result->bindValue(":idProgramaTrabalho", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);                      
            $result->bindValue(":idDespesaElemento", $this->getIdDespesaElemento(), PDO::PARAM_INT);            
            $result->bindValue(":idFonte", $this->getIdFonte(), PDO::PARAM_INT);  
            $result->bindValue(":vlPreLoaValores", $this->getVlPreLoaValores(), PDO::PARAM_INT);  
            $result->execute();
            $this->sucesso = true;            
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();            
        }
    }
    
    function update($pdo) {
        try {
            
            $result = $pdo->prepare("UPDATE pla_pre_loa_valores SET vl_pre_loa_valores = :vlPreLoaValores"
                    . " , id_programa_trabalho = :idProgramaTrabalho, id_despesa_elemento = :idDespesaElemento"
                    . " , id_fonte = :idFonte"                   
                    . " WHERE id_pre_loa_valores = :idPreLoaValores");
            $result->bindValue(":idPreLoaValores", $this->getIdPreLoaValores(), PDO::PARAM_INT);
            $result->bindValue(":idProgramaTrabalho", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);                      
            $result->bindValue(":idDespesaElemento", $this->getIdDespesaElemento(), PDO::PARAM_INT);            
            $result->bindValue(":idFonte", $this->getIdFonte(), PDO::PARAM_INT);  
            $result->bindValue(":vlPreLoaValores", $this->getVlPreLoaValores(), PDO::PARAM_INT);            
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;            
            $this->msgRetorno = $e->getMessage();    
        }
    }
    
    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM pla_pre_loa_valores WHERE id_pre_loa_valores = :idPreLoaValores");
            $result->bindValue(":idPreLoaValores", $this->getIdPreLoaValores(), PDO::PARAM_INT);
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

        $sql = " SELECT id_pre_loa_valores, id_pre_loa, id_programa_trabalho, id_despesa_elemento, id_fonte, vl_pre_loa_valores"                    
                . " FROM pla_pre_loa_valores"
                . " WHERE id_pre_loa_valores = :idPreLoaValores";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPreLoaValores", $this->getIdPreLoaValores(), PDO::PARAM_INT);
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
    
    
    function retornaValoresPorPreLoa($pdo) {          
        $this->sucesso = false;

        $sql = " SELECT V.id_pre_loa_valores, V.id_pre_loa"
                . " , V.id_programa_trabalho, VPT.ds_programa_trabalho, VPT.programa_trabalho"
                . " , V.id_despesa_elemento, VDE.cd_despesa_elemento"
                . " , V.id_fonte, F.nr_fonte"
                . " , V.vl_pre_loa_valores"                    
                . " FROM pla_pre_loa_valores V"
                . " INNER JOIN view_despesa_elemento VDE ON VDE.id_despesa_elemento = V.id_despesa_elemento"
                . " INNER JOIN view_programa_trabalho VPT ON VPT.id_programa_trabalho = V.id_programa_trabalho"
                . " INNER JOIN fin_fonte F ON F.id_fonte = V.id_fonte"
                . " WHERE V.id_pre_loa = :idPreLoa"
                . " ORDER BY VPT.ds_programa_trabalho, VDE.cd_despesa_elemento, F.nr_fonte";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPreLoa", $this->getIdPreLoa(), PDO::PARAM_INT);
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
    
    function verificaExisteCadastro($pdo) {

        $this->sucesso = false;

        $sql = " SELECT id_pre_loa_valores"                    
                . " FROM pla_pre_loa_valores"
                . " WHERE id_pre_loa = :idPreLoa"
                    . " AND id_programa_trabalho = :idProgramaTrabalho"
                    . " AND id_despesa_elemento = :idDespesaElemento"
                    . " AND id_fonte = :idFonte";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":idPreLoa", $this->getIdPreLoa(), PDO::PARAM_INT);
            $result->bindValue(":idProgramaTrabalho", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
            $result->bindValue(":idDespesaElemento", $this->getIdDespesaElemento(), PDO::PARAM_INT);
            $result->bindValue(":idFonte", $this->getIdFonte(), PDO::PARAM_INT);
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
