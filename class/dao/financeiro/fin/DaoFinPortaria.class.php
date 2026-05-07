<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinPortaria.class.php";

class DaoFinPortaria extends FinPortaria{
         
    private $sucesso = null;
    private $msgRetorno = null;    
    
    function getMsgRetorno() {
        return $this->msgRetorno;
    }   
 
    function Sucesso(){
        return $this->sucesso;
    }
    
    /**
     * Retorna todas as Portarias
     * @param type $pdo
     * @return boolean
     */
    function retornaTodasPortarias($pdo){
        
        $this->sucesso = false;
        
        $sql = " SELECT "                
                . " P.id_portaria, P.nm_portaria"
                . " , RT.nm_rede_tematica"
                . " FROM fin_portaria P"
                . " INNER JOIN fin_rede_tematica RT ON RT.id_rede_tematica = P.id_rede_tematica"                
                . " ORDER BY RT.nm_rede_tematica, P.nm_portaria";                
        try {
            $sth = $pdo->prepare($sql);                    
            $sth->execute();           
            if ($sth->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);                
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "Nenhum Registro";                
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();            
        }
    }
    //cadastra portaria
    public function cadastrarPortaria($pdo){
        try {
            $sql = $pdo->prepare("INSERT
                                        INTO fin_portaria(id_rede_tematica, nm_portaria, dt_portaria, vl_total)
                                            VALUES (:idRede, :nmPortaria, :data, :valorTotal)");
            $sql->bindValue(":idRede", $this->getIdRedeTematica(), PDO::PARAM_INT);
            $sql->bindValue(":nmPortaria", $this->getNmPortaria() === '' ? null : $this->getNmPortaria(), PDO::PARAM_STR);
            $sql->bindValue(":data", $this->getDtPortaria(), PDO::PARAM_STR);
            $sql->bindValue(":valorTotal", $this->getVlTotal(), PDO::PARAM_STR);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    //lista portaria
    public function listarPortaria($pdo, $codigo){
        try {
            $sql = $pdo->prepare("SELECT portaria.id_portaria, portaria.nm_portaria, portaria.dt_portaria, portaria.vl_total, rede.id_rede_tematica, rede.nm_rede_tematica
                                        FROM fin_portaria AS portaria
                                        INNER JOIN fin_rede_tematica AS rede ON rede.id_rede_tematica=portaria.id_rede_tematica
                                             WHERE $codigo
                                                  AND portaria.st_portaria='1'");
            $sql->execute();
            if($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $this->sucesso = FALSE;
                $this->msgRetorno = "Nenhuma PORTARIA encontrada.";
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    //edita portaria
    public function editarPortaria($pdo){
        try {
            $sql = $pdo->prepare("UPDATE fin_portaria 
                                        SET id_rede_tematica=:idRedeTematica, nm_portaria=:nmPortaria, dt_portaria=:dataPortaria, vl_total=:valor
                                            WHERE id_portaria=:idPortaria");
            $sql->bindValue("idRedeTematica", $this->getIdRedeTematica(), PDO::PARAM_INT);
            $sql->bindValue(":nmPortaria", $this->getNmPortaria(), PDO::PARAM_STR);
            $sql->bindValue(":dataPortaria", $this->getDtPortaria(), PDO::PARAM_STR);
            $sql->bindValue(":valor", $this->getVlTotal(), PDO::PARAM_STR);
            $sql->bindValue(":idPortaria", $this->getIdPortaria(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    //desativa portaria
    public function desativaPortaria($pdo){
        try {
            $sql = $pdo->prepare("UPDATE fin_portaria
                                        SET st_portaria='0'
                                           WHERE id_portaria=:idPortaria");
            $sql->bindValue(":idPortaria", $this->getIdPortaria(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    //carrega todos os dados da portaria para edição
    public function carregaDadosPortaria($pdo) {
        try {
            $sql = $pdo->prepare("SELECT portaria.id_portaria, portaria.nm_portaria, portaria.dt_portaria, portaria.vl_total, rede.id_rede_tematica, rede.nm_rede_tematica
                                        FROM fin_portaria AS portaria
                                        INNER JOIN fin_rede_tematica AS rede ON rede.id_rede_tematica=portaria.id_rede_tematica
                                             WHERE portaria.id_portaria=:idPortaria");
            $sql->bindValue(':idPortaria', $this->getIdPortaria(), PDO::PARAM_INT);
            $sql->execute();
            if($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    //lista as redes temáticas
    public function listarRedesTematicas($pdo){
        try {
            $sql = $pdo->prepare("SELECT id_rede_tematica, nm_rede_tematica
                                        FROM fin_rede_tematica 
                                            WHERE st_ativo='1'
                                                  ORDER BY nm_rede_tematica");
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            }else{
                $this->sucesso = FALSE;
                $this->msgRetorno = "Nenhuma REDE TEMÁTICA encontrada.";
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage(); 
        }
    }
    //verifica a existencia da portaria
    public function verificaPortaria($pdo){
        try {
            $sql = $pdo->prepare("SELECT nm_portaria 
                                        FROM fin_portaria
                                            WHERE nm_portaria=:nmPortaria");
            $sql->bindValue(":nmPortaria", $this->getNmPortaria(), PDO::PARAM_STR);
            $sql->execute();
            if($sql->rowCount() > 0){
                $this->sucesso = TRUE;
            }else{
                $this->sucesso = FALSE;
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    //retorna a portaria para o log
    public function retornaPortaria($pdo){
        try {
            $sql = $pdo->prepare("SELECT *
                                        FROM fin_portaria
                                            WHERE id_portaria=:idPortaria");
            $sql->bindValue(':idPortaria', $this->getIdPortaria(), PDO::PARAM_INT);
            $sql->execute();
            if($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }
}

