<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoPesquisa.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/Liquidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoDoc.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoHistorico.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinDocumentoFiscal.class.php";

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
        
    CASE 'cancelarLiquidacao':
        $dados = filter_input(INPUT_POST,'dados',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        
        try {
            $liquidacao = new Liquidacao();
            $liquidacao->setIdLiquidacao($dados['id'])
                       ->setUsuario($session->getIdUser())
                       ->setMotivoCancelamento($dados['justificativa']);
            echo $liquidacao->cancelarLiquidacao();
            return;
            break;
            
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }


}