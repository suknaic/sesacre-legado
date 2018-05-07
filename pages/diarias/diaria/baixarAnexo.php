<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";

$session = new Session();
$diaria = new Diaria();

$idAnexo  = $_REQUEST['id'];

if ($idAnexo) {
    $diaria->setIdAnexo($idAnexo);
    $arquivo = $diaria->baixarAnexo();
    header('Content-type: ' . $arquivo['nm_mime_type']);
    header("Content-Disposition: attachment; filename= " .$arquivo['nm_anexo']);
    fpassthru($arquivo['aq_anexo']);
}
