<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

$session = new Session();

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
if (empty($id)) {
	header("Location: /pages/index.php");
}