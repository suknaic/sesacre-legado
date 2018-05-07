<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Portaria.class.php";

$session = new Session();

if(!$session->vPPlanejamento()){
    header("Location: /pages/index.php");
}elseif(empty($_REQUEST['idPortaria']) == FALSE) {
    $classe = new Portaria();
    $classe->setIdPortaria($_REQUEST['idPortaria']);
    
    $classe->carregaDadosPortaria();
    $dados = $classe->getMsgRetorno();
}else{
    $dados = 0;
}