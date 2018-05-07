<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Despesa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto_despesa/PlaTipoGastoDespesaElemento.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'retornaTipoGasto':
        try {
            $tipoGasto = new TipoGasto();
            echo "<option value = '0'>Selecione um tipo de gasto</option>";
            echo $tipoGasto->retornaOption(0, null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaDespesa':
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $despesa = new Despesa();
            echo "<option value = '0'>Selecione um tipo de gasto</option>";
            echo $despesa->retornaOptionDespesaElemento(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'cadastrarTipoDespesa':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $platipoGastoDespesaElemento = new PlatipoGastoDespesaElemento();
            $platipoGastoDespesaElemento->setIdTipoGasto($dados['tipoGasto']);
            $platipoGastoDespesaElemento->setIdDespesaElemento($dados['despesa']);
            echo $platipoGastoDespesaElemento->salvaTipoGastoDespesaElemento();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'listaTipoDeGastoDespesa':
        try {
            $platipoGastoDespesaElemento = new PlatipoGastoDespesaElemento();
            echo $platipoGastoDespesaElemento->trTipoGastoDespesaElemento();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}
?>
