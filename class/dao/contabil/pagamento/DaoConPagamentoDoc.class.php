<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/pagamento/ConPagamentoDocTb.class.php";

class DaoConPagamentoDoc extends ConPagamentoDocTb {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    public function salvaDocPagamento(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "INSERT INTO con_pagamento_doc (id_pagamento, id_documento_fiscal, vl_pagamento_doc, vl_pagamento_doc_saldo) "
                        . "values (:pagamento, :documento, :valor, :valorSaldo)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pagamento", $this->getIdPagamento(), PDO::PARAM_INT);
                $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
                $stmt->bindValue(":valor", $this->getVlDocumentoFiscal(), PDO::PARAM_STR);
                $stmt->bindValue(":valorSaldo", $this->getVlPagamentoDocSaldo(), PDO::PARAM_STR);
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
