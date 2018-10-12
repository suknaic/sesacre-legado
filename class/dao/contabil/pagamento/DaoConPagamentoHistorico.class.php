<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/pagamento/ConPagamentoHistoricoTb.class.php";

class DaoConPagamentoHistorico extends ConPagamentoHistoricoTb {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    public function salvaHistorico(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "insert into con_pagamento_historico (id_pagamento, id_pessoa, id_lotacao, id_doc_tipo_lotacao, id_pagamento_situacao, id_pagamento_status, "
                        . "ds_pagamento_historico) values (:pagamento, :pessoa, :lotacao, :tipoLotacao, :situacao, :status, :dsPagamento)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pagamento", $this->getIdPagamento(), PDO::PARAM_INT);
                $stmt->bindValue(":pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoLotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":situacao", $this->getIdPagamentoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(":status", $this->getIdPagamentoStatus(), PDO::PARAM_INT);
                $stmt->bindValue(":dsPagamento", $this->getDsPagamentoHistorico(), PDO::PARAM_STR);
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
