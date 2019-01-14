<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/recurso/GrupoRecurso.class.php";

$session = new Session('ajax');
//$session->recurso();


switch ($_REQUEST['acao']) {

    CASE 'listaGrupos':
        try {      
            $grupoRecurso = new GrupoRecurso();
            echo $grupoRecurso->retornaOptionGrupoRecurso();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
    CASE 'cadastrarGrupo':
        try {
            $dados = filter_input(INPUT_POST, 'dados',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY); 
            $grupoRecurso = new GrupoRecurso();
            $grupoRecurso->setNmGrupoRecurso($dados['nmGrupoRecurso']);
            echo $grupoRecurso->cadastrarGrupoRecurso($session);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}