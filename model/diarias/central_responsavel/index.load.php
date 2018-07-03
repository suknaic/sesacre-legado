<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";

$session = new Session();
if(!$session->vPGeral()){
    header("Location: /pages/index.php"); 
}

$conexao = new Conexao();
$pdo = $conexao->connect();
$contrato = new Contrato();
$selectPessoa = $contrato->retornaOptionUsuarioContrato($pdo);

$lotacao = new FinCentralModel();
$selectCentral = $lotacao->retornaOptionsCentrais($pdo);



