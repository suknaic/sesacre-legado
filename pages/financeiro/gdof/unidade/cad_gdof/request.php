<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
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

    CASE 'retornaContratosGdof':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $finContratoModel = new FinContratoModel();
            echo $finContratoModel->retornaContratoGdof(null, $dados);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
        CASE 'retornaPedidoGdof':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $pedido = new Pedido();
            $pedido->setNrPedido($dados);
            echo $pedido->retornaPedidoGdof(null, $dados);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }    
}

