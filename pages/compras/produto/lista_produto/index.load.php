<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoAditivo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoMotivo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoFinalidade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoAquisicao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoBaseCalculo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoInstrumento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoUnidadeCalculo.class.php";

$session = new Session();

if(!$session->vPContratosTecnico()){
    header("Location: /pages/index.php?permi=false");
}

$dadosContrato = array(
    "item_codigo" => "Código",
    "item_descricao" => "Descrição",
    "item_item" => "Item",
    "item_grupo" => "Grupo",
    "item_sub_grupo" => "Sub Grupo",
    "item_tipo" => "Tipo",
    "item_elemento" => "Elemento de Despesa"    
);

?>
