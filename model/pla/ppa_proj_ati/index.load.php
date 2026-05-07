<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/ppa_prog/PpaProg.class.php";

$session = new Session();

if(!$session->vPPlanejamento()){
    header("Location: /pages/index.php"); 
}

$token = filter_input(INPUT_GET, 'token');

//Verifica se foi passado um token
//caso não seja, ele irá pegar o proximo mês para ser carregando por padrão
if(!isset($_GET['token'])){
    header("location: /index.php");
}else{
    $idPpaProg = (int)($token); 
    if($idPpaProg == 0){
        header("location: /index.php");
    }    
}

$ppaProg = new PpaProg();
$ppaProg->setIdPpaProg($idPpaProg);
$ppaProg->carregaDados($ppaProg->getIdPpaProg());

$nomePpaProg = $ppaProg->getNmPpaProg();








?>
