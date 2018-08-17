<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocTipoLotacao.class.php";



$session = new Session();

$tipoLotacao = new DocTipoLotacao();
$selectDocTipos = $tipoLotacao->optionsTipoLotacao();


$lotacao = new Lotacao();
$selectLotacoes = $lotacao->retornaOptionLotacao();