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

    CASE 'cadastrarPagamento':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            if (empty($dados['docsLiquidacao'])) {
                $dados['docsLiquidacao'] = array();
            }

            $pagamento = new ConPagamento();
            $pagamento->setIdLiquidacao($dados["idLiquidacao"]);
            $pagamento->setIdLotacao($dados["idLotacao"]);
            $pagamento->setIdDocTipoLotacao($dados["idDocTipoLotacao"]);
            $pagamento->setNrPagamento($dados["nrPagamento"]);
            $pagamento->setDtPagamento($dados["dtPagamento"]);
            $pagamento->setVlPagamento($dados["vlPagamento"]);
            $pagamento->setVlPagamentoSaldo($dados["saldoLiquidacao"]);
            $pagamento->setDocsPagamento($dados["docsPagamento"]);
            $pagamento->setDsAnotacao($dados["anotacoes"]);
            $pagamento->setIdPessoa($session->getIdUser());
            echo $pagamento->salvaPagamento();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaDocFiscaisPagemento':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $liquidacao = new Liquidacao();
            $liquidacao->setIdLiquidacao($dados['id_liquidacao']);
            $liquidacao->setIdEmpenho($dados['id_empenho']);
            echo $liquidacao->retornaOptionsDocsPagamento();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

