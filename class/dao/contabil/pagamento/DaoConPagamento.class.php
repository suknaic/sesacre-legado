<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/pagamento/ConPagamentoTb.class.php";

class DaoConPagamento extends ConPagamentoTb {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    public function salvaPagamento(PDO $pdo) {
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {

                $sql = "INSERT INTO con_pagamento (id_pagamento_situacao, id_pagamento_status, id_liquidacao, id_lotacao, id_doc_tipo_lotacao, "
                        . " nr_pagamento, dt_pagamento, vl_pagamento, vl_pagamento_saldo, ds_pagamento) values (:situacao, :status, :liquidacao, :lotacao, :tipoLotacao,"
                        . " :nr_pagamento, :dt_pagamento, :vl_pagamento, :saldo, :ds_pagamento)";
                $stmt = $pdo->prepare($sql);

                $stmt->bindValue(":situacao", $this->getIdPagamentoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(":status", $this->getIdPagamentoStatus(), PDO::PARAM_INT);
                $stmt->bindValue(":liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoLotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":nr_pagamento", $this->getNrPagamento(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_pagamento", $this->getDtPagamento(), PDO::PARAM_STR);
                $stmt->bindValue(":vl_pagamento", $this->getVlPagamento(), PDO::PARAM_STR);
                $stmt->bindValue(":saldo", $this->getVlPagamentoSaldo(), PDO::PARAM_STR);
                $stmt->bindValue(":ds_pagamento", $this->getDsPagamento(), PDO::PARAM_STR);
                $stmt->execute();

                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Erro PDO";
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaPagamento(PDO $pdo) {
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {

                $sql = "INSERT INTO con_pagamento (id_pagamento_situacao, id_pagamento_status, id_liquidacao, id_lotacao, id_doc_tipo_lotacao, "
                        . " nr_pagamento, dt_pagamento, vl_pagamento, vl_pagamento_saldo, ds_pagamento) values (:situacao, :status, :liquidacao, :lotacao, :tipoLotacao,"
                        . " :nr_pagamento, :dt_pagamento, :vl_pagamento, :saldo, :ds_pagamento)";
                $stmt = $pdo->prepare($sql);

                $stmt->bindValue(":situacao", $this->getIdPagamentoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(":status", $this->getIdPagamentoStatus(), PDO::PARAM_INT);
                $stmt->bindValue(":liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoLotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":nr_pagamento", $this->getNrPagamento(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_pagamento", $this->getDtPagamento(), PDO::PARAM_STR);
                $stmt->bindValue(":vl_pagamento", $this->getVlPagamento(), PDO::PARAM_STR);
                $stmt->bindValue(":saldo", $this->getVlPagamentoSaldo(), PDO::PARAM_STR);
                $stmt->bindValue(":ds_pagamento", $this->getDsPagamento(), PDO::PARAM_STR);
                $stmt->execute();

                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Erro PDO";
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
