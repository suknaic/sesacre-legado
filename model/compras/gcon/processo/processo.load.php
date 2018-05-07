<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/processo/Processo.class.php";

$session = new Session();

if(!$session->vPComprasTecAdmin()){
    header("Location: /pages/index.php");
}else{
    
    $processo = $_REQUEST['idProcesso'];
    
    $edita = new Processo();
    $edita->setIdProcesso($processo);
    $dados = $edita->carregarProcesso();
}
