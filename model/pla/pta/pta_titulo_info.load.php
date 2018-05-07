<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaTitulo.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesLotacao.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/rh/DaoSesPessoa.class.php";


$session = new Session();

//Token referente ao id da Lotação, caso não tenha irá direto para o index
$token = filter_input(INPUT_GET, 'token');

//Verifica se foi passado um token
if(!isset($_GET['token'])){
    header("location: /index.php");
}else{
    $idPtaTitulo = (int)($token); 
    if($idPtaTitulo == 0){
        header("location: /index.php");
    }    
}

$conexao = new Conexao();
$pdo = $conexao->connect();

$ptaTitulo = new PtaTitulo();
$ptaTitulo->setIdPtaTitulo($idPtaTitulo);

$ptaTitulo->carregaDados($pdo);

$info = $ptaTitulo->retornaList();



//Verifica se o Usuário tem perfil para visualizar o Pas dessa Lotação ou se tem perfil master
if(!$session->vPPlanejamento()){
        
    //Verifica se tem permissão para essa Lotação
    if(!$ptaTitulo->verificaPermissaoPas($ptaTitulo->getIdPas(), $pdo)){
       header("location: /index.php?permi=false");
    }        
}

?>