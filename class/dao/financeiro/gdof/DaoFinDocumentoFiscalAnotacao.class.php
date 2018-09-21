<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinDocumentoFiscalAnotacao.class.php";

class DaoFinDocumentoFiscalAnotacao extends FinDocumentoFiscalAnotacao {
    private $sucesso = false;
    private $msgRetorno = null;

    function sucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function insere(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }
            $sql = "insert into fin_documento_fiscal_anotacao (id_pessoa, id_documento_fiscal, ds_documento_fiscal_anotacao) values (:id_pessoa, :id_documento_fiscal, :ds_documento_fiscal_anotacao)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $stmt->bindValue(":id_documento_fiscal", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->bindValue(":ds_documento_fiscal_anotacao", $this->getDsDocumentoFiscalAnotacao(), PDO::PARAM_STR);
            $stmt->execute();
            $this->sucesso = true;
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
}
