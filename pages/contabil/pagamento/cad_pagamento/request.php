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

    CASE 'retornaLiquidacao':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $liquidacao = new Liquidacao();
            $liquidacao->setNrLiquidacao($dados);
            echo $liquidacao->pesquisaLiquidacaoParaPagamento(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaContratosPagamento':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finContratoModel = new FinContratoModel();
            echo $finContratoModel->retornaContratoGdof(null, $dados["nr_pedido"]);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaPedidoPagemento':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pedido = new Pedido();
            $pedido->setNrPedido($dados["nr_pedido"]);
            echo $pedido->retornaPedidoGdof(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaEmpenhoPagemento':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pedido = new Pedido();
            $pedido->setNrPedido($dados);
            $finEmpenhoModel = new FinEmpenhoModel();
            $finEmpenhoModel->setIdPedido($dados["id_pedido"]);
            echo $finEmpenhoModel->retornaEmpenhoPagamento(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaLiquidacaoPagemento':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $liquidacao = new Liquidacao();
            $liquidacao->setNrLiquidacao($dados["nr_liquidacao"]);
            echo $liquidacao->retornaLiquidacaoParaPagamento(null);
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

    CASE 'exiberDocFiscaisPagemento':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $liquidacao = new Liquidacao();
            $liquidacao->setIdLiquidacao($dados['id_liquidacao']);
            $liquidacao->setIdEmpenho($dados['id_empenho']);
            echo $liquidacao->retornaDocsPagamentoDisponiveis();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaTipoRemetenteERemetente':
        try {
            $vincTramitacao = new VincularTramitacao();
            $vincTramitacao->setIdPessoa($session->getIdUser());
            echo $vincTramitacao->listaLotacaoTipoPorUsuarioPagamento();
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
            $pagamento->setIdLiquidacaoSituacao($dados["idLiquidacaoSituacao"]);
            $pagamento->setIdEmpenho($dados["idEmpenho"]);
            $pagamento->setIdLotacao($dados["idLotacao"]);
            $pagamento->setIdDocTipoLotacao($dados["idDocTipoLotacao"]);
            $pagamento->setNrPagamento($dados["nrPagamento"]);
            $pagamento->setDtPagamento($dados["dtPagamento"]);
            $pagamento->setVlPagamento($dados["vlPagamento"]);
            $pagamento->setVlPagamentoSaldo($dados["saldoLiquidacao"]);

            if (!empty($dados["docsPagamento"])) {
                $pagamento->setDocsPagamento($dados["docsPagamento"]);
            } else {
                $pagamento->setDocsPagamento(null);
            }

            $pagamento->setDsAnotacao($dados["anotacoes"]);
            $pagamento->setIdPessoa($session->getIdUser());
            $pagamento->setIdPedido($dados["id_pedido"]);
            echo $pagamento->salvaPagamento();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'buscaLiquidacao':
        try {
            $dados = filter_input(INPUT_GET, 'liquidacao', FILTER_DEFAULT);
            $liquidacao = new Liquidacao();
            $liquidacao->setNrLiquidacao($dados);
            echo $liquidacao->buscaLiquidacaoParaPagamento();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

