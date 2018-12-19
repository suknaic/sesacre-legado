<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/ordem/FinAdministracaoAnotacaoTb.class.php";

class DaoFinOrdemAdministracaoAnotacao extends FinAdministracaoAnotacaoTb {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    public function cadastrarAnotacao(PDO $pdo) {
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {
                $sql = "insert into fin_ordem_administracao_anotacao (id_ordem_administracao, ds_ordem_administracao_anotacao, id_pessoa) values (:ordemAdm, :texto, :pessoa)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordemAdm", $this->getIdOrdemAdministracao(), PDO::PARAM_INT);
                $stmt->bindValue(":texto", $this->getDsOrdemAdministracaoAnotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaAnotacao(PDO $pdo) {
        try {

            if (!empty($pdo)) {
                $sql = "select pessoa.nm_pessoa, to_char(anotacao.dh_ordem_administracao_anotacao,'dd/mm/yyyy HH24:MI:SS') as dh_ordem_administracao_anotacao, 
                        anotacao.ds_ordem_administracao_anotacao
                        from fin_ordem_administracao_anotacao as anotacao
                        inner join ses_pessoa as pessoa
                        on pessoa.id_pessoa = anotacao.id_pessoa
                        where anotacao.id_ordem_administracao = :ordemAdm";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordemAdm", $this->getIdOrdemAdministracao(), PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
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
