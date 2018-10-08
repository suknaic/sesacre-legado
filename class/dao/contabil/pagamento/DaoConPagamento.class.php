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
                        . " nr_pagamento, dt_pagamento, vl_pagamento, ds_pagamento) values (:situacao, :status, :liquidacao, :lotacao, :tipoLotacao,"
                        . " :nr_pagamento, :dt_pagamento, :vl_paamento, :ds_pagamento)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":situacao", $this->getId_pagamento_situacao(), PDO::PARAM_INT);
                $stmt->bindValue(":status", $this->getId_pagamento_status(), PDO::PARAM_INT);
                $stmt->bindValue(":liquidacao", $this->getId_liquidacao(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getId_lotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoLotacao", $this->getId_doc_tipo_lotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":nr_pagamento", $this->getNr_pagamento(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_pagamento", $this->getDt_pagamento(), PDO::PARAM_STR);
                $stmt->bindValue(":vl_pagamento", $this->getVl_pagamento(), PDO::PARAM_STR);
                $stmt->bindValue(":ds_pagamento", $this->getDs_pagamento(), PDO::PARAM_STR);
                $stmt->execute();
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Erro PDO";
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

}
