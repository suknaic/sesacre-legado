<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/SesPessoaJuridicaModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocumentoSituacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";

$session = new Session();

$tipoGasto = new TipoGasto();

$docSituacao = new DocumentoSituacao();

$tipoGastoOptions = $tipoGasto->retornaOption();

$pessoaJuridicaOptions = SesPessoaJuridicaModel::optionPessoaJuridica();

$selectSitDoc = $docSituacao->situacoesOptions();

$lotacao = new Lotacao();
$selectLotacoes = $lotacao->retornaOptionLotacao();