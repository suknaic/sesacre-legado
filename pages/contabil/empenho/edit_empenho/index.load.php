<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoAnotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";

$session = new Session();

if(!$session->vPContabilEmpenho()){
    header("Location: /pages/index.php"); 
}

/*
 * Só pode Editar o Empenho quem tiver Tramitação Empenhar
 */
$tramitacao = new VincularTramitacao();
$tramitacao->setIdPessoa($session->getIdUser());
$tramitacao->setIdTramitacao($tramitacao->getTramitacaoEmpenhar());
$tramitacao->verificaPessoaTramitacao();
if(!$tramitacao->Sucesso() and !$session->vPGeral()){
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
$empenho->setIdTipoEmpenho($dadosDoEmpenho['id_tipo_empenho']);

$dadosDaDiaria = $empenho->retornaEmpenhoPedidoDiariaAccordion(null);
$dadosDoPedido = $empenho->retornaEmpenhoPedidoAccordion(null);
$dadosDoContrato = $empenho->retornaEmpenhoContratoAccordion(null);
$itensDoPedido = $empenho->retornaEmpenhoPedidoItensAccordion(null);


$empenhoAnotacao = new FinEmpenhoAnotacao();
$empenhoAnotacao->setIdEmpenho($id);
$anotacoes = $empenhoAnotacao->retornaAnotacoes();
