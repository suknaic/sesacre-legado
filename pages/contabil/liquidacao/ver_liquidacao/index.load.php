<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/Liquidacao.class.php";

$session = new Session();

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

if (empty($id)) {
    header("Location: /pages/index.php");
}

$liquidacao = new Liquidacao();
$liquidacao->setIdLiquidacao($id);

//DADOS DA LIQUIDAÇÃO
$dadosLiquidacao = $liquidacao->retornaDadosLiquidacao();

//OPTIONS PARA ESCOLHER OS DOCUMENTOS FISCAIS
$liquidacao->setIdEmpenho($dadosLiquidacao['id_empenho']);


$edita = false;
$tabelaDocumentosFiscais = $liquidacao->montaTabelaDocumentosLiquidacao($edita);

//DADOS DO CONTRATO
$finContratoModel = new FinContratoModel();
$dadosContrato = $finContratoModel->retornaContratoGdof(null, $dadosLiquidacao["nr_pedido"]);

//DADOS DO PEDIDO DE NECESSIDADE
$pedido = new Pedido();
$pedido->setNrPedido($dadosLiquidacao["nr_pedido"]);
$dadosPedido = $pedido->retornaPedidoGdof(null);

//DADOS DO EMPENHO
$finEmpenhoModel = new FinEmpenhoModel();
$finEmpenhoModel->setIdPedido($dadosLiquidacao["id_pedido"]);
$dadosEmpenho = $finEmpenhoModel->retornaEmpenhoGdof(null);
