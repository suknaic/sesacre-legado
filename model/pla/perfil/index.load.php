<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/perfil/Perfil.class.php";

$session = new Session();

if(!$session->vPPlanejamento()){
    header("Location: /pages/index.php"); 
}


$conexao = new Conexao();
$pdo = $conexao->connect();

$contrato = new Contrato();
$selectPessoa = $contrato->retornaOptionPessoaContrato($pdo);

$perfil = new Perfil();
$selectPerfis = $perfil->retornaSelectPerfis($pdo);


?>
