<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/ProgramaTrabalho.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/processo/Processo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/liberacaoCentral/FinCentralLiberacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/CentralResponsavel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";


$session = new Session('ajax');
// header('Content-type: application/json');

switch ($_REQUEST['acao']) {

    case 'listaUsuariosJSON':
        try {

            $contrato = new Contrato();

            echo $contrato->retornaListaTodasPessoas();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listarProgTrabJSON':
        try {
            $cod = filter_input(INPUT_GET, 'progTrab', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new ProgramaTrabalho();
            $classe->setCdProgramaTrabalho($cod['cd']);
            $classe->setDsProgramaTrabalho($cod['ds']);
            $classe->setAaProgramaTrabalho($cod['ano']);

            echo $classe->listarProgramaTrabalhoJson();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listarLiberacaoCentralJSON':
        try {
            $finCentralLiberacaoModel = new FinCentralLiberacaoModel();
            $finCentralLiberacaoModel->setIdPessoa($session->getIdUser());
            echo $finCentralLiberacaoModel->retornaLiberacoesDastInicial();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listarContratos':
        try {
            $classe = new FinContratoModel();

            echo $classe->retornaContratosVigentes();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listarLicitacoes':
        try {
            $classe = new Processo();

            echo $classe->listaProcessoJSON();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listarEmpenhos':
        try {
            $classe = new FinEmpenhoModel();

            echo $classe->listaEmpenhoJSON();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listarPedidos':
        try {
            $classe = new Pedido();

            echo $classe->listaPedidoJSON();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'listaQuantidadeSituacaoPedido':
        try {

            $classe = new Pedido();

            echo $classe->listaSituacaoQuantidadeJSON();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'listaQuantidadeOrdem':
        try {

            $classe = new FinOrdemModel();

            echo $classe->listaTipoQuantidadeJSON();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'pesquisaGrafico1':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //print_r($dados);
            $todos = $dados['todos'];
            $dataInicio = $dados['dt_inicio'];
            $dataFim = $dados['dt_fim'];
            //**************************************
            $banco = new Contrato();
            echo $banco->pesquisaGrafico($dataInicio, $dataFim, $todos, 1, 0, 0);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
?>
