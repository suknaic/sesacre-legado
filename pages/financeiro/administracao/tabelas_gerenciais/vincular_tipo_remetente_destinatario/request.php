<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocLotacao.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    CASE 'listaDocLotacao':
        try {
            $prog = new DocLotacao();
            
            echo $prog->listaTodos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'cadastrarDocLotacao':
        
        try {
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);     
            
            $prog = new DocLotacao();            
            $prog->setIdDocTipoLotacao((int)$filtro['idTpLot'])
                 ->setIdLotacao((int)$filtro['idLot']);
            
            echo $prog->cadastrar();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}