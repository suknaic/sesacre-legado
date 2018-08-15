<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocTipoLotacao.class.php";

$session = new Session();

$conexao = new Conexao();
$pdo = $conexao->connect();

$contrato = new Contrato();
$selectUsuario = $contrato->retornaOptionUsuarioContrato($pdo);

$docTipoLotacao = new DocTipoLotacao();
$selecTipoLotacao = $docTipoLotacao->optionsTipoLotacao();


$lotacao = new Lotacao();
$selectLotacao = $lotacao->retornaOptionLotacao();