<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/Liquidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoHistorico.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";

$session = new Session();

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

if (empty($id)) {
    header("Location: /pages/index.php");
}

$liquidacao = new Liquidacao();
$liquidacao->setIdLiquidacao($id);

//DADOS DA LIQUIDAÇÃO
$dadosLiquidacao = $liquidacao->retornaDadosLiquidacao();

$liquidacao->setIdEmpenho($dadosLiquidacao['id_empenho']);

$historico = $liquidacao->retornaHistorico();

$tabelaDocumentosFiscais = null;
$tem_documentos = false;
if ($dadosLiquidacao['id_tipo_solicitacao'] == 2) { // ESTE TIPO DE SOLICITAÇÃO OBRIGA A VINCULAÇÃO DA LIQUIDAÇÃO COM DOCUMENTOS FISCAIS
    $tem_documentos = true;
    $tabelaDocumentosFiscais = $liquidacao->montaTabelaDocumentosLiquidacao(false);
}

$vincTramitacao = new VincularTramitacao();
$vincTramitacao->setIdDocTipoLotacao($dadosLiquidacao['id_doc_tipo_lotacao']);
$vincTramitacao->setIdLotacao($dadosLiquidacao['id_lotacao']);

$selectRemetente = $vincTramitacao->listaLotacaoTipoPorLotacaoETipo();

//DADOS DO CONTRATO
$finContratoModel = new FinContratoModel();
$dadosContrato = $finContratoModel->retornaContratoGdof(null, $dadosLiquidacao["nr_pedido"]);

//DADOS DO PEDIDO DE NECESSIDADE
$dadosPedido = $liquidacao->retornaPedidoLiquidacao(null);

//DADOS DO EMPENHO
$dadosEmpenho = $liquidacao->retornaEmpenhoLiquidacao(null,1);
