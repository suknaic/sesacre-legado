<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/cidade/Cidade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";


$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    
    case 'listaContratoOption':
        try {
            $contrato = new Contrato();
            echo $contrato->retornaOptionPessoaContrato();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaLotacaoOption':
        try {
            $filtro = filter_input(INPUT_GET, 'pessoa', FILTER_DEFAULT);
            $prog = new Lotacao();
            $prog->setId_pessoa($filtro);
            echo $prog->retornaOptionLotacaoPessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaFuncaoOption':
        try {
            $filtro = filter_input(INPUT_GET, 'pessoa', FILTER_DEFAULT);
            $prog = new Contrato();
            echo $prog->optionsFuncoesContrato(null,$filtro);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'listaDecretoOption':
        try {
            $prog = new Diaria();
            echo $prog->retornaDecretosOption();
            return;
            break;
            
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaTransporteOption':
        try {
            $prog = new Diaria();
            echo $prog->retornaTransporteOption();
            return;
            break;
            
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'listaTipoOption':
        try {
            $prog = new Diaria();
            echo $prog->retornaTipoDiariaOption();
            return;
            break;
            
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
    case 'listaClasseOption':
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $prog = new Diaria();
            echo $prog->retornaClasseOption(null,(int)$filtro['decreto'],(int)$filtro['classe']);
            return;
            break;
            
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'listaDiariaPaiOption':
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
            $prog = new Diaria();
            $prog->setIdDiaria((int)$filtro['diaria']);
            $prog->setIdDiariaPai((int)$filtro['diariaPai']);
            echo $prog->retornaDiariaPaiOption();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
    case 'listaHistoricoTexto':
        try {
            $filtro = filter_input(INPUT_GET,'id',FILTER_DEFAULT);
            $prog = new Diaria();
            $prog->setIdDiaria((int)$filtro);
            echo $prog->retornaHistorico();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }


    case 'validaDiariaDestino':
        try {
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT);
            $diaria = new Diaria();
            $diaria->setItinerario($filtro);
            echo $diaria->validaDiariaDestino();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }


    case 'salvarDiaria':
        try {
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $diaria = new Diaria();
            $diaria->setIdTipo((int)$filtro['tipo']);
            $diaria->setIdDiariaPai((int)$filtro['idDiariaPai']);
            $diaria->setNrProtocolo($filtro['nrProtocolo']);
            
            $diaria->setIdPessoaProponente((int)$filtro['proponente']);
            $diaria->setIdLotacaoProponente((int)$filtro['proponenteLotacao']);
            $diaria->setIdFuncaoProponente((int)$filtro['proponenteFuncao']);
            
            $diaria->setIdPessoaProposto((int)$filtro['proposto']);
            $diaria->setIdLotacaoProposto((int)$filtro['propostoLotacao']);
            $diaria->setIdFuncaoProposto((int)$filtro['propostoFuncao']);
            
            $diaria->setDsServicoExecutado($filtro['servicosExec']);
            $diaria->setDsLocaisExecutado($filtro['locaisExec']);
            $diaria->setDsObs($filtro['obs']);
            
            $diaria->setDtCriacao($filtro['dtCriacao']);
            $diaria->setIdPessoaSolicitante($session->getIdUser());
            $diaria->setIdLotacaoSolicitante((int)$filtro['solicitanteLotacao']);
            
            $diaria->setItinerario($filtro['itinerario']);
            
            if (array_key_exists('anexos',$filtro)) {
                $diaria->setAnexos($filtro['anexos']);
            }
            
            if ((int)$filtro['idDiaria']) {
                $diaria->setIdDiaria((int)$filtro['idDiaria']);
                echo $diaria->atualizarDiaria();
            } else {
                echo $diaria->salvarDiaria();
            }
            return;
            break;
            
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornaDiaria':
        try {
            $id_diaria = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
            $prog = new Diaria();
            $prog->setIdDiaria($id_diaria);
            echo $prog->retornaDadosDiaria();
            return;
            break;
        } catch (Exception $exc) {
            echo Metodos::retornoAjax("Erro", "console", $exc->getMessage());
            return;
            break;
        }


}

?>

