<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/SesPessoaJuridicaModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoPesquisa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";

$session = new Session();
$session->recurso();


$recurso = new RecursoUtil();
$recurso->setIdPessoa($session->getIdUser());
$recurso->setLinkRecurso("/pages/recurso/recurso");
$recurso->carregaRecursoUsuario();



$tipoGasto = new TipoGasto();
$pessoaJuridicaOptions = SesPessoaJuridicaModel::optionPessoaJuridica();

$centrais = new FinCentralModel();

$finEmpenhoPesquisa = new FinEmpenhoPesquisa();

$tipoGastoOptions = $tipoGasto->retornaOption();
