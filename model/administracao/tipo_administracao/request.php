<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/administracao/tipo_administracao/TipoAdministracao.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    case 'listaTiposAdministracoes':
        try {
            $prog = new TipoAdministracao();
            echo $prog->listaTodasAdministracoes();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'cadTipoAdministracao':
        try {
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $prog = new TipoAdministracao();
            $prog->setNmTipoadministracao($filtro['administracao']);
            echo $prog->salvarTipoAdministracao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'altTipoAdministracao':
        try {
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $prog = new TipoAdministracao();
            $prog->setIdTipoAdministracao($filtro['id']);
            $prog->setNmTipoadministracao($filtro['administracao']);
            echo $prog->alterarTipoAdministracao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'remTipoAdministracao':
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $prog = new TipoAdministracao();
            $prog->setIdTipoAdministracao((int)$filtro);
            echo $prog->removerTipoAdministracao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

}