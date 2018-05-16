<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    case 'listaDiarias':
        try {
            $diaria = new Diaria();
            echo $diaria->retornaTrDiariasAutorizacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'atualizaEstagioDiaria':
        try {
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $diaria = new Diaria();
            $diaria->setIdDiaria($filtro['diaria']);
            $diaria->setStEstagio($filtro['estagio']);
            $diaria->setDsHistorico($filtro['obs']);
            $diaria->setIdPessoaHistorico($session->getIdUser());
            echo $diaria->atualizaEstagioDiaria();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

}

