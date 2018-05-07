<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

$session = new Session();

if(!$session->vPComprasTecAdmin()){
    echo "<script>
                alert('Você não tem permissão para acessar essa página.');
                window.location.href='/pages/index.php';
          </script>";
}