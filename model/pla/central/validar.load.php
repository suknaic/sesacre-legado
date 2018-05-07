<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesLotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/central/CentralPessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";

$session = new Session();
$lotacoes = "";
$info = "";



if(!$session->vPPlanejamentoCentral()){
    header("location: /index.php?permi=1");
}

//Token referente ao id da Lotação, caso não tenha irá direto para o index
$token = filter_input(INPUT_GET, 'token');
//Verifica se foi passado um token
if(!isset($_GET['token'])){
    header("location: /index.php");
}else{  
    $idLotacao = (int)($token); 
    if($idLotacao == 0){
        header("location: /index.php");
    }    
}

$tokenC = filter_input(INPUT_GET, 'tokenC');
//Verifica se foi passado um token
if(!isset($_GET['tokenC'])){
    header("location: /index.php");
}else{  
    $idCentral = (int)($tokenC); 
    if($idCentral == 0){
        header("location: /index.php");
    }    
}

$tokenP = filter_input(INPUT_GET, 'tokenP');
//Verifica se foi passado um token
if(!isset($_GET['tokenP'])){
    header("location: /index.php");
}else{  
    $idPas = (int)($tokenP); 
    if($idPas == 0){
        header("location: /index.php");
    }    
}


$central = new CentralPessoa();
$central->setIdLotacao($idCentral);
$central->setIdPessoa($session->getIdUser());

$conexao = new Conexao();            
$pdo = $conexao->connect();         

if(!$session->vPPlanejamento()){
    $central->verificaPermissao($pdo);
    if(!$central->Sucesso()){
        header("location: /index.php?permi=1");
    }
}

$lotacao = new Lotacao();
$lotacao->setId_lotacao($idLotacao);
$lotacao->carregaNomeCidadeResponsavelRetornaInfo($pdo);
if(!$lotacao->Sucesso()){ 
   header("location: /index.php"); 
}

$info = $lotacao->getMsgRetorno();

$centralDemanda = new Lotacao();
$centralDemanda->setId_lotacao($idCentral);
$centralDemanda->carregaNomeCidadeResponsavel($pdo);
if(!$centralDemanda->Sucesso()){
    header("location: /index.php"); 
}







?>
