<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";

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


?>
