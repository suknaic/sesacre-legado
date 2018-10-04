<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/FinFornecedorModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'pesquisaPedido':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pedido = new Pedido();
            $pedido->setNrPedido($dados["numero"]);
            $pedido->setIdLotacao($dados["central"]);
            $pedido->setAno($dados["ano"]);
            $pedido->setIdFornecedor($dados["contratado"]);
            $pedido->setIdTipoGasto($dados["tipoGasto"]);
            $pedido->setIdUsuario($session->getIdUser());
            echo $pedido->retornaPesquisaPedido();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}
?>
