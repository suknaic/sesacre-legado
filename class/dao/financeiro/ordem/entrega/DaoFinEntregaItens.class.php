<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/ordem/FinEntregaItensTb.class.php";

class DaoFinEntregaItens extends FinEntregaItensTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    /**
     * [sucesso e responsavel ]
     * @return [type]
     */
    public function sucesso() {
        return $this->sucesso;
    }

    public function insertentregaItens(PDO $pdo) {
        try {
            if(!empty($pdo)){
                $sql = "";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue($stmt, $sql);
                $stmt->bindValue($stmt, $sql);
                $stmt->bindValue($stmt, $sql);
                $stmt->bindValue($stmt, $sql);
                $stmt->bindValue($stmt, $sql);
                $stmt->execute();
                $this->sucesso = true;
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "Erro PDO";
            }
            
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

}
