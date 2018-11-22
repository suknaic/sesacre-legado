<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";

$session = new Session();

$liquidacao = (int)filter_input(INPUT_GET, 'token', FILTER_DEFAULT);

if(!$session->vPContabilPagamento()){
    header("Location: /pages/index.php"); 
}

/*
 * Só permite cadastrar Pagamento quem possuir a Tramitação Pagar
 */
$tramitacao = new VincularTramitacao();
$tramitacao->setIdPessoa($session->getIdUser());
$tramitacao->setIdTramitacao($tramitacao->getTramitacaoPagar());
$tramitacao->verificaPessoaTramitacao();
if(!$tramitacao->Sucesso() and !$session->vPGeral()){
    header("Location: /pages/index.php");
}