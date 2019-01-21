<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
$session = new Session();
if(!$session->vPContratosTecnico()){
    header("Location: /pages/index.php"); 
}

?>
