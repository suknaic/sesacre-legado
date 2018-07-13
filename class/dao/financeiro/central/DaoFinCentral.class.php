<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/central/FinCentralTb.class.php";

class DaoFinCentral extends FinCentralTb {

    private $sucesso = true;
    private $msgRetorno = null;

    public function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function Sucesso() {
        return $this->sucesso;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function retornaCentrais($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select central.id_central_demanda, l.id_lotacao, l.nm_lotacao
				from fin_central_demanda as central
				inner join ses_lotacao as l
				on l.id_lotacao = central.id_lotacao
                                ORDER BY l.nm_lotacao";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }
    
    function insert(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "insert into fin_central_demanda(id_lotacao) values (:id_lotacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
                
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
            $this->sucesso = false;
        }
    }
    
    function delete(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare("DELETE FROM fin_central_demanda WHERE id_central_demanda = :idCentralDemanda");
                $stmt->bindValue(":idCentralDemanda", $this->getIdCentralDemanda(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
            
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
            $this->sucesso = false;
        }
    }

}
