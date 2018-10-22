<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/SesPessoaJuridicaModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/empenho/EmpenhoAnulacaoPesquisa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";

$session = new Session();

if(!$session->vPContabilEmpenhoAnulacao()){
    header("Location: /pages/index.php"); 
}

$tipoGasto = new TipoGasto();
$pessoaJuridicaOptions = SesPessoaJuridicaModel::optionPessoaJuridica();

$centrais = new FinCentralModel();

$tipoGastoOptions = $tipoGasto->retornaOption();