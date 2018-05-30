<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";

$session = new Session('ajax');


switch ($_REQUEST['acao']) {

    CASE 'retornaCentrais':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $finCentralModel = new FinCentralModel();
            echo $finCentralModel->retornaOptionsCentrais();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }


    CASE 'pesquisaOrdem':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finOrdemModel = new FinOrdemModel();
            $finOrdemModel->setNrPedido($dados["numero"]);
            $finOrdemModel->setCentral($dados["central"]);
            $finOrdemModel->setAno($dados["ano"]);
            echo $finOrdemModel->retornaTrPesquisaOrdem();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}