<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaItensModel.class.pgp.php";
$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'itensCadEntrega':
        try {

            $ordem = filter_input(INPUT_GET, 'ordem', FILTER_DEFAULT);
            $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
            $finEntregaConfirmacaoModel->setIdOrdem($ordem);
            echo json_encode($finEntregaConfirmacaoModel->retornaItensCadEntrega());
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'cadastroItensEntrega':
        try {

            $itens = filter_input(INPUT_POST, 'itens', FILTER_DEFAULT);
            $dados = json_decode($itens);
            $finEntregaItensModel = new FinEntregaItensModel();
            echo $finEntregaItensModel->cadastraEntregaItens($dados);
            return;
            break;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
            break;
        }

    CASE 'ListaItensEntregue':
        try {

            $itens = filter_input(INPUT_GET, 'id_entrega', FILTER_DEFAULT);

            $finEntregaItensModel = new FinEntregaItensModel();
            $finEntregaItensModel->setIdEntregaConfirmacao($itens);
            echo json_encode($finEntregaItensModel->listaSituacaoDaEntrega());
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'excluirItemEntrega':
        try {
            $itens = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finEntregaItensModel = new FinEntregaItensModel();
            $finEntregaItensModel->setIdEntregaItens($itens["idItem"]);
            $finEntregaItensModel->setIdEntregaConfirmacao($itens["idEntrega"]);
            echo $finEntregaItensModel->removeItemEntrega();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

