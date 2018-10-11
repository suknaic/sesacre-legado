<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] .  "/class/sistema/cidade/Cidade.class.php";

$session = new Session();

                                                   
if(!$session->verificaPermissao(PERFIL_TI)){
    header("Location: /pages/index.php"); 
} else {
    $idCidade = $_REQUEST['key'] == null ? null: $_REQUEST['key'];
}

?>
