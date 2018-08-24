<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/autorizacoes/FinAutorizacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";
$session = new Session();

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

if(empty($id)){
    echo "pedido não existe";
    exit();
}
//11
if($id != 3877){
    echo "pedido não existe";
    exit();
}


$finEmpenhoModel = new FinEmpenhoModel();
$finEmpenhoModel->setIdPedido($id);
$dados = $finEmpenhoModel->retornaDadosPedido();

if(empty($dados)){
    echo "pedido não existe";
    exit();
}

$idPedido = $id;


$justificativa = $dados[0]['ds_pedido'];



?>
