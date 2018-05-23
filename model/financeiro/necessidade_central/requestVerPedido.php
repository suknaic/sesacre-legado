<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/autorizacoes/FinAutorizacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    case 'cancelarPedido':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finAutorizacao = new FinAutorizacao();
            $finAutorizacao->setIdPessoa($session->getIdUser());
            $finAutorizacao->setIdPedido($dados['pedido']);
            $finAutorizacao->setDsAutorizacao($dados['obsAutoriza']);
            echo $finAutorizacao->cancelarAutorizacaoPedido();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}
?>
