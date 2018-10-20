<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/empenho/EmpenhoAnulacao.class.php";

$session = new Session();

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

if (empty($id)) {
    header("Location: /pages/index.php");
}

if(!$session->vPContabilEmpenhoAnulacao()){
    header("Location: /pages/index.php"); 
}

$empenhoAnulacao = new EmpenhoAnulacao();
$empenhoAnulacao->setIdEmpenhoAnulacao($id);
$dadosAnulacao = $empenhoAnulacao->retornaDadosDaAnulacaoDoEmpenho();
$dadosEmpenho = $empenhoAnulacao->retornaDadosEmpenhoDaAnulacao();
$dadosContrato = $empenhoAnulacao->retornaDadosContratoDaAnulacao();
$dadosPedido = $empenhoAnulacao->retornaDadosPedidoDaAnulacao();
$dadosAnulacaoItens = $empenhoAnulacao->retornaItensDaAnulacaoDoEmpenho();
$dadosAnotacoes = $empenhoAnulacao->retornaAnotacoesDaAnulacaoDoEmpenho();
$dadosHistorico = $empenhoAnulacao->retornaHistoricoDaAnulacaoDoEmpenho();


