<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/PasAcao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/ppa_proj_ati/PpaProjAti.class.php";


$session = new Session();

//Token referente ao id da Pas, caso não tenha irá direto para o index
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


$pasAcao = new PasAcao();
$pasAcao->setIdPas($idPas);

$conexao = new Conexao();
$pdo = $conexao->connect();

//Verifica se o Usuário tem perfil para visualizar o Pas dessa Lotação ou se tem perfil master
if(!$session->vPPlanejamentoUsuario()){
        
    //Verifica se tem permissão para essa Lotação
    if(!$pas->verificaPermissaoPas($pasAcao->getIdPas(), $pdo)){
        header("location: /index.php");
    }        
}


$pas = new Pas();
$pas->carregaDados($pasAcao->getIdPas());

$nomePas = $pas->getNmPas();
if($nomePas == ""){
    header("location: index.php");
}

$ppaProjAti = new PpaProjAti();

$selectPpaProjAti = $ppaProjAti->retornaSelectPorVigencia(date("Y", strtotime($pas->getDtInicio())), date("Y", strtotime($pas->getDtFim())));

?>
