<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/ItemModel.class.php";
$session = new Session();
$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
$token = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

$finContratoModel = new FinContratoModel();
$finContratoModel->setIdFornecedor($id);
$array = $finContratoModel->retornaDados(); 
$itemModel = new ItemModel();
$itemModel->setIdFornecedor($id);
$tabela = $itemModel->retornaTrItem();
