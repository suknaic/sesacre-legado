<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Fonte.class.php";

$session = new Session();

if(!$session->vPPlanejamento()){
    header("Location: /pages/index.php?permi=1"); 
}

$conexao = new Conexao();
$pdo = $conexao->connect();


$selectAno = Metodos::retornaAnosSelect("");

$fonte = new Fonte();
$selectFonte = $fonte->retornaOptionSelect($pdo);

?>
