<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocTipoLotacao.class.php";


$session = new Session();

$tipoLotacao= new DocTipoLotacao();


$selectTipoRemetente = $tipoLotacao->optionsTipoLotacao();

$selectTipoDestinatario = $tipoLotacao->optionsTipoLotacao();

//$selectDestinatario = '<option value=0>Selecione um destinatário</option>';
//$selectDestinatario .= $lotacao->retornaOptionLotacao();
