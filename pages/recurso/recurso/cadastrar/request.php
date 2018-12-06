<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/sistema/Sistema.class.php";

$session = new Session('ajax');
$session->recurso();

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
    CASE 'cadastrarRecurso':
        try {
            $dados = filter_input(INPUT_POST, 'dados',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);    
            $recurso = new Recurso();
            $recurso->setIdSistema((int)$dados['idSistema']);
            $recurso->setNmRecurso($dados['nmRecurso']);
            $recurso->setLkRecurso($dados['lkRecurso']);
            $recurso->setDsRecurso($dados['dsRecurso']);
            echo $recurso->cadastrarRecurso($session);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

}