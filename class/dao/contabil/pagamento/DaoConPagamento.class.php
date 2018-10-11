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
                        . " nr_pagamento, dt_pagamento, vl_pagamento, vl_pagamento_saldo, ds_pagamento) values (:situacao, :status, :liquidacao, :lotacao, :tipoLotacao,"
                        . " :nr_pagamento, :dt_pagamento, :vl_pagamento, :saldo, :ds_pagamento)";
                $stmt = $pdo->prepare($sql);

                $stmt->bindValue(":situacao", $this->getIdPagamentoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(":status", $this->getIdPagamentoStatus(), PDO::PARAM_INT);
                $stmt->bindValue(":liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoLotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":nr_pagamento", $this->getNrPagamento(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_pagamento", $this->getDtPagamento(), PDO::PARAM_STR);
                $stmt->bindValue(":vl_pagamento", $this->getVlPagamento(), PDO::PARAM_STR);
                $stmt->bindValue(":saldo", $this->getVlPagamentoSaldo(), PDO::PARAM_STR);
                $stmt->bindValue(":ds_pagamento", $this->getDsPagamento(), PDO::PARAM_STR);
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

    public function retornaPagamento(PDO $pdo, string $filtros = "") {
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {

                $sql = "select pagamento.id_pagamento, pagamento.nr_pagamento, pedido.nr_pedido, empenho.nr_empenho,
                        string_agg(documento.nr_documento_fiscal, ', ') as documentos_fiscais, pj.nr_cnpj,  
                        pj.nm_fantasia, to_char(pagamento.dt_pagamento,'dd/mm/yyyy') as data_pagamento, 
                        pagamento.vl_pagamento, pagamento.id_pagamento_situacao, pagSit.nm_pagamento_situacao

                        from con_pagamento as pagamento

                        inner join con_pagamento_situacao as pagSit
                        on pagSit.id_pagamento_situacao = pagamento.id_pagamento_situacao

                        inner join con_liquidacao as liquidacao 
                        on liquidacao.id_liquidacao = pagamento.id_liquidacao

                        inner join fin_empenho as empenho 
                        on empenho.id_empenho = liquidacao.id_empenho

                        inner join fin_pedido as pedido
                        on pedido.id_pedido = empenho.id_pedido

                        inner join pla_tipo_gasto tpGasto
                        on tpGasto.id_tipo_gasto = pedido.id_tipo_gasto

                        left join con_pagamento_doc as docPagamento
                        on docPagamento.id_pagamento = pagamento.id_pagamento

                        left join fin_documento_fiscal as documento
                        on documento.id_documento_fiscal = docPagamento.id_documento_fiscal

                        left join fin_fornecedor as fornec 
                        on fornec.id_fornecedor = pedido.id_fornecedor 

                        left join fin_contrato as contrato
                        on contrato.id_contrato = fornec.id_contrato

                        left join ses_pessoa_juridica as pj 
                        on pj.id_pessoa = fornec.id_pessoa 
                        " . $filtros . "
                        group by pagamento.id_pagamento, pagamento.nr_pagamento, pedido.nr_pedido, 
                        empenho.nr_empenho, pj.nr_cnpj,  pj.nm_fantasia, pagamento.dt_pagamento, 
                        pagamento.vl_pagamento, pagamento.id_pagamento_situacao, pagSit.nm_pagamento_situacao ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() >= 1) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Não encontrou Registros";
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

    public function retornaDadosParaVisualizacaoPagamento(PDO $pdo) {
        try {
            $this->sucesso = false;
            if (!empty($pdo)) {
                $sql = "select pagamento.id_pagamento, pagamento.nr_pagamento, pagamento.id_lotacao,
                        pagamento.id_doc_tipo_lotacao, pedido.id_tipo_solicitacao, 
                        to_char(pagamento.dt_pagamento, 'dd/mm/yyyy') as dt_pagamento, 
                        trim(to_char(pagamento.vl_pagamento, '999G999G999D0999')) as vl_pagamento,
                        pedido.id_pedido, pedido.nr_pedido, empenho.id_empenho, liquidacao.id_liquidacao,
                        liquidacao.nr_liquidacao
                        from con_pagamento as pagamento
                        inner join con_liquidacao as liquidacao
                        on liquidacao.id_liquidacao = pagamento.id_liquidacao
                        inner join fin_empenho as empenho
                        on empenho.id_empenho = liquidacao.id_empenho
                        inner join fin_pedido as pedido
                        on pedido.id_pedido = empenho.id_pedido
                        where pagamento.id_pagamento = :pagamento";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pagamento", $this->getIdPagamento(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() >= 1) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Não encontrou Registros";
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
