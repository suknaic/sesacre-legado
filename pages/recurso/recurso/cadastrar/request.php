<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/sistema/Sistema.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'listaSistemas':
        try {
            $sistema = new Sistema();
            echo $sistema->retornaOptionSistemas();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}