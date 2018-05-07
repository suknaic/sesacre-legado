<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

$session = new Session();

if(!$session->vPComprasAdminTi()){
    header("Location: /pages/index.php");
}
