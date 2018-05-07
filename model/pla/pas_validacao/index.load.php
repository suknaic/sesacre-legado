<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesLotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/central/CentralPessoa.class.php";

$session = new Session();
if(!$session->vPPlanejamento()){
    header("Location: /pages/index.php"); 
}

?>
