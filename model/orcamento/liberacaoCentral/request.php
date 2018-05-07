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


    CASE 'retornaProjetoAtividade':
        try {
            $dados = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);
            $qddValor = new QddValor();
            if (!empty($dados)) {
                $qddValor->setAno($dados);
                echo $qddValor->optionsProgetoAtividadePorAnoQDD();
            }
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaFonte':
        try {
            $fonte = new Fonte();
            echo $fonte->retornaOptionSelect(NULL);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaCentrais':
        try {
            $centrais = new FinCentralModel();
            echo $centrais->retornaOptionsCentrais();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaTipoGasto':
        try {
            $tipoGasto = new TipoGasto();
            echo "<option value = '0'>Selecione um tipo de gasto</option>";
            echo $tipoGasto->retornaOption(null, null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaElemento':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $tipoGasto = new TipoGasto();
            echo "<option value = '0'>Selecione um elemento</option>";
            echo $tipoGasto->retornaTipoGastoElemento($dados['contrato'], null, null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'salvar':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);
            $finCentralLiberacaoModel = new FinCentralLiberacaoModel();
            echo $finCentralLiberacaoModel->salvaLiberacao($dados, $ano);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'buscaLiberacao':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $finCentralLiberacaoModel = new FinCentralLiberacaoModel();
            echo $finCentralLiberacaoModel->trPesquisaLiberacao($dados);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'reducao':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);

            $finCentralLiberacaoModel = new FinCentralLiberacaoModel();
            echo $finCentralLiberacaoModel->salvaReducao($dados, $ano);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'buscaReducao':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $finCentralLiberacaoModel = new FinCentralLiberacaoModel();
            echo $finCentralLiberacaoModel->trPesquisaReducao($dados);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}