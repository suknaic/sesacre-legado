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
 * Só pode Cadastrar o Empenho quem tiver Tramitação Empenhar
 */
$tramitacao = new VincularTramitacao();
$tramitacao->setIdPessoa($session->getIdUser());
$tramitacao->setIdTramitacao($tramitacao->getTramitacaoEmpenhar());
$tramitacao->verificaPessoaTramitacao();
if(!$tramitacao->Sucesso() and !$session->vPGeral()){
    header("Location: /pages/index.php");
}

$pedido = (int)filter_input(INPUT_GET, 'token', FILTER_DEFAULT);

$empenho = new FinEmpenhoModel();