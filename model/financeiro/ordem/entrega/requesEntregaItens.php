<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaItensModel.class.pgp.php";
$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'itensCadEntrega':
        try {

            $protocolo = filter_input(INPUT_GET, 'protocolo', FILTER_DEFAULT);
            $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
            $finEntregaConfirmacaoModel->setIdProtocolo($protocolo);
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
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

