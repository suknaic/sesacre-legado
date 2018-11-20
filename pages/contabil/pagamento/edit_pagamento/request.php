<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/Liquidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinDocumentoFiscal.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/pagamento/ConPagamento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/pagamento/ConPagamentoDoc.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/pagamento/ConPagamentoHistorico.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/pagamento/ConPagamentoAnotacoes.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'listaAnotacoes':
        try {
            $dados = filter_input(INPUT_GET, 'pagamento', FILTER_DEFAULT);
            $anotacao = new ConPagamentoAnotacoes();
            $anotacao->setIdPagamento($dados);
            echo $anotacao->retornaAnotacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'editarPagamento':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            if (empty($dados['docsLiquidacao'])) {
                $dados['docsLiquidacao'] = array();
            }
            $pagamento = new ConPagamento();
            $pagamento->setIdLiquidacao($dados["idLiquidacao"]);
            $pagamento->setIdLiquidacaoSituacao($dados["idLiquidacaoSituacao"]);
            $pagamento->setIdPagamento($dados["id_pagamento"]);
            $pagamento->setIdEmpenho($dados["idEmpenho"]);
            $pagamento->setIdLotacao($dados["idLotacao"]);
            $pagamento->setIdDocTipoLotacao($dados["idDocTipoLotacao"]);
            $pagamento->setNrPagamento($dados["nrPagamento"]);
            $pagamento->setDtPagamento($dados["dtPagamento"]);
            $pagamento->setVlPagamento($dados["vlPagamento"]);

            if (!empty($dados["docsPagamento"])) {
                $pagamento->setDocsPagamento($dados["docsPagamento"]);
            } else {
                $pagamento->setDocsPagamento(null);
            }
            $pagamento->setDsAnotacao($dados["anotacoes"]);
            $pagamento->setIdPessoa($session->getIdUser());
            echo $pagamento->editarPagamento();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaDocFiscaisPagemento':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $liquidacao = new Liquidacao();
            $liquidacao->setIdLiquidacao($dados);
            echo $liquidacao->retornaOptionsDocsPagamento();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

