<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
$session = new Session();
if (!$session->vPContratos()) {
	header("Location: /pages/index.php");
}