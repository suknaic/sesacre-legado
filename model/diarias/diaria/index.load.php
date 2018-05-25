<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";

$session = new Session();
if(!$session->vPDiariasSolicitacao()){
    header("Location: /pages/index.php"); 
}

$contrato = new Contrato();
$lotacao = new Lotacao();
$diaria = new Diaria();

$id_diaria = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
$jsonDiaria = "";
$linhasAnexos = "";

if ($id_diaria) {
    $diaria->setIdDiaria($id_diaria);
    $jsonDiaria = $diaria->retornaDadosDiaria();
    $linhasItinerario = $diaria->retornaTrsItinerario();
    $linhasAnexos = $diaria->retornaAnexos();
} else {
    $id_diaria = "";
    $linhasItinerario = "";
}


$selectDecretoOption = $diaria->retornaDecretosOption();
$selectTransporteOption = $diaria->retornaTransporteOption();

$selectLotacaoProponente = '';
$selectLotacaoProposto = '';   
$selectFuncaoProponente = '';
$selectFuncaoProposto = '';
$dh_inicio = '';
$dh_fim = '';
$origem = '';
$destino = '';
$qt_diaria_destino = 0;
$vl_diaria_destino = 0;
$id_diaria_destino = '';
$id_cidade_inicio = '';
$fl_pernoite = '';
$st_estagio = '';

//Se encontrou a diária preenche as informações
if ($jsonDiaria != ""){
    $objDiaria = json_decode($jsonDiaria);
    
    $diaria->setIdDiariaPai($objDiaria->id_diaria_pai);
    $selectDiariaPaiOption = $diaria->retornaDiariaPaiOption();
    
    $selectTipoDiariaOption = $diaria->retornaTipoDiariaOption(null, $objDiaria->id_tipo);
        
    $selectPessoaProponente = $contrato->retornaOptionPessoaContrato(null,$objDiaria->id_pessoa_proponente);
    $selectPessoaProposto = $contrato->retornaOptionPessoaContrato(null,$objDiaria->id_pessoa_proposto);
    
    $selectLotacaoProponente = $lotacao->retornaOptionLotacao(null,$objDiaria->id_lotacao_proponente);
    $selectLotacaoProposto = $lotacao->retornaOptionLotacao(null,$objDiaria->id_lotacao_proposto);   
    //
    $selectFuncaoProponente = $contrato->optionsFuncoesContrato(null,$objDiaria->id_pessoa_proponente, $objDiaria->id_funcao_proponente);
    $selectFuncaoProposto= $contrato->optionsFuncoesContrato(null,$objDiaria->id_pessoa_proposto, $objDiaria->id_funcao_proposto);
     
//    $id_classe_default = $objDiaria->id_classe;
    $ds_servico_executado = $objDiaria->ds_servico_executado;
    $ds_locais_executado = $objDiaria->ds_locais_executado;

    $dt_criacao = $objDiaria->dt_criacao;
    $ds_obs = $objDiaria->ds_obs;
    
    $st_estagio = $objDiaria->st_estagio;

} else {

    $selectTipoDiariaOption = $diaria->retornaTipoDiariaOption();
    $selectDiariaPaiOption = $diaria->retornaDiariaPaiOption();
    
    $selectPessoaProponente = $contrato->retornaOptionPessoaContrato();
    $selectPessoaProposto = $contrato->retornaOptionPessoaContrato();
    
   
    $ds_servico_executado = '';
    $ds_locais_executado = '';
    
    $dt_criacao = '';
    $ds_obs = '';

}