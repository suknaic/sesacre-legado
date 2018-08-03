<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/DocTipoDestinatario.class.php";


$session = new Session();

$lotacao = new Lotacao();

$tipoDestinatario = new DocTipoDestinatario();

$selecTipoDestinatario = $tipoDestinatario->optionsTipoDestinatario();

$selectDestinatario = '<option value=0>Selecione um destinatário</option>';
$selectDestinatario .= $lotacao->retornaOptionLotacao();
