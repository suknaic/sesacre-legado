<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

$session = new Session();
if(!$session->vPPlanejamento()){
    header("Location: /pages/index.php"); 
}


$ano = (int)filter_input(INPUT_GET, 'token', FILTER_DEFAULT);

if(empty($ano) 
        || strlen($ano) != 4){
    header("Location:index.php"); 
}



?>
