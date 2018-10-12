<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/pagamento/ConPagamentoAnotacoesTb.class.php";

class DaoPagamentoAnotacoes extends ConPagamentoAnotacoesTb {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    public function salvaAnotacoes(PDO $pdo) {
        try {

            if (!empty($pdo)) {
                $sql = "insert into con_pagamento_anotacao (id_pessoa, id_pagamento, ds_pagamento_anotacao) values (:pessoa, :pagamento, :dsAnotacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":pagamento", $this->getIdPagamento(), PDO::PARAM_INT);
                $stmt->bindValue(":dsAnotacao", $this->getDsPagamentoAnotacao(), PDO::PARAM_STR);
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

    public function retornaAnotacao(PDO $pdo) {
        try {

            if (!empty($pdo)) {
                $sql = "select pessoa.nm_pessoa, to_char(anotacao.dh_pagamento_anotacao,'dd/mm/yyyy HH24:MI:SS') as dh_pagamento_anotacao, 
                        anotacao.ds_pagamento_anotacao
                        from con_pagamento_anotacao as anotacao
                        inner join ses_pessoa as pessoa
                        on pessoa.id_pessoa = anotacao.id_pessoa
                        where anotacao.id_pagamento = :pagamento";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pagamento", $this->getIdPagamento(), PDO::PARAM_INT);
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
