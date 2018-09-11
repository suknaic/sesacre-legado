<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";


$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    CASE 'salvarVincLiquidacao':
        try {
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $vincTramitacao = new VincularTramitacao();
            $vincTramitacao->setIdPessoa($filtro['idPessoa'])
                           ->setIdTramitacao($filtro['idTramitacao'])
                           ->setIdLotacao($filtro['idLotacao'])
                           ->setIdDocTipoLotacao($filtro['idDocTipoLotacao']);
            echo $vincTramitacao->cadastrar();
            return;
            break;
            
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
    CASE 'removerVincLiquidacao':
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
            
            $vincTramitacao = new VincularTramitacao();
            $vincTramitacao->setIdVincularTramitacao($filtro['id']);
            echo $vincTramitacao->excluir();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaVinculos':
        try {
            $vincTramitacao = new VincularTramitacao();
            echo $vincTramitacao->listaTodos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

}