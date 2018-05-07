<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

$session = new Session();

//if(!$session->verificaPermissao(PERFIL_TI)){
//    header("Location: /pages/index.php"); 
//}
if(!$session->vPRh()){
    header("Location: /pages/index.php"); 
}
?>
