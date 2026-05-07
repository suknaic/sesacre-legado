<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinProgTrabFuncao.class.php";

class DaoProgTrabFuncao extends TabelaProgTrabFuncao {
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    
    //Métodos de prog_trab_funcao
    public function cadastraTrabFuncao($pdo = null) {
        try {
            $sql = $pdo->prepare("INSERT 
                                        INTO fin_prog_trab_funcao(cd_prog_trab_funcao) 
                                            VALUES (:cdProgTraFuncao)");
            $sql->bindValue(":cdProgTraFuncao", $this->getCodFuncao() === '' ? null : $this->getCodFuncao(), PDO::PARAM_STR);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function editaTrabFuncao($pdo = null) {
        try{
            $sql = $pdo->prepare("UPDATE fin_prog_trab_funcao 
                                        SET cd_prog_trab_funcao=:cdTrabFuncao 
                                            WHERE id_prog_trab_funcao=:idcdTrabFuncao");
            $sql->bindValue(":cdTrabFuncao", $this->getCodFuncao(), PDO::PARAM_STR);
            $sql->bindValue(":idcdTrabFuncao", $this->getIdCodFuncao(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso= FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function listaTrabFuncao($pdo = null) {
        try{
            $sql = $pdo->prepare("SELECT id_prog_trab_funcao, cd_prog_trab_funcao 
                                        FROM fin_prog_trab_funcao 
                                            WHERE cd_prog_trab_funcao=:cdTrabFuncao AND st_ativo='1'");
            $sql->bindValue(":cdTrabFuncao", $this->getCodFuncao(), PDO::PARAM_STR);
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
    
    public function listaTodasTrabFuncao($pdo = null){
        try{
            $sql = $pdo->prepare("SELECT id_prog_trab_funcao, cd_prog_trab_funcao 
                                        FROM fin_prog_trab_funcao 
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
    
    public function retornaTrabFuncao($pdo){
        try{
            $sql = $pdo->prepare("SELECT * 
                                        FROM fin_prog_trab_funcao 
                                            WHERE id_prog_trab_funcao=:idProgTrabFruncao");
            $sql->bindValue(':idProgTrabFruncao', $this->getIdCodFuncao(), PDO::PARAM_INT);
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

    public function desativaTrabFuncao($pdo = null) {
        try {
            $sql = $pdo->prepare("UPDATE fin_prog_trab_funcao 
                                        SET st_ativo='0' 
                                            WHERE id_prog_trab_funcao=:idCdTrabFuncao");
            $sql->bindValue(":idCdTrabFuncao", $this->getIdCodFuncao(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function verificaTrabFuncao($pdo = null) {
       try {
           $sql = $pdo->prepare("SELECT cd_prog_trab_funcao 
                                    FROM fin_prog_trab_funcao 
                                        WHERE cd_prog_trab_funcao= :cdProgTrabFuncao");
           $sql->bindValue(":cdProgTrabFuncao", $this->getCodFuncao(), PDO::PARAM_STR);
           $sql->execute();
           
           if ($sql->rowCount() > 0){
               $this->sucesso = TRUE;
           }else{
               $this->sucesso = FALSE;
           }
       } catch (Exception $e) {
           return $e->getMessage();
       }
    }
    //========================================================================//
    
}
