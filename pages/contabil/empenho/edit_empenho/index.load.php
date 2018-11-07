<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";

$session = new Session();

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

if (empty($id)) {
	header("Location: /pages/index.php");
}

$empenho = new FinEmpenhoModel();
$empenho->setIdEmpenho($id);

$dadosDoEmpenho = $empenho->retornaDadosEmpenho(null);
$empenho->setIdPedido($dadosDoEmpenho['id_pedido']);
$empenho->setIdTipoEmpenho($dadosDoEmpenho['id_tipo_empenho']);

$dadosDaDiaria = $empenho->retornaEmpenhoPedidoDiariaAccordion(null);
$dadosDoPedido = $empenho->retornaEmpenhoPedidoAccordion(null);
$dadosDoContrato = $empenho->retornaEmpenhoContratoAccordion(null);
$itensDoPedido = $empenho->retornaEmpenhoPedidoItensAccordion(null);
