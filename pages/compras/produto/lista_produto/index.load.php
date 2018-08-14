<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

$session = new Session();

if(!$session->vPContratos()){
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
