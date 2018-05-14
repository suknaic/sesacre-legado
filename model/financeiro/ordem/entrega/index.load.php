<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinProtocoloModel.class.php";
$session = new Session();

$token = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

if(empty($token)){
    header("location: /index.php");
}else{
    $id = (int)($token);
    if($id == 0){
        header("location: /index.php");
    }
}

$finProtocoloModel = new FinProtocoloModel();
$finProtocoloModel->setIdOrdem($id);
$dados = [];
$dados = $finProtocoloModel->inforLoadProtocolo();
var_dump($dados);
