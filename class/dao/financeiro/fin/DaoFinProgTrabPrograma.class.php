<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinProgTrabPrograma.class.php";

class DaoProgTrabPrograma extends TabelaProgTrabPrograma {
    
    //============================//
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    //============================//
    
    //Métodos de prog_trab_funcao
    public function cadastraTrabPrograma($pdo = null) {
        try {
            $sql = $pdo->prepare("INSERT 
                                        INTO fin_prog_trab_programa(cd_prog_trab_programa) 
                                            VALUES (:cdProgTrabPrograma)");
            $sql->bindValue(":cdProgTrabPrograma", $this->getCodPrograma() === '' ? null : $this->getCodPrograma(), PDO::PARAM_STR);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function editaTrabPrograma($pdo = null) {
        try{
            $sql = $pdo->prepare("UPDATE fin_prog_trab_programa 
                                        SET cd_prog_trab_programa=:cdProgTrabPrograma 
                                            WHERE id_prog_trab_programa=:idCdTrabPrograma");
            $sql->bindValue(":cdProgTrabPrograma", $this->getCodPrograma(), PDO::PARAM_STR);
            $sql->bindValue(":idCdTrabPrograma", $this->getIdCodPrograma(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function listaTrabPrograma($pdo = null) {
        try{
            $sql = $pdo->prepare("SELECT id_prog_trab_programa, cd_prog_trab_programa 
                                        FROM fin_prog_trab_programa 
                                            WHERE cd_prog_trab_programa=:cdProgTrabPrograma AND st_ativo='1'");
            $sql->bindValue(":cdProgTrabPrograma", $this->getCodPrograma(), PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() >= 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function listaTodasTrabPrograma($pdo = null){
        try{
            $sql = $pdo->prepare("SELECT id_prog_trab_programa, cd_prog_trab_programa 
                                        FROM fin_prog_trab_programa 
                                            WHERE st_ativo='1'");
            $sql->execute();
            if ($sql->rowCount() >= 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $this->sucesso = TRUE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function retornaTrabPrograma($pdo) {
        try{
            $sql = $pdo->prepare("SELECT * 
                                        FROM fin_prog_trab_programa 
                                            WHERE id_prog_trab_programa=:idCdTrabPrograma");
            $sql->bindValue(":idCdTrabPrograma", $this->getIdCodPrograma(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() >= 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $this->sucesso = TRUE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function desativaTrabPrograma($pdo = null) {
        try {
            $sql = $pdo->prepare("UPDATE fin_prog_trab_programa 
                                        SET st_ativo='0' 
                                            WHERE id_prog_trab_programa=:idCdTrabPrograma");
            $sql->bindValue(":idCdTrabPrograma", $this->getIdCodPrograma(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function verificaTrabPrograma($pdo = null) {
       try {
           $sql = $pdo->prepare("SELECT cd_prog_trab_programa 
                                    FROM fin_prog_trab_programa 
                                        WHERE cd_prog_trab_programa=:cdProgTrabPrograma");
           $sql->bindValue(":cdProgTrabPrograma", $this->getCodPrograma(), PDO::PARAM_STR);
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
    //========================================================================//
    
}
