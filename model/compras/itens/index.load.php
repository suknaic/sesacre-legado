<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/SesPessoaJuridicaModel.class.php";

$session = new Session();

if (!$session->vPContratosTecnico()) {
	header("Location: /pages/index.php");
}

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
$id_alt = null;
if (empty($id)) {
	header("Location: /pages/index.php");
}

?>
