<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/administracao/tipo_tramitacao/Tramitacao.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    case 'listaTramitacoes':
        try {
            $prog = new Tramitacao();
            echo $prog->listaTramitacoes();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'cadTipoTramitacao':
        try {
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $prog = new Tramitacao();
            $prog->setNmTramitacao($filtro['tramitacao']);
            echo $prog->salvarTipoTramitacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
//        
//    case 'altTipoAdministracao':
//        try {
//            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
//            $prog = new TipoAdministracao();
//            $prog->setIdTipoAdministracao($filtro['id']);
//            $prog->setNmTipoadministracao($filtro['administracao']);
//            echo $prog->alterarTipoAdministracao();
//            return;
//            break;
//        } catch (Exception $e) {
//            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
//            return;
//            break;
//        }
//
    case 'desativarTipoTramitacao':
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $prog = new Tramitacao();
            $prog->setIdTramitacao((int)$filtro);
            echo $prog->desativarTipoTramitacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'ativarTipoTramitacao':
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $prog = new Tramitacao();
            $prog->setIdTramitacao((int)$filtro);
            echo $prog->ativarTipoTramitacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

}