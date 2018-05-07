<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/diretriz/Diretriz.class.php";

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
    $idDiretriz = (int)($token); 
    if($idDiretriz == 0){
        header("location: /index.php");
    }    
}

$dir = new Diretriz();
$dir->carregaInfoDiretriz($idDiretriz);

if($dir->getIdDiretriz() == ""){
    header("location: /index.php");
}

$nomeDiretriz = $dir->getNrOrdem().". ".$dir->getNmDiretriz();
$idEixo = $dir->getIdEixo();
$idPes = $dir->getIdPes();


?>
