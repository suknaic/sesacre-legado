<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/orcamento/liberacaoCentral/FinCentralLiberacaoTransTb.class.php";

class DaoFinCentralLiberacaoTrans extends FinCentralLiberacaoTransTb {

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

    public function salvaFinLiberacaoTrans(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "insert into fin_central_liberacao_trans (id_central_liberacao, id_qdd_valor, vl_central_liberacao_trans, tp_central_liberacao_trans) 
                        values (:liberacao, :qddValor, :valor, :tipo)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":liberacao", $this->getIdCentralLiberacao(), PDO::PARAM_INT);
                $stmt->bindValue(":qddValor", $this->getIdQddValor(), PDO::PARAM_INT);
                $stmt->bindValue(":valor", $this->getVlCentralLiberacaoTrans(), PDO::PARAM_INT);
                $stmt->bindValue(":tipo", $this->getTpCentralLiberacaoTrans(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

}
