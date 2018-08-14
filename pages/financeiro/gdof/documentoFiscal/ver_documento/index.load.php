<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinDocumentoFiscal.class.php";

$session = new Session();

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

if (empty($id)) {
	header("Location: /pages/index.php");
}

$finDocumentoFiscal = new FinDocumentoFiscal();

$finDocumentoFiscal->setIdDocumentoFiscal($id);
