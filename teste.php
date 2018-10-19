<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/empenho/EmpenhoAnulacao.class.php";
$session = new Session('ajax');

$empenhoAnulacao = new EmpenhoAnulacao();
$empenhoAnulacao->setIdEmpenhoAnulacao(1);
$empenhoAnulacao->setIdPessoa(2);
$empenhoAnulacao->setIdEmpenhoAnulacaoSituacao(3);
var_dump($empenhoAnulacao->deferimentoDaAnulacaoEmpenho());