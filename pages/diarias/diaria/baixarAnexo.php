<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";

$session = new Session();
$diaria = new Diaria();

$idAnexo  = $_REQUEST['id'];

if ($idAnexo) {
    $arquivo = $diaria->baixarAnexo(null,$idAnexo);
    header('Content-type: ' . $arquivo['nm_mime_type']);
    header("Content-Disposition: inline; filename= " .$arquivo['nm_anexo']);
    fpassthru($arquivo['aq_anexo']);
}
