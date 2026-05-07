<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] .  "/class/sistema/estado/Estado.class.php";

$session = new Session();
$vinc = new Estado();            

                                                   
if(!$session->vPRh() && !$session->vPContratosTecnico()){
    header("Location: /pages/index.php"); 
}

?>
