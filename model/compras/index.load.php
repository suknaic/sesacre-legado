<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/SesPessoaJuridicaModel.class.php";

$session = new Session();

if(!$session->vPCompras()){
    header("Location: /pages/index.php");
}
