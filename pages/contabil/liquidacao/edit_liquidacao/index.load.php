<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
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

if(!$session->vPContabilLiquidacao()){
    header("Location: /pages/index.php"); 
}

/*
 * Só pode Editar a Liquidação quem tiver Tramitação Liquidar
 */
$tramitacao = new VincularTramitacao();
$tramitacao->setIdPessoa($session->getIdUser());
$tramitacao->setIdTramitacao($tramitacao->getTramitacaoLiquidar());
$tramitacao->verificaPessoaTramitacao();
if(!$tramitacao->Sucesso()){
    header("Location: /pages/index.php");
}

$liquidacao = new Liquidacao();
$liquidacao->setIdLiquidacao($id);

//DADOS DA LIQUIDAÇÃO
$dadosLiquidacao = $liquidacao->retornaDadosLiquidacao();

//OPTIONS PARA ESCOLHER OS DOCUMENTOS FISCAIS
$liquidacao->setIdEmpenho($dadosLiquidacao['id_empenho']);

$tem_documentos = false;
$optionsDocumentosFiscais = null;
$tabelaDocumentosFiscais = null;

$optionsDocumentosFiscais = $liquidacao->retornaOptionsDocsEmpenho();
$tabelaDocumentosFiscais = $liquidacao->montaTabelaDocumentosLiquidacao();    

$historico = $liquidacao->retornaHistorico();

$vincTramitacao = new VincularTramitacao();
$vincTramitacao->setIdDocTipoLotacao($dadosLiquidacao['id_doc_tipo_lotacao']);
$vincTramitacao->setIdLotacao($dadosLiquidacao['id_lotacao']);

$selectRemetente = $vincTramitacao->listaLotacaoTipoPorLotacaoETipo();

//DADOS DO CONTRATO
$finContratoModel = new FinContratoModel();
$dadosContrato = $finContratoModel->retornaContratoGdof(null, $dadosLiquidacao["nr_pedido"]);

//DADOS DO PEDIDO DE NECESSIDADE
$pedido = new Pedido();
$pedido->setNrPedido($dadosLiquidacao["nr_pedido"]);
$dadosPedido = $pedido->retornaPedidoGdof(null);


//DADOS DO EMPENHO
$dadosEmpenho = $liquidacao->retornaEmpenhoLiquidacao(null,2);
