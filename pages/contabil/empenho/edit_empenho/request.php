<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    CASE 'atualizaEmpenho':
        try {
        
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}