<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/ordem/FinEntregaConfirmacaoTb.class.php";

class DaoFinEntregaConfirmacao extends FinEntregaConfirmacaoTb {

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

    public function salvaEntregaConfirmacao(PDO $pdo) {
        try {
            if ($pdo != null) {

                $sql = "insert into fin_entrega_confirmacao(id_ordem, nr_entrega_confirmacao, dt_entrega, nr_qtd_entregas) 
                        values(:ordem, :nrEntrega, :dtEntrega, :qtdEntrega)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->bindValue(":nrEntrega", $this->getNrEntregaConfirmacao(), PDO::PARAM_INT);
                $stmt->bindValue(":dtEntrega", $this->getDtEntrega(), PDO::PARAM_STR);
                $stmt->bindValue(":qtdEntrega", $this->getNrQtdEntrega(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

}
