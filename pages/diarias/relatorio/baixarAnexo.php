<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Relatorio.class.php";

$session = new Session();
$relatorio = new Relatorio();

$idAnexo  = $_REQUEST['id'];

if ($idAnexo) {
    $relatorio->setIdRelatorioAnexo($idAnexo);
    $arquivo = $relatorio->baixarAnexo();
    header('Content-type: ' . $arquivo['nm_mime_type']);
    header("Content-Disposition: attachment; filename= " .$arquivo['nm_relatorio_anexo']);
    fpassthru($arquivo['aq_relatorio_anexo']);
}