<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/cidade/Cidade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";


$session = new Session('ajax');

switch ($_REQUEST['acao']) {
   case 'listaDiarias':
        try {
            $prog = new Diaria();
            echo $prog->retornaTrDiarias();
            return;
            break;
        } catch (Exception $exc) {
            echo Metodos::retornoAjax("Erro", "console", $exc->getMessage());
            return;
            break;
        }
        
    case 'excluirDiaria':
        try {
            $filtro = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
            $prog = new Diaria();
            $prog->setIdDiaria((int)$filtro);
            echo $prog->excluirDiaria();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
    case 'listaCidades':
        
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $prog = new Cidade();
            $queryFiltro = '%'. $filtro .'%';
            $prog->setNm_cidade($queryFiltro);
            echo $prog->optionsCidadePorNomeEstado();
            return;
            break;
        } catch (Exception $exc) {
            echo Metodos::retornoAjax("Erro", "console", $exc->getMessage());
            return;
            break;
        }
}

?>

