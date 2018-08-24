<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinDocumentoFiscal.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinTipoDocumento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinTipoDocumento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocVincRecebimento.class.php";

$session = new Session();

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

if (empty($id)) {
    header("Location: /pages/index.php");
}

$finDocumentoFiscal = new FinDocumentoFiscal();

$finDocumentoFiscal->setIdDocumentoFiscal($id);

$documento = ($finDocumentoFiscal->retornaDadosDocumento(null));

$tramitacao = $finDocumentoFiscal->retornaPrimeiraTramitacao();
//echo "<pre>";
//print_r($tramitacao);
//echo "</pre>";

$docVincRecebimento = new DocVincRecebimento();
$docVincRecebimento->setIdPessoa($session->getIdUser());
$selectRemetente = $docVincRecebimento->optionsLotacaoRecebimentoPorUsuarioETipo($tramitacao['id_doc_origem']);



if (empty($documento)) {
    header("Location: /pages/index.php");
}