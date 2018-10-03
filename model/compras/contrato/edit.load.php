<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/centrais/FinCentraisModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/SesPessoaJuridicaModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestor/FinGestorModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/fiscais/FinFiscaisModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/sub_fiscal/SubFiscalModel.class.php";
$session = new Session();
if (!$session->vPContratosTecnico()) {
	header("Location: /pages/index.php");
}

$token = filter_input(INPUT_GET, 'token', FILTER_DEFAULT);

if(!isset($_GET['token'])){
    header("location: /index.php");
}else{
    $id = (int)($token);
    if($id == 0){
        header("location: /index.php");
    }
}

$finContratoModel = new FinContratoModel();
$finContratoModel->setIdFornecedor($id);
$array = $finContratoModel->retornaDados(); 

$finCentraisModel = new FinCentraisModel();
$campoCentral = $finCentraisModel->campoCentraisOptions(null, $id);

$sesPessoaJuridicaModel = new SesPessoaJuridicaModel();
//setando id para retorna CNPJ
$sesPessoaJuridicaModel->setId_pessoa_juridica($array[0]["id_pessoa"]);
$cnpj = json_decode($sesPessoaJuridicaModel->returnnaCnpj());
