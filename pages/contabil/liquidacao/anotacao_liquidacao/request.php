<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoAnotacao.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'salvaAnotacao':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $liquidacaoAnotacao = new LiquidacaoAnotacao();
            $liquidacaoAnotacao->setIdPessoa($session->getIdUser());
            $liquidacaoAnotacao->setIdLiquidacao($dados["liquidacao"]);
            $liquidacaoAnotacao->setDsLiquidacaoAnotacao($dados["anotacao"]);
            echo $liquidacaoAnotacao->salvarComRetorno();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'listaAnotacoes':
        try {
            $dados = filter_input(INPUT_POST, 'liquidacao', FILTER_DEFAULT);
            $liquidacaoAnotacao = new LiquidacaoAnotacao();
            $liquidacaoAnotacao->setIdLiquidacao($dados);
            echo $liquidacaoAnotacao->listaAnotacoes();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

