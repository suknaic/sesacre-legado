<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";

$session = new Session();

if(!$session->vPPlanejamento()){
    header("Location: /pages/index.php"); 
}

//$pessoa = new DaoSesPessoa();
$conexao = new Conexao();
$pdo = $conexao->connect();
$contrato = new Contrato();
$selectPessoa = $contrato->retornaOptionPessoaContrato($pdo);


$lotacao = new Lotacao();
$selectLotacao = $lotacao->retornaOptionLotacao($pdo);


?>
