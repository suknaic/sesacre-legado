<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/liberacaoCentral/FinCentralLiberacaoTransModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Fonte.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/liberacaoCentral/FinCentralLiberacaoModel.class.php";

$session = new Session();

switch ($_REQUEST['acao']) {

    CASE 'listaLiberacaoParaValidar':
        try {
            $finCentralLiberacaoModel = new FinCentralLiberacaoModel();
            echo $finCentralLiberacaoModel->trParaValidarLiberacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'validar':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finCentralLiberacaoModel = new FinCentralLiberacaoModel();
            echo  $finCentralLiberacaoModel->validaLiberacao($dados);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}