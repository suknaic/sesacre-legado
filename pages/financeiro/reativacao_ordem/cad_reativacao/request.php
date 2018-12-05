<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'pesquisaOrdemAdministracao':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $ordem = new FinOrdemModel();
            $ordem->setNrOrdem($dados);
            echo $ordem->retornaPesquisaOrdemAdministracao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaContratos':
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

    CASE 'retornaPedido':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pedido = new Pedido();
            $pedido->setNrPedido($dados["nr_pedido"]);
            echo $pedido->retornaPedidoGdof(null, $dados);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaEmpenho':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pedido = new Pedido();
            $pedido->setNrPedido($dados);
            $finEmpenhoModel = new FinEmpenhoModel();
            $finEmpenhoModel->setIdPedido($dados["id_pedido"]);
            echo $finEmpenhoModel->retornaEmpenhoGdof(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaOrdem':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $finOrdemModel = new FinOrdemModel();
            $finOrdemModel->setNrOrdem($dados);
            echo $finOrdemModel->retornaTabelaOrdemAdministracao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'retornaItensEntrega':
        try {
            $dados = filter_input(INPUT_GET, 'ordem', FILTER_DEFAULT);
            $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
            $finEntregaConfirmacaoModel->setIdOrdem($dados);
            echo json_encode($finEntregaConfirmacaoModel->retornaItensCadEntrega());
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

