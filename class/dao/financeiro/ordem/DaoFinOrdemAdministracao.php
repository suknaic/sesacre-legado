<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/ordem/FinOrdemAdministracaoTb.class.php";

class DaoFinOrdemAdministracao extends FinOrdemAdministracaoTb {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    public function reativarOrdem(PDO $pdo) {
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {
                $sql = "insert into fin_ordem_administracao (id_ordem, id_protocolo, id_solicitante, id_lotacao_solicitante, tp_administracao)
                    values (:ordem, :protocolo, :id_pessoa, :lotacao, :tp)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pessoa", $this->getIdSolicitante(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacaoSolicitante(), PDO::PARAM_INT);
                $stmt->bindValue(":tp", $this->getTpAdministracao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
        }
    }

}
