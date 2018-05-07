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

//Token referente ao id da Central, caso não tenha irá direto para o index
$token = filter_input(INPUT_GET, 'token');
//Verifica se foi passado um token
if(!isset($token)){
    header("location: /index.php");
}else{  
    $idCentral = (int)($token); 
    if($idCentral == 0){
        header("location: /index.php");
    }    
}

$tokenA = filter_input(INPUT_GET, 'tokenA');
//Verifica se foi passado um token
if(!isset($tokenA)){
    header("location: /index.php");
}else{  
    $ano = (int)($tokenA); 
    if($ano == 0 && strlen($ano) != 4){
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


$centralDemanda = new Lotacao();
$centralDemanda->setId_lotacao($idCentral);
$centralDemanda->carregaNomeCidadeResponsavel($pdo);
if(!$centralDemanda->Sucesso()){
    header("location: /index.php"); 
}







?>
