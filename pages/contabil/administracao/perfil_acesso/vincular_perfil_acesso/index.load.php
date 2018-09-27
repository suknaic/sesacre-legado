<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/administracao/Perfil.class.php";

$session = new Session();

$conexao = new Conexao();
$pdo = $conexao->connect();

$contrato = new Contrato();
$selectPessoa = $contrato->retornaOptionUsuarioContrato($pdo);

$perfil = new Perfil();
$selectPerfis = $perfil->retornaSelectPerfis();