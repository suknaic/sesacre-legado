<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";

$session = new Session();
$diaria = new Diaria();

$diaria->setUsuarioSessao($session);

if(!$session->vPDiariasSolicitacao() and !$diaria->checaUsuarioDiaria()){
    header("Location: /pages/index.php"); 
}
