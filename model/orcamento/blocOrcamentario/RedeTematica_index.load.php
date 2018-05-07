<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/RedeTematica.class.php";

$session = new Session();

if(!$session->vPPlanejamento()){
    header("Location: /pages/index.php");
}elseif(empty($_REQUEST['id_rede_tematica']) == FALSE) {
    $classe = new RedeTematica();
    $classe->setIdRedeTematica($_REQUEST['id_rede_tematica']);
    
    $dados = $classe->carregaDadosRedeTematica();
}else{
    $dados = 0;
}