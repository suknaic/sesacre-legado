<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/eixo/Eixo.class.php";

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
    $idEixo = (int)($token); 
    if($idEixo == 0){
        header("location: /index.php");
    }    
}

$eixo = new Eixo();
$eixo->carregaInfoEixo($idEixo);

if($eixo->getIdEixo() == ""){
    header("location: /index.php");
}

$nomeEixo = $eixo->getNrOrdem().". ".$eixo->getNmEixo();
$idPes = $eixo->getIdPes();



?>
