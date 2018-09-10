<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocLotacao.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/tramitacao/Tramitacao.class.php";

$session = new Session();


$conexao = new Conexao();
$pdo = $conexao->connect();

$contrato = new Contrato();
$selectUsuario = $contrato->retornaOptionUsuarioContrato($pdo);

$tramitacao = new Tramitacao();

$optionsTramitacao = $tramitacao->optionsTramitacao();

$docLotacao = new DocLotacao();
$selectDocLotacao = $docLotacao->optionsTipoLotacao();