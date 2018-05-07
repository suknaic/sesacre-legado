<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaAcaoDet.class.php";

$session = new Session();

$p = new PtaAcaoDet();
$select = $p->apagarEssaFuncao();



?>
