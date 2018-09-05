<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoPesquisa.class.php";

$session = new Session('ajax');


switch ($_REQUEST['acao']) {

    CASE 'retornaOptionsSituacaoLiquidacao':
        try {
            
            $liquidacao = new LiquidacaoPesquisa();
            echo $liquidacao->retornaOptionsSituacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'retornaLiquidacoes':
        try {
            $liquidacao = new LiquidacaoPesquisa();
            echo $liquidacao->retornaLiquidacoes();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

}