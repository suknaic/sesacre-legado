<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/PasValidacao.class.php";


$session = new Session();

$info = "";


if(!$session->vPPlanejamento()){
    header("location: /index.php?permi=1");
}

//Token referente ao id da Lotação, caso não tenha irá direto para o index
$token = filter_input(INPUT_GET, 'token');
//Verifica se foi passado um token
if(!isset($_GET['token'])){
    header("location: /index.php");
}else{  
    $idPas = (int)($token); 
    if($idPas == 0){
        header("location: /index.php");
    }    
}

$conexao = new Conexao();            
$pdo = $conexao->connect();         

$pas = new Pas();
$pas->setIdPas($idPas);
$info = $pas->carregaDadosRetornaInfo();



$textAreaMsgs = "";
$pas->retornaTextAreaDasValidacoes($pdo);
if($pas->Sucesso()){    
    $textAreaMsgs = $pas->getMsgRetorno();    
}








?>
