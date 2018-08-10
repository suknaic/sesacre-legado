<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinEntregaDocumentoTb.class.php";

class DaoFinEntregaDocumento extends FinEntregaDocumentoTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function sucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function insertEntregaDocumento(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }

            $sql = "insert into fin_entrega_documento (id_documento_fiscal, id_entrega_confirmacao) values (:documento, :entrega)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->bindValue(":entrega", $this->getIdEntregaConfirmacao(), PDO::PARAM_INT);
            $stmt->execute();
            $this->sucesso = true;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
