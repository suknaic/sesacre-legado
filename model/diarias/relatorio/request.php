<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/cidade/Cidade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Relatorio.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {        
    case 'validaRelatorioDestino':
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $relatorio = new Relatorio();
            $relatorio->setDestinos($filtro);
            echo $relatorio->validaRelatorioDestino();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'salvarRelatorio':
        try {
            $filtro = filter_input(INPUT_POST,'dados',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
            $prog = new Relatorio();
            
            $prog->setIdDiaria((int)$filtro['idDiaria']);
            if ((int)$filtro['idRelatorio']) {
                $prog->setIdRelatorio((int)$filtro['idRelatorio']);
            }
            $prog->setDsLocaisExecutado($filtro['dsLocsExec']);
            $prog->setDsServicoExecutado($filtro['dsServExec']);
            $prog->setDtRelatorioDestino($filtro['dtRelDest']);
            $prog->setFlRetorno($filtro['flRet']);
            
            $prog->setDestinos($filtro['destinos']);
            
            if (array_key_exists('anexos',$filtro)) {
                $prog->setAnexos($filtro['anexos']);
            }
            
            if ($prog->getIdRelatorio() > 0) {
                echo $prog->atualizarRelatorio();
            } else {
                echo $prog->salvarRelatorio();
            }
            return;
            break;
        } catch (Exception $exc) {
            echo Metodos::retornoAjax("Erro", "console", $exc->getMessage());
            return;
            break;
        }
    case 'abreArquivo':
        try {
            $filtro = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
            $prog = new Relatorio();
            $prog->setIdRelatorioAnexo((int)$filtro);
            echo $prog->abreArquivo();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaTransporteTipoOption':
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $prog = new Relatorio();
            echo $prog->retornaTransporteTipoOption(null,(int)$filtro['transporte'],(int)$filtro['tipo']);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}