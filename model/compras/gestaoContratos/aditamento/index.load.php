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

$tipoAditivo = "v";

$idTipoAditvo = $tipoAditivo;
$nomeAditivo = $aditivoArray[$tipoAditivo];

$motivoAditivo = "Aditivo por ".$aditivoArray[$tipoAditivo];
$sequencialUltimoAditivo = 0;
//$numeroAditivo = $sequencialUltimoAditivo."º Termo Aditivo ao Contrato ".$contrato;

//Finalidade
$arrayFinalidade = array(
    1 => "Adição",
    2 => "Supressão"
);
$selectFinalidade = "";
foreach ($arrayFinalidade as $key => $value) {
    $selectFinalidade .= "<option value=".$key.">".$value."</option>";
}

$selectInstrumento = "";
$arrayInstrumento = array(
    1 => "Revisão",
    2 => "Reajuste"
);
foreach ($arrayInstrumento as $key => $value) {
    $selectInstrumento .= "<option value=".$key.">".$value."</option>";
}

$selectBaseCalculo = "";
$arrayBaseCalculo = array(
    1 => "Valor Global",
    2 => "Valor Unitário"
);
foreach ($arrayBaseCalculo as $key => $value) {
    $selectBaseCalculo .= "<option value=".$key.">".$value."</option>";
}

$selectUnidadeCalculo = "";
$arrayUnidadeCalculo = array(
    1 => "Percentual",
    2 => "Índice de Correção",
    3 => "Moeda",
    4 => "Quantidade"
);
foreach ($arrayUnidadeCalculo as $key => $value) {
    $selectUnidadeCalculo .= "<option value=".$key." disabled>".$value."</option>";
}

$selectTipoAquisicao = "";
$arrayTipoAquisicao = array(
    1 => "Obras, Serviços ou Compras",
    2 => "Reforma de Edifício ou de Equipamento"
);
foreach ($arrayTipoAquisicao as $key => $value) {
    $selectTipoAquisicao .= "<option value=".$key.">".$value."</option>";
}



?>
