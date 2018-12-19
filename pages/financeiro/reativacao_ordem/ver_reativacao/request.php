<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemAdministracaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemAdministracaoAnotacaoModel.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

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


    CASE 'autorizaReativacao':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finOrdemAdministracaoModel = new FinOrdemAdministracaoModel();
            $finOrdemAdministracaoModel->setIdOrdem($dados["id_ordem"]);
            $finOrdemAdministracaoModel->setIdOrdemAdministracao($dados["id_ordem_administracao"]);
            $finOrdemAdministracaoModel->setIdAutorizado($session->getIdUser());
            $finOrdemAdministracaoModel->setIdLotacaoAutorizado($dados["id_remetente"]);
            echo $finOrdemAdministracaoModel->autorizaReativacaoOrdem();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

