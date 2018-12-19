<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemAdministracaoPesquisaModel.class.php";
$session = new Session('ajax');


switch ($_REQUEST['acao']) {

    CASE 'retornaOptionsSituacaoLiquidacao':
        try {

            $liquidacao = new LiquidacaoPesquisa();
            echo $liquidacao->retornaOptionsSituacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaOrdemAdministracao':
        $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finOrdemAdministracaoPesquisaModel = new FinOrdemAdministracaoPesquisaModel();
            $finOrdemAdministracaoPesquisaModel->setNrOrdem($dados["nr_ordem"]);
            $finOrdemAdministracaoPesquisaModel->setAaOrdem($dados["exercicio"]);
            $finOrdemAdministracaoPesquisaModel->setFornecedor($dados["fornecedor"]);
            $finOrdemAdministracaoPesquisaModel->setNrContrato($dados["contrato"]);
            $finOrdemAdministracaoPesquisaModel->setNrPedido($dados["pedido"]);
            $finOrdemAdministracaoPesquisaModel->setNrEmpenho($dados["empenho"]);
            $finOrdemAdministracaoPesquisaModel->setCentral($dados["central"]);
            $finOrdemAdministracaoPesquisaModel->setIdTipoGasto($dados["tpGasto"]);
            $finOrdemAdministracaoPesquisaModel->setSituacao($dados["situacao"]);
            echo $finOrdemAdministracaoPesquisaModel->retornaPesquisaOrdemAdministracao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'cancelarPagamento':
        $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

        try {
            $pagamento = new ConPagamento();
            $pagamento->setIdPagamento($dados['id']);
            $pagamento->setIdPessoa($session->getIdUser());
            $pagamento->setDsAnotacao($dados['justificativa']);
            echo $pagamento->cancelarPagamento();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}