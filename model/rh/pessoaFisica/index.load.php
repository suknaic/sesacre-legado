<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";

$session = new Session();

if(!$session->vPRh()){
    header("Location: /pages/index.php"); 
} else {
    $cpf = explode("=", $_GET['id'])[0];
    $contrato = new Contrato();
    $qtContratoPessoa = ($contrato->retornaQtContratoPessoa($cpf)+1).'° Contrato';
}
?>
