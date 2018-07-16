<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinProtocoloModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaItensModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemItensModel.class.php";
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
            $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
            echo $finEntregaConfirmacaoModel->salvaEntregaConfirmacao($dados);
            return;
            break;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
            break;
        }

    CASE 'ListaItensEntregue':
        try {

            $ordem = filter_input(INPUT_GET, 'id_ordem', FILTER_DEFAULT);
            $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
            $finEntregaConfirmacaoModel->setIdOrdem($ordem);
            echo json_encode($finEntregaConfirmacaoModel->retornaEntregaConfirmacao());
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'excluirItemEntrega':
        try {
            $itens = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finEntregaItensModel = new FinEntregaItensModel();
            $finEntregaItensModel->setIdEntregaItens($itens["idItem"]);
            $finEntregaItensModel->setIdEntregaConfirmacao($itens["idEntrega"]);
            $finEntregaItensModel->setIdProtocolo($itens["idProtocolo"]);
            echo $finEntregaItensModel->removeItemEntrega();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

