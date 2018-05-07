<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinRedeTematica.class.php";

class DaoRedeTematica extends TabelaRedeTematica {
//=========================================================================//
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
//=========================================================================//
    //cadastra rede tematica
    public function cadastraRedeTematica($pdo = null) {
        try {
            $sql = $pdo->prepare("INSERT 
                                        INTO fin_rede_tematica(nm_rede_tematica, id_bloco_orcamentario) 
                                            VALUES (:nmRedeTematica, :idBlocOrcamentario)");
            $sql->bindValue(":nmRedeTematica", $this->getNmRedeTematica() === '' ? null : $this->getNmRedeTematica(), PDO::PARAM_STR);
            $sql->bindValue(":idBlocOrcamentario", $this->getIdBlocOrcamentario(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    //edita rede tematica
    public function editaRedeTematica($pdo = null) {
        try{
            $sql = $pdo->prepare("UPDATE fin_rede_tematica
                                        SET nm_rede_tematica=:nmRedetematica, id_bloco_orcamentario=:idBlocOrcamentario 
                                            WHERE id_rede_tematica=:idRedeTematica");
            $sql->bindValue(":idRedeTematica", $this->getIdRedeTematica(), PDO::PARAM_INT);
            $sql->bindValue(":nmRedetematica", $this->getNmRedeTematica(), PDO::PARAM_STR);
            $sql->bindValue(":idBlocOrcamentario", $this->getIdBlocOrcamentario(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso= FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    //lista rede tematica
    public function listaRedeTematica($codigo, $pdo = null) {
        try{
            $sql = $pdo->prepare("SELECT REDE.id_rede_tematica, REDE.nm_rede_tematica, BLOCO.id_bloco_orcamentario, BLOCO.nm_bloco_orcamentario 
                                        FROM fin_rede_tematica as REDE
                                            INNER JOIN fin_bloco_orcamentario as BLOCO ON BLOCO.id_bloco_orcamentario=REDE.id_bloco_orcamentario
                                                 WHERE $codigo
                                                      AND REDE.st_ativo='1'");
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
    
    //lista todas as redes tematicas 
    public function listaTodasRedeTematica($pdo = null){
        try{
            $sql = $pdo->prepare("SELECT REDE.id_rede_tematica, REDE.nm_rede_tematica, BLOCO.id_bloco_orcamentario, BLOCO.nm_bloco_orcamentario 
                                        FROM fin_rede_tematica as REDE
                                            INNER JOIN fin_bloco_orcamentario as BLOCO ON BLOCO.id_bloco_orcamentario=REDE.id_bloco_orcamentario
                                                 WHERE REDE.st_ativo='1'");
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
    //carrega todos os dados da Rede Temática para a edição
    public function carregaDadosRedeTematica($pdo) {
        try {
            $sql = $pdo->prepare("SELECT REDE.id_rede_tematica, REDE.nm_rede_tematica, BLOCO.id_bloco_orcamentario, BLOCO.nm_bloco_orcamentario 
                                        FROM fin_rede_tematica as REDE
                                            INNER JOIN fin_bloco_orcamentario as BLOCO ON BLOCO.id_bloco_orcamentario=REDE.id_bloco_orcamentario
                                                 WHERE REDE.id_rede_tematica=:idRedeTematica");
            $sql->bindValue(':idRedeTematica', $this->getIdRedeTematica(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    //desativa rede tematica
    public function desativaRedeTematica($pdo = null) {
        try {
            $sql = $pdo->prepare("UPDATE fin_rede_tematica  
                                        SET st_ativo='0' 
                                            WHERE id_rede_tematica=:idRedetematica");
            $sql->bindValue(":idRedetematica", $this->getIdRedeTematica(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    //retorna dados necessario para o log
    public function retornaRedeTematica($pdo){
        try {
            $sql = $pdo->prepare("SELECT * 
                                        FROM fin_rede_tematica 
                                            WHERE id_rede_tematica=:idRedetematica");
            $sql->bindValue(":idRedetematica", $this->getIdRedeTematica(), PDO::PARAM_INT);
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

    //verifica a existência de uma rede tematica
    public function verificaRedeTematica($pdo = null) {
       try {
           $sql = $pdo->prepare("SELECT nm_rede_tematica 
                                    FROM fin_rede_tematica 
                                        WHERE nm_rede_tematica=:nmRedetematica");
           $sql->bindValue(":nmRedetematica", $this->getNmRedeTematica(), PDO::PARAM_STR);
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
    //lista os blocos orçamentários
    public function listaTodosBlocosOrcamentarios($pdo = null){
        try {
            $sql = $pdo->prepare("SELECT id_bloco_orcamentario, nm_bloco_orcamentario
                                        FROM fin_bloco_orcamentario
                                            WHERE st_ativo='1'");
            $sql->execute();
            if ($sql->rowCount() >= 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
}
