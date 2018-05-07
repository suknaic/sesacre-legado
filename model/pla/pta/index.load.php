<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/Pta.class.php";

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

$pta = new Pta();

$conexao = new Conexao();
$pdo = $conexao->connect();

//Verifica se o Usuário tem perfil para visualizar o Pas ou se tem perfil master
if(!$session->vPPlanejamento()){
        
    //Verifica se tem permissão para esse PAS
    if(!$pta->verificaPermissaoPta($idPas, $pdo)){
        header("location: /index.php");
    }    
}

$pas = new Pas();
$pas->setIdPas($idPas);

//Retorna os dados das informações do PAS para serem utilizados no tab da página
$lista = $pas->retornaList();

$pas->carregaDados($pas->getIdPas());

$nomePas = $pas->getNmPas();

?>