<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pes/Pes.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItem.class.php";

$session = new Session();

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


$pas = new Pas();
$pas->setIdPas($idPas);
$info = $pas->carregaDadosRetornaInfo();

$lotacoes = "";


$conexao = new Conexao();
$pdo = $conexao->connect();

//Verifica se o Usuário tem perfil para visualizar o Pas dessa Lotação ou se tem perfil master
if(!$session->vPPlanejamento()){
        
    //Verifica se tem permissão para essa Lotação
    if(!$pas->verificaPermissaoPas($pas->getIdLotacao(), $pdo)){
        header("location: /index.php");
    }        
}

//Token referente ao Id do PAS para Edição
$tokenI = filter_input(INPUT_GET, 'tokenI');

$idPas = $pas->getIdPas();



$msgValidacaoComCentral = $pas->vItensValidacaoCentral($pdo);



?>