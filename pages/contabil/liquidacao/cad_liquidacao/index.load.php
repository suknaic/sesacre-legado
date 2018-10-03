<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
$session = new Session();

$empenho = (int)filter_input(INPUT_GET, 'token', FILTER_DEFAULT);