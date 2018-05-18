<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

$session = new Session();

if(!$session->vPContratosTecnico()){
    header("Location: /pages/index.php?permi=false");
}

$dadosContrato = array(
    "con_contrato" => "Contrato",
    "con_licitacao" => "Licitação",
    "con_tipo_gasto" => "Tipo de Gasto",
    "con_objeto" => "Objeto",
    "con_modalidade" => "Modalidade",
    "con_assinatura" => "Data Assinatura",
    "con_publicacao" => "Data Publicação",
    "con_vigencia" => "Vigência",
    "con_descricao_objeto" => "Descrição do Objeto",
    "con_fornecedor" => "Fornecedor",
    "con_valor" => "Valor Atual"
);


$aditivoArray = array(
    "v" => "Valor",
    "p" => "Prazo",
    "vp" => "Valor e Prazo"
);



?>
