<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    case 'listaDiarias':
        try {
            $filtro = filter_input(INPUT_GET, 'estagio', FILTER_DEFAULT);
            $diaria = new Diaria();
            $diaria->setStEstagio($filtro);
            echo $diaria->retornaTrDiariasAutorizacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'listaStEstagioOption':
        try {
            $diaria = new Diaria();
            echo $diaria->retornaStEstagioOptions();
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
            
            $historico['ds_diaria_historico'] = $filtro['obs'];
            $historico['id_pessoa'] = $session->getIdUser();
            
            $diaria = new Diaria();
            $diaria->setIdDiaria($filtro['diaria']);
            $diaria->setStEstagio($filtro['estagio']);
            $diaria->setHistorico($historico);
            echo $diaria->atualizaEstagioDiaria();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

}

