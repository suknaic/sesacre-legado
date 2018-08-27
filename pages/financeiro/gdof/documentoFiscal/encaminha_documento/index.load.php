<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/SesPessoaJuridicaModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocumentoSituacao.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocVincRecebimento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocVincEncaminhamento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocFiscalEncaminhamento.class.php";
$session = new Session();

$tipoGasto = new TipoGasto();

$docSituacao = new DocumentoSituacao();

$tipoGastoOptions = $tipoGasto->retornaOption();

$pessoaJuridicaOptions = SesPessoaJuridicaModel::optionPessoaJuridica();

$selectSitDoc = $docSituacao->situacoesOptions();

$docVincEncaminhamento = new DocVincEncaminhamento();
$docVincEncaminhamento->setIdPessoa($session->getIdUser());

$docFiscalEncaminhamento =  new DocFiscalEncaminhamento();
$docFiscalEncaminhamento->setIdUsuario($session->getIdUser());
