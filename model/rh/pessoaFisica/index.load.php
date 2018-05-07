<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

$session = new Session();

if(!$session->vPRh()){
    header("Location: /pages/index.php"); 
}

?>
