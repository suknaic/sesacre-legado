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
            if (!empty($pdo)) {
                $sql = "insert into fin_entrega_itens (id_entrega_confirmacao, id_ordem_itens, qt_itens_entrega, vl_itens_entrega, tp_entrega, dt_entrega)"
                        . " values (:idEntrega, :idOrdemItens, :qt, :vl, :tpEntrega, :dtEntrega)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':idEntrega', $this->getIdEntregaConfirmacao());
                $stmt->bindValue(':idOrdemItens', $this->getIdOrdemItens());
                $stmt->bindValue(':qt', $this->getQtItensEntrega());
                $stmt->bindValue(':vl', $this->getVlItensEntrega());
                $stmt->bindValue(':tpEntrega', $this->getTpEntrega());
                $stmt->bindValue(':dtEntrega', $this->getDhEntrega());
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Erro PDO";
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaValorItenOrdem(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select vl_itens_ordem from fin_ordem_itens as ordemItens where ordemItens.id_ordem_itens = :ordemItens";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordemItens", $this->getIdOrdemItens());
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Nenhum registro encontrado";
                }
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Erro PDO";
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

}
