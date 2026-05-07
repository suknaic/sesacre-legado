<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/modalidade/FinContratoModalidadeModel.class.php";

$session = new Session('ajax');

if (!$session->vPContratos()) {
	echo "SessaoExpirada";
	return;
}

switch ($_REQUEST['acao']) {
CASE 'retornaModalidade':
	try {
		$modalidadeModel = new ModalidadeModel();
		echo $modalidadeModel->retornaOptionsModalidade();
		return;
		break;
	} catch (Error $e) {
		echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
		return;
		break;
	}

CASE 'retornaPessoaJuridica':
	try {
		$modalidadeModel = new ModalidadeModel();
		echo $modalidadeModel->retornaOptionsPessoaJuridica();
		return;
		break;
	} catch (Error $e) {
		echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
		return;
		break;
	}

CASE 'retornaPessoaFisica':
	try {
		$modalidadeModel = new ModalidadeModel();
		echo $modalidadeModel->retornaOptionsPessoaFisica();
		return;
		break;
	} catch (Error $e) {
		echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
		return;
		break;
	}
}
