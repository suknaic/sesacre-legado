<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/DocTipoDestinatario.class.php";

$session = new Session();

$conexao = new Conexao();
$pdo = $conexao->connect();

$contrato = new Contrato();
$selectUsuario = $contrato->retornaOptionUsuarioContrato($pdo);

$docTipoDestinatario = new DocTipoDestinatario();
$selecTipoDestinatario = $docTipoDestinatario->optionsTipoDestinatario();
