<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/pagamento/ConPagamento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/pagamento/ConPagamentoDoc.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/Liquidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";

$session = new Session();

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

if (empty($id)) {
    header("Location: /pages/index.php");
}

$pagamento = new ConPagamento();
$pagamento->setIdPagamento($id);

//DADOS DA PAGAMENTO
$dadosPagamento = $pagamento->retornaDadosPagamento();
//DADOS DO CONTRATO
$finContratoModel = new FinContratoModel();
$dadosContrato = $finContratoModel->retornaContratoGdof(null, $dadosPagamento["nr_pedido"]);
//DADOS DO PEDIDO DE NECESSIDADE
$pedido = new Pedido();
$pedido->setNrPedido($dadosPagamento["nr_pedido"]);
$dadosPedido = $pedido->retornaPedidoGdof(null);
//DADOS DO EMPENHO
$empenho = new FinEmpenhoModel();
$empenho->setIdPedido($dadosPagamento["id_pagamento"]);
$dadosEmpenho = $empenho->retornaEmpenhoPagamento(null);
//DADOS DA LIQUIDACAO
$liquidacao = new Liquidacao();
$liquidacao->setNrLiquidacao($dadosPagamento["nr_liquidacao"]);
$dadosLiquidacao = $liquidacao->retornaLiquidacaoParaPagamento(null);
//DADOS DO DOCUMENTOS FISCAIS
$tabelaDocumentosFiscais = null;
$tem_documentos = false;
if ($dadosPagamento['id_tipo_solicitacao'] == 2) { // ESTE TIPO DE SOLICITAÇÃO OBRIGA A VINCULAÇÃO DA LIQUIDAÇÃO COM DOCUMENTOS FISCAIS
    $tem_documentos = true;
    $tabelaDocumentosFiscais = $pagamento->tabelaDocumentoPagamentoVisualiza(true);
}
//DADOS TRAMITACAO
$vincTramitacao = new VincularTramitacao();
$vincTramitacao->setIdDocTipoLotacao($dadosPagamento['id_doc_tipo_lotacao']);
$vincTramitacao->setIdLotacao($dadosPagamento['id_lotacao']);
$selectRemetente = $vincTramitacao->listaLotacaoTipoPorLotacaoETipo(); 