<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/SesPessoaJuridicaModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoPesquisa.class.php";

$session = new Session();
$tipoGasto = new TipoGasto();
$pessoaJuridicaOptions = SesPessoaJuridicaModel::optionPessoaJuridica();

$finEmpenhoPesquisa = new FinEmpenhoPesquisa();

$tipoGastoOptions = $tipoGasto->retornaOption();
