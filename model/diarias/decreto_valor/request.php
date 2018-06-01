<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/DecretoValor.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    case 'returnDecretoOption':
        try {
            $prog = new DecretoValor();
            echo '<option value="0" selected>Selecione um Decreto</option>';
            echo $prog->optionsDecreto();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'returnClasseOption':
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $prog = new DecretoValor();
            echo $prog->optionsClasse((int)$filtro);
            return;
            break;
            
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaTable':
        try {
            $prog = new DecretoValor();
            echo $prog->listaTodos();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

}
