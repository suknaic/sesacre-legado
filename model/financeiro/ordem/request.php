<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemItensModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/CentralResponsavel.class.php";
$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'retornaPedido':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $pedido = new Pedido();
            
            $pedido->setNrPedido($dados);
            echo $pedido->retornaDadosPedidoOrdem($session);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaItensPreOrdem':
        try {
            $ordem = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $finOrdemModel = new FinOrdemModel();
            $finOrdemModel->setIdPedido($ordem);
            echo $finOrdemModel->retornaItensParaCadOrdem();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaLotacao':
        try {
            $lotacao = new Lotacao();
            echo  $lotacao->retornaOptionLotacao(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'cadastroOrdem':
        try {
            $ordem = filter_input(INPUT_POST, 'itens', FILTER_DEFAULT);
            $dados = json_decode($ordem);
            $finOrdemModel = new FinOrdemModel();
            $finOrdemModel->setIdPessoa($session->getIdUser());
            echo $finOrdemModel->cadastrarOrdem($dados);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

