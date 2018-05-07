<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/objetivo/Objetivo.class.php";

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
    $idObjetivo = (int)($token);
    if($idObjetivo == 0){
        header("location: /index.php");
    }
}

$obj = new Objetivo();
$obj->carregaInfoObjetivo($idObjetivo);

if($obj->getIdObjetivo() == ""){
    header("location: /index.php");
}

$nomeObjetivo = $obj->getNrOrdem().". ".$obj->getNmObjetivo();
$idEixo = $obj->getIdEixo();
$idPes = $obj->getIdPes();
$idDiretriz = $obj->getIdDiretriz();


?>
