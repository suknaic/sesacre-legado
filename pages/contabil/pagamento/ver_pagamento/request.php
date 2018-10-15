<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/pagamento/ConPagamentoAnotacoes.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'listaAnotacoes':
        try {
            $dados = filter_input(INPUT_GET, 'pagamento', FILTER_DEFAULT);
            $anotacao = new ConPagamentoAnotacoes();
            $anotacao->setIdPagamento($dados);
            echo $anotacao->retornaAnotacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}