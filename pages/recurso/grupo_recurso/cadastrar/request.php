<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/recurso/Recurso.class.php";

$session = new Session('ajax');
//$session->recurso();


switch ($_REQUEST['acao']) {

    CASE 'listaGrupos':
        try {      
//            $recurso = new Recurso();
//            echo $recurso->retornaOptionsRecursos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
//    CASE 'cadastrarGrupo':
//        try {
//            $dados = filter_input(INPUT_POST, 'dados',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY); 
////            $grupoRecurso = new GrupoRecurso();
////            $grupoRecurso->setNmRecurso($dados['nmGrupoRecurso']);
////            echo $grupoRecurso->cadastrarRecurso($session);
//            return;
//            break;
//        } catch (Error $e) {
//            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
//            return;
//            break;
//        }
}