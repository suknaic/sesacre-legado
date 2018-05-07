<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinProgTrabSubFuncao.class.php";

class DaoProgTrabSubFuncao extends TabelaProgTrabSubFuncao {
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    
    //Métodos de prog_trab_sub_funcao
    public function cadastraTrabSubFuncao($pdo = null) {
        try {
            $sql = $pdo->prepare("INSERT 
                                        INTO fin_prog_trab_subfuncao(cd_prog_trab_subfuncao) 
                                            VALUES (:cdProgTraSubFuncao)");
            $sql->bindValue(":cdProgTraSubFuncao", $this->getCodSubFuncao() === '' ? null : $this->getCodSubFuncao(), PDO::PARAM_STR);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function editaTrabSubFuncao($pdo = null) {
        try{
            $sql = $pdo->prepare("UPDATE fin_prog_trab_subfuncao
                                        SET cd_prog_trab_subfuncao=:cdProgTraSubFuncao 
                                            WHERE id_prog_trab_subfuncao=:idCdTrabSubFuncao");
            $sql->bindValue(":cdProgTraSubFuncao", $this->getCodSubFuncao(), PDO::PARAM_STR);
            $sql->bindValue(":idCdTrabSubFuncao", $this->getIdCodSubFuncao(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function listaTrabSubFuncao($pdo = null) {
        try{
            $sql = $pdo->prepare("SELECT id_prog_trab_subfuncao, cd_prog_trab_subfuncao 
                                        FROM fin_prog_trab_subfuncao 
                                            WHERE cd_prog_trab_subfuncao=:cdProgTraSubFuncao AND st_ativo='1'");
            $sql->bindValue(":cdProgTraSubFuncao", $this->getCodSubFuncao(), PDO::PARAM_STR);
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
    
    public function listaTodasTrabSubFuncao($pdo = null){
        try{
            $sql = $pdo->prepare("SELECT id_prog_trab_subfuncao, cd_prog_trab_subfuncao 
                                        FROM fin_prog_trab_subfuncao 
                                            WHERE st_ativo='1'");
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
    
    public function retornarTrabSubFuncao($pdo) {
        try{
            $sql = $pdo->prepare("SELECT * 
                                        FROM fin_prog_trab_subfuncao 
                                            WHERE id_prog_trab_subfuncao=:idCdTrabSubFuncao");
            $sql->bindValue(":idCdTrabSubFuncao", $this->getIdCodSubFuncao(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    public function desativaTrabSubFuncao($pdo = null) {
        try {
            $sql = $pdo->prepare("UPDATE fin_prog_trab_subfuncao 
                                        SET st_ativo='0' 
                                            WHERE id_prog_trab_subfuncao=:idCdTrabSubFuncao");
            $sql->bindValue(":idCdTrabSubFuncao", $this->getIdCodSubFuncao(), PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function verificaTrabSubFuncao($pdo = null) {
       try {
           $sql = $pdo->prepare("SELECT cd_prog_trab_subfuncao 
                                    FROM fin_prog_trab_subfuncao 
                                        WHERE cd_prog_trab_subfuncao= :cdProgTraSubFuncao");
           $sql->bindValue(":cdProgTraSubFuncao", $this->getCodSubFuncao(), PDO::PARAM_STR);
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
