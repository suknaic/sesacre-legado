<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pes/Pes.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/ppa_proj_ati/PpaProjAti.class.php";

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
    $idPes = (int)($token); 
    if($idPes == 0){
        header("location: /index.php");
    }    
}

$pes = new Pes();
$pes->setIdPes($idPes);
$pes->carregaInfoPes();

$nomePes = $pes->getNmPes();

if($nomePes == false || $nomePes == ""){
    header("location: /index.php");
}

$ppaProjAti = new PpaProjAti();


$selectPpaProjAti = $ppaProjAti->retornaSelectPorVigencia($pes->getVigenciaInicio(), $pes->getVigenciaFim());


?>
