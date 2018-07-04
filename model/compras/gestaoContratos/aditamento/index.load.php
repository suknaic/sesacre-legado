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

$motivoAditamentoGet = filter_input(INPUT_GET, 'm', FILTER_DEFAULT);

if(empty($motivoAditamentoGet)){
    header("Location: /pages/index.php?permi=false");
}



$sequencialUltimoAditivo = 0;
$conexao = new Conexao();
$pdo = $conexao->connect();


//Motivo
$motivo = new FinContratoMotivo();
$motivo->setIdContratoMotivo($motivoAditamentoGet);
$motivo->carregaDados($pdo);
if(empty($motivo->getIdContratoMotivo())){
    header("Location: /pages/index.php");
}
$motivoAditivo = $motivo->getMotivoAditamentoTexto();


//Finalidade
$finalidade = new FinContratoFinalidade();
$selectFinalidade = $finalidade->retornaOption();


//Instrumento
$instrumento = new FinContratoInstrumento();
$selectInstrumento = $instrumento->retornaOption();


//Base de Calculo
$baseCalculo = new FinContratoBaseCalculo();
$selectBaseCalculo = $baseCalculo->retornaOption();


//Unidade de Calculo
$unidadeCalculo = new FinContratoUnidadeCalculo();
$selectUnidadeCalculo = $unidadeCalculo->retornaOption();


//Aquisicao
$aquisicao = new FinContratoAquisicao();
$selectTipoAquisicao = $aquisicao->retornaOption();



?>
