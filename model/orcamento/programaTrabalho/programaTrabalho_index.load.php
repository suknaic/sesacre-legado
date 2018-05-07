<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/ProgramaTrabalho.class.php";

$session = new Session();

if(!$session->vPPlanejamento()){
    header("Location: /pages/index.php");
}elseif(empty($_REQUEST['idProgTrab']) == FALSE) {
    $classe = new ProgramaTrabalho();
    $classe->setIdProgramaTrabalho($_REQUEST['idProgTrab']);
    
    $dados = $classe->carregadoDadosProgramaTrbalho();
}else{
    $dados = 0;
}

