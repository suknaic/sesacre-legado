<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinTipoDocumentoTb.class.php";

class DaoFinTipoDocumento extends FinTipoDocumentoTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function sucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function retornaTipoDocumento(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }
            $sql = "select * from fin_tipo_documento";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Não foi possível Localizar o Contrato";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
