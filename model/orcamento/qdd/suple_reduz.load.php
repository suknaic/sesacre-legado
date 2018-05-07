<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/ProgramaTrabalho.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Fonte.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Despesa.class.php";

$session = new Session();
if(!$session->vPQdd()){
    header("Location: /pages/index.php"); 
}

$ano = (int)filter_input(INPUT_GET, 'token', FILTER_DEFAULT);

if(empty($ano) 
        || strlen($ano) != 4){
    header("Location: /pages/index.php"); 
}

$conexao = new Conexao();
$pdo = $conexao->connect();

$qdd = new Qdd();
$qdd->setAaQdd($ano);

$qdd->verificaExisteCarregaDados($pdo);

if(empty($qdd->getIdQdd())){     
    header("Location: /pages/index.php");  
}                  

$programaTrabalho = new ProgramaTrabalho();
$programaTrabalho->setAaProgramaTrabalho($ano);
$selectProgramaTrabalho = $programaTrabalho->retornaOptionSelectPorAno();

$fonte = new Fonte();
$selectFonte = $fonte->retornaOptionSelect($pdo);

$despesa = new Despesa();
$selectDespesa = $despesa->retornaOptionDespesaElemento($pdo);



?>
