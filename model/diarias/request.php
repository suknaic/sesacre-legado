<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/cidade/Cidade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";


$session = new Session('ajax');

switch ($_REQUEST['acao']) {
   case 'listaDiarias':
        try {
            $prog = new Diaria();
            $prog->setUsuarioSessao($session);
            if ($session->vPGeral()) {
                echo $prog->retornaTrDiariasTodas();
            } else {
                echo $prog->retornaTrDiariasSolicitacao();
            }
            
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
    
   case 'listaCidades': //Esse request é utilizado pela classe Diária e Relatório, quando o usuário seleciona as cidades do itinerario. Por este motivo optou-se pela permanencia da função neste request em um nível mais 'genérico'
        
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

?>

