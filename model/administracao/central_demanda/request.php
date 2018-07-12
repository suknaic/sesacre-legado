<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    case 'listaCentraisDemanda':
        try {
            $prog = new FinCentralModel();
            echo $prog->retornaTrCentrais();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'carregaLotacao':
        try {
            $prog = new Lotacao();
            echo '<option value="0">Selecione uma Lotação</option>';
            echo $prog->retornaOptionLotacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'cadCentralDemanda':
        try {
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT);
            $prog = new FinCentralModel();
            $prog->setIdLotacao((int)$filtro);
            echo $prog->salvarCentralDemanda();
            return;
            break;
                        
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'remCentralDemanda':
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $prog = new FinCentralModel();
            $prog->setIdCentralDemanda((int)$filtro);
            echo $prog->excluirCentralDemanda();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}
