<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocTipoLotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocumentoSituacao.class.php";

$session = new Session();
$tipoLotacao = new DocTipoLotacao();
$docSituacao = new DocumentoSituacao();

$selectTipoRemetente = $tipoLotacao->optionsTipoLotacao();
$selectTipoDestinatario = $tipoLotacao->optionsTipoLotacao();
$selectSitDoc = $docSituacao->situacoesOptions();
