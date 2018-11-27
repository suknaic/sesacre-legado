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
if(!$tramitacao->Sucesso() and !$session->vPGeral()){
    header("Location: /pages/index.php");
}

$liquidacao = new Liquidacao();
$liquidacao->setIdLiquidacao((int)$id);
//DADOS DA LIQUIDAÇÃO
$dadosLiquidacao = $liquidacao->retornaDadosLiquidacao();

$liquidacao->setIdEmpenho($dadosLiquidacao['id_empenho']);

$optionsDocumentosFiscais = null;

//OPTIONS PARA ESCOLHER OS DOCUMENTOS FISCAIS
$optionsDocumentosFiscais = $liquidacao->retornaOptiosDocumentosLiquidacaoEdicao();

$liquidacaoHistorico = new LiquidacaoHistorico();
$liquidacaoHistorico->setIdLiquidacao($dadosLiquidacao['id_liquidacao']);
$historico = $liquidacaoHistorico->retornaHistorico();

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
