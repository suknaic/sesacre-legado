<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/gdof/FinDocumentoFiscalAnotacao.class.php";

class DaoFinDocumentoFiscalAnotacao extends FinDocumentoFiscalAnotacaoTb {

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

    public function lista(PDO $pdo) {
        try {
            if (empty($pdo)) {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
                return false;
            }
            $sql = "select pessoa.nm_pessoa, to_char(anotacao.dh_documento_fiscal_anotacao,'dd/mm/yyyy HH24:MI:SS') as dh_documento_fiscal_anotacao, 
                    anotacao.ds_documento_fiscal_anotacao
                    from fin_documento_fiscal_anotacao as anotacao
                    inner join ses_pessoa as pessoa
                    on pessoa.id_pessoa = anotacao.id_pessoa
                    where anotacao.id_documento_fiscal = :id_documento_fiscal";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":id_documento_fiscal", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
