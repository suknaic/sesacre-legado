<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoAnotacao.class.php";

$session = new Session();

if(!$session->vPContabilEmpenho()){
    header("Location: /pages/index.php"); 
}

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

if (empty($id)) {
	header("Location: /pages/index.php");
}

$empenho = new FinEmpenhoModel();
$empenho->setIdEmpenho($id);

$dadosDoEmpenho = $empenho->retornaDadosEmpenho(null);
$empenho->setIdPedido($dadosDoEmpenho['id_pedido']);

$dadosDoPedido = $empenho->retornaEmpenhoPedidoAccordion(null);
$dadosDaDiaria = $empenho->retornaEmpenhoPedidoDiariaAccordion(null);
$dadosDoContrato = $empenho->retornaEmpenhoContratoAccordion(null);
$itensDoPedido = $empenho->retornaEmpenhoPedidoItensAccordion(null);
$itensAnuladosDoPedido = $empenho->retornaEmpenhoPedidoItensAnuladosAccordion(null);



$empenhoAnotacao = new FinEmpenhoAnotacao();
$empenhoAnotacao->setIdEmpenho($id);
$anotacoes = $empenhoAnotacao->retornaAnotacoes();



