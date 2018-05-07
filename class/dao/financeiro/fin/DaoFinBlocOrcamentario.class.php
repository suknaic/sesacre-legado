<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinBlocOrcamentario.class.php";

class DaoBlocOrcamentario extends TabelaBlocOrcamentario {
    
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    
    
    public function cadastraBlocOrcamentario($pdo = null) {
        try {
            $sql = $pdo->prepare("INSERT 
                                        INTO fin_bloco_orcamentario(nm_bloco_orcamentario) 
                                            VALUES (:nmBlocOrcamentario)");
            $sql->bindValue(":nmBlocOrcamentario", $this->getNmBlocOrcamentario() === '' ? null : $this->getNmBlocOrcamentario(), PDO::PARAM_STR);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function editaBlocOrcamentario($pdo = null) {
        try{
            $sql = $pdo->prepare("UPDATE fin_bloco_orcamentario 
                                        SET nm_bloco_orcamentario=:nmBlocOrcamentario 
                                            WHERE id_bloco_orcamentario=:idBlocOrcamentario");
            $sql->bindValue(":nmBlocOrcamentario", $this->getNmBlocOrcamentario(), PDO::PARAM_STR);
            $sql->bindValue(":idBlocOrcamentario", $this->getIdBlocOrcamentario(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso= FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function listaBlocOrcamentario($pdo = null) {
        try{
            $sql = $pdo->prepare("SELECT id_bloco_orcamentario, nm_bloco_orcamentario 
                                        FROM fin_bloco_orcamentario 
                                            WHERE nm_bloco_orcamentario =:nmBlocOrcamentario AND st_ativo='1'");
            $sql->bindValue(":nmBlocOrcamentario", $this->getNmBlocOrcamentario(), PDO::PARAM_STR);
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
    
    public function listaTodosBlocOrcamentario($pdo = null){
        try{
            $sql = $pdo->prepare("SELECT id_bloco_orcamentario, nm_bloco_orcamentario 
                                        FROM fin_bloco_orcamentario 
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

    public function retornaBlocOrcamentario($pdo){
        try{
            $sql = $pdo->prepare("SELECT * 
                                        FROM fin_bloco_orcamentario
                                            WHERE id_bloco_orcamentario=:idBlocOrcamentario");
            $sql->bindValue(':idBlocOrcamentario', $this->getIdBlocOrcamentario(), PDO::PARAM_INT);
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

    public function desativaBlocOrcamentario($pdo = null) {
        try {
            $sql = $pdo->prepare("UPDATE fin_bloco_orcamentario  
                                        SET st_ativo='0' 
                                            WHERE id_bloco_orcamentario=:idBlocOrcamentario");
            $sql->bindValue(":idBlocOrcamentario", $this->getIdBlocOrcamentario(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function verificaBlocOrcamentario($pdo = null) {
       try {
           $sql = $pdo->prepare("SELECT nm_bloco_orcamentario 
                                    FROM fin_bloco_orcamentario 
                                        WHERE nm_bloco_orcamentario=:nmBlocOrcamentario");
           $sql->bindValue(":nmBlocOrcamentario", $this->getNmBlocOrcamentario(), PDO::PARAM_STR);
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
