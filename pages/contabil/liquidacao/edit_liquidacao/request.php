<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/Liquidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoDoc.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoHistorico.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    CASE 'atualizaLiquidacao':
        try {
            $dados = filter_input(INPUT_POST,'dados',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $liquidacao = new Liquidacao();
            $liquidacao->setIdLiquidacao($dados['idLiquidacao'])
                       ->setUsuario($session->getIdUser())
                       ->setIdLotacao(128)
                       ->setIdDocTipoLotacao(2)
                       ->setNrLiquidacao($dados['nrLiquidacao'])
                       ->setVlLiquidacao($dados['vlLiquidacao'])
                       ->setDtLiquidacao($dados['dtLiquidacao'])
                       ->setDsLiquidacao($dados['obsLiquidacao'])
                       ->setDocumentos($dados['docsLiquidacao']);
            echo $liquidacao->alterarLiquidacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}