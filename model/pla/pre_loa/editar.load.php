<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/ProgramaTrabalho.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Despesa.class.php";

$session = new Session();
if(!$session->vPPlanejamento()){
    header("Location: /pages/index.php"); 
}


$ano = (int)filter_input(INPUT_GET, 'token', FILTER_DEFAULT);

if(empty($ano) 
        || strlen($ano) != 4){
    header("Location:index.php"); 
}


$selectFontes = Metodos::retornaFonteSelect();

$progTrab = new ProgramaTrabalho();
$progTrab->setAaProgramaTrabalho($ano);
$selectProgTrab = $progTrab->retornaOptionSelectPorAno();


$despesa = new Despesa();
$selectElemDespesa = $despesa->retornaOptionDespesaElemento();


?>
