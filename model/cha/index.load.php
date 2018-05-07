<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

$session = new Session();
$id = 0;
if(isset($_GET['id'])){
    $id = $_GET['id'];
}

?>
