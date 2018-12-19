<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemAdministracaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemAdministracaoAnotacaoModel.class.php";

$session = new Session();

$id = $_GET["id"];

if (empty($id)) {
    header("Location: /pages/index.php");
}

$finOrdemAdministracaoModel = new FinOrdemAdministracaoModel();
$finOrdemAdministracaoModel->setIdOrdemAdministracao($id);
$dados = $finOrdemAdministracaoModel->retornaDadosReativacaoOrdem();
//dados contratos
$finContratoModel = new FinContratoModel();
$dadosContratos = $finContratoModel->retornaContratoGdof(null, $dados["nr_pedido"]);
//dados pedido
$pedido = new Pedido();
$pedido->setNrPedido($dados["nr_pedido"]);
$dadosPedido = $pedido->retornaPedidoGdof(null, $dados);
//dados empenho 
$finEmpenhoModel = new FinEmpenhoModel();
$finEmpenhoModel->setIdPedido($dados["id_pedido"]);
$dadosEmpenho =  $finEmpenhoModel->retornaEmpenhoGdof(null);
