<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoAnotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'retornaTipoRemetenteERemetente':
        try {
            $vincTramitacao = new VincularTramitacao();
            $vincTramitacao->setIdPessoa($session->getIdUser());
            echo $vincTramitacao->listaLotacaoTipoPorUsuarioEmpenho();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'retornaPedido':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $pedido = new Pedido();
            $pedido->setNrPedido($dados);
            echo $pedido->retornaPedidoAtivoSemEmpenho(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'retornaContrato':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $pedido = new Pedido();
            $pedido->setIdPedido((int)$dados);
            echo $pedido->retornaPedidoContratoAccordion(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaDadosPedido':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $pedido = new Pedido();
            $pedido->setIdPedido((int)$dados);
            echo $pedido->retornaDadosPedidoAccordion(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
    CASE 'retornaDadosDiaria':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $pedido = new Pedido();
            $pedido->setIdPedido((int)$dados);
            echo $pedido->retornaDadosPedidoDiariaAccordion(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaItensPedido':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $pedido = new Pedido();
            $pedido->setIdPedido((int)$dados);
            echo $pedido->retornaDadosPedidoItensAccordion(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'cadastraEmpenho':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $empenho = new FinEmpenhoModel();
            $empenho->setIdPedido((int)$dados['idPedido']);
            $empenho->setNrEmpenho($dados['nrEmpenho']);
            $empenho->setIdTipoEmpenho((int)$dados['tpEmpenho']);
            $empenho->setDtEmpenhoSafira($dados['dtEmpenho']);
            $empenho->setDsEmpenho($dados['dsEmpenho']);
            $empenho->setVlEmpenho($dados['vlEmpenho']);
            $empenho->setAnotacoes($dados['anotacoes']);
            $empenho->setIdPessoa($session->getIdUser());
            echo $empenho->salvaEmpenho();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

}