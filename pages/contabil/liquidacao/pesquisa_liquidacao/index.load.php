<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/SesPessoaJuridicaModel.class.php";

$session = new Session();

if(!$session->vPContabilLiquidacao()){
    header("Location: /pages/index.php"); 
}

$tipoGasto = new TipoGasto();

$tipoGastoOptions = $tipoGasto->retornaOption();

$pessoaJuridicaOptions = SesPessoaJuridicaModel::optionPessoaJuridica();