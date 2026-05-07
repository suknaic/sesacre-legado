<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinProgramaTrabalho.class.php";

class DaoFinProgramaTrabalho extends FinProgramaTrabalho{
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }    
    
    //Métodos da tabela fin_programa_trabalho
    public function cadastrarProgramaTrabalho($pdo){
        try {
            $sql = $pdo->prepare("INSERT 
                                        INTO fin_programa_trabalho(id_prog_trab_funcao, id_prog_trab_subfuncao, id_prog_trab_programa, cd_programa_trabalho, ds_programa_trabalho, aa_programa_trabalho) 
                                            VALUES (:idProgTrabFuncao, :idProgTrabSubFuncao, :idProgTrabPrograma, :cdProgramaTrabalho, :dsProgramaTrabalho, :aaProgramaTrabalho)");
            $sql->bindValue(":idProgTrabFuncao", $this->getIdProgTrabFuncao(), PDO::PARAM_INT);
            $sql->bindValue(":idProgTrabSubFuncao", $this->getIdProgTrabSubfuncao(), PDO::PARAM_INT);
            $sql->bindValue(":idProgTrabPrograma", $this->getIdProgTrabPrograma(), PDO::PARAM_INT);
            $sql->bindValue(":cdProgramaTrabalho", $this->getCdProgramaTrabalho() === '' ? null : $this->getCdProgramaTrabalho(), PDO::PARAM_STR);
            $sql->bindValue(":dsProgramaTrabalho", $this->getDsProgramaTrabalho() === '' ? null : $this->getDsProgramaTrabalho(), PDO::PARAM_STR);
            $sql->bindValue(":aaProgramaTrabalho", $this->getAaProgramaTrabalho(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    //lista todos os programas trabalho
    public function listarProgramaTrabalho($pdo, $codigo){
        try {
            $sql = $pdo->prepare("SELECT progTrab.id_programa_trabalho, progTrab.cd_programa_trabalho, progTrab.ds_programa_trabalho, progTrab.aa_programa_trabalho, funcao.id_prog_trab_funcao, funcao.cd_prog_trab_funcao, subFuncao.id_prog_trab_subfuncao, subFuncao.cd_prog_trab_subfuncao, programa.id_prog_trab_programa, programa.cd_prog_trab_programa 
                                        FROM fin_programa_trabalho as progTrab
                                            INNER JOIN fin_prog_trab_funcao as funcao ON funcao.id_prog_trab_funcao=progTrab.id_prog_trab_funcao
                                            INNER JOIN fin_prog_trab_subfuncao as subFuncao ON subFuncao.id_prog_trab_subfuncao=progTrab.id_prog_trab_subfuncao
                                            INNER JOIN fin_prog_trab_programa as programa ON programa.id_prog_trab_programa=progTrab.id_prog_trab_programa
                                                    WHERE $codigo AND progTrab.st_ativo='1'");
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);            
            }
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    //lista todos os programas trabalho
    public function listarProgramaTrabalhoTotal($pdo, $codigo){
        try {
            $sql = $pdo->prepare("SELECT 
                                    PT.cd_prog_trab_funcao, PT.cd_prog_trab_subfuncao, pt.cd_prog_trab_programa, 

                                    CONCAT( PT.programa_trabalho, ' - ', PT.ds_programa_trabalho ) AS funcional
                                    , SUM(QV.vl_saldo) AS saldo

                                    FROM fin_qdd_valor QV
                                    INNER JOIN fin_qdd Q ON Q.id_qdd = QV.id_qdd
                                    INNER JOIN fin_fonte F ON F.id_fonte = QV.id_fonte
                                    INNER JOIN fin_despesa_elemento DE ON DE.id_despesa_elemento = QV.id_despesa_elemento 
                                    INNER JOIN view_programa_trabalho PT ON PT.id_programa_trabalho = QV.id_programa_trabalho


                                    WHERE Q.aa_qdd = date_part('YEAR', current_timestamp)
                                    GROUP BY funcional, PT.cd_prog_trab_funcao, PT.cd_prog_trab_subfuncao, pt.cd_prog_trab_programa
                                    ORDER BY funcional");
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);            
            }
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    //edita o programa trabalho
    public function editarProgramaTrabalho($pdo){
        try {
            $sql = $pdo->prepare("UPDATE fin_programa_trabalho 
                                        SET id_prog_trab_funcao=:idProgTrabFuncao, 
                                            id_prog_trab_subfuncao=:idProgtrabSubFuncao, 
                                            id_prog_trab_programa=:idProgtrabPrograma, 
                                            cd_programa_trabalho=:cdProgramaTrabalho, 
                                            ds_programa_trabalho=:dsProgramaTrabalho, 
                                            aa_programa_trabalho=:aaProgramaTrabalho 
                                            WHERE id_programa_trabalho=:idProgramaTrabalho");
            $sql->bindValue(":idProgramaTrabalho", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
            $sql->bindValue(":idProgTrabFuncao", $this->getIdProgTrabFuncao(), PDO::PARAM_INT);
            $sql->bindValue(":idProgtrabSubFuncao", $this->getIdProgTrabSubfuncao(), PDO::PARAM_INT);
            $sql->bindValue(":idProgtrabPrograma", $this->getIdProgTrabPrograma(), PDO::PARAM_INT);
            $sql->bindValue(":cdProgramaTrabalho", $this->getCdProgramaTrabalho(), PDO::PARAM_STR);
            $sql->bindValue(":dsProgramaTrabalho", $this->getDsProgramaTrabalho(), PDO::PARAM_STR);
            $sql->bindValue(":aaProgramaTrabalho", $this->getAaProgramaTrabalho(), PDO::PARAM_STR);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    //desativa o programa trabalho
    public function desativarProgramaTrabalho($pdo){
        try {
            $sql = $pdo->prepare("UPDATE fin_programa_trabalho 
                                        SET st_ativo='0' 
                                            WHERE id_programa_trabalho=:idProgramaTrabalho");
            $sql->bindValue(":idProgramaTrabalho", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    //carrega todos os dados do programa trabalho para edição
    public function carregaDadosProgramaTrabalho($pdo) {
        try {
            $sql = $pdo->prepare("SELECT progTrab.id_programa_trabalho, progTrab.cd_programa_trabalho, progTrab.ds_programa_trabalho, progTrab.aa_programa_trabalho, funcao.id_prog_trab_funcao, funcao.cd_prog_trab_funcao, subFuncao.id_prog_trab_subfuncao, subFuncao.cd_prog_trab_subfuncao, programa.id_prog_trab_programa, programa.cd_prog_trab_programa 
                                        FROM fin_programa_trabalho as progTrab
                                            INNER JOIN fin_prog_trab_funcao as funcao ON funcao.id_prog_trab_funcao=progTrab.id_prog_trab_funcao
                                            INNER JOIN fin_prog_trab_subfuncao as subFuncao ON subFuncao.id_prog_trab_subfuncao=progTrab.id_prog_trab_subfuncao
                                            INNER JOIN fin_prog_trab_programa as programa ON programa.id_prog_trab_programa=progTrab.id_prog_trab_programa
                                                    WHERE progTrab.id_programa_trabalho=:idProgramaTrabalho AND progTrab.st_ativo='1'");
            $sql->bindValue(':idProgramaTrabalho', $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetch(PDO::FETCH_ASSOC);            
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    //retorna o programa trabalho para o log
    public function retornaProgramaTrabalho($pdo){
        try {
            $sql = $pdo->prepare("SELECT * 
                                        FROM fin_programa_trabalho
                                            WHERE id_programa_trabalho=:idProgramaTrabalho");
            $sql->bindValue(':idProgramaTrabalho', $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetch(PDO::FETCH_ASSOC);            
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    //verifica a existência do Programa Trabalho
    public function verificaProgramaTrabalho($pdo){
        try{
            $sql = $pdo->prepare("SELECT cd_programa_trabalho 
                                        FROM fin_programa_trabalho 
                                            WHERE cd_programa_trabalho=:cdProgramaTrabalho");
            $sql->bindValue(":cdProgramaTrabalho", $this->getCdProgramaTrabalho(), PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
            }else{
                $this->sucesso = FALSE;
            }
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    /**
     * Retorna as informações de todos Programa de Trabalho por Um Ano
     * @param type $pdo
     * @return boolean
     */
    function retornaTodosPorAno($pdo){
        
        $retorno = FALSE;   
        
        $sql = " SELECT programa_trabalho, id_programa_trabalho, ds_programa_trabalho, cd_programa_trabalho"                
                . " FROM view_programa_trabalho"                
                . " WHERE aa_programa_trabalho = :aaProgramaTrabalho";                           
        try {
            $sth = $pdo->prepare($sql);            
            $sth->bindValue(":aaProgramaTrabalho", $this->getAaProgramaTrabalho(), PDO::PARAM_INT);            
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
    //=========================================================================================================//
    //Métodos para carregar os combosBoxes
    public function carregaFuncao($pdo){
        try{
            $sql = $pdo->prepare("SELECT id_prog_trab_funcao, cd_prog_trab_funcao 
                                        FROM fin_prog_trab_funcao 
                                            WHERE st_ativo='1'
                                                 ORDER BY cd_prog_trab_funcao");
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function carregaSubFuncao($pdo){
        try{
            $sql = $pdo->prepare("SELECT id_prog_trab_subfuncao, cd_prog_trab_subfuncao 
                                       FROM fin_prog_trab_subfuncao 
                                           WHERE st_ativo='1'
                                                ORDER BY cd_prog_trab_subfuncao");
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function carregaPrograma($pdo){
        try{
            $sql = $pdo->prepare("SELECT id_prog_trab_programa, cd_prog_trab_programa 
                                       FROM fin_prog_trab_programa 
                                           WHERE st_ativo='1'
                                                ORDER BY cd_prog_trab_programa");
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    //=========================================================================================================//
}

