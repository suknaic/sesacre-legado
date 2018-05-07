<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Autorizacao.class.php";

$session = new Session();

$autorizacao = new Autorizacao();
$autorizacao->setIdPessoa($session->getIdUser());
if (!$autorizacao->verficarAutorizacaoUsuarioAtividade()) {
    header("Location: /pages/index.php");
}