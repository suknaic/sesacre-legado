<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";

$session = new Session();

$empenho = (int)filter_input(INPUT_GET, 'token', FILTER_DEFAULT);

if(!$session->vPContabilLiquidacao()){
    header("Location: /pages/index.php"); 
}

/*
 * Só pode Cadastrar a Liquidação quem tiver Tramitação Liquidar
 */
$tramitacao = new VincularTramitacao();
$tramitacao->setIdPessoa($session->getIdUser());
$tramitacao->setIdTramitacao($tramitacao->getTramitacaoLiquidar());
$tramitacao->verificaPessoaTramitacao();
if(!$tramitacao->Sucesso()){
    header("Location: /pages/index.php");
}