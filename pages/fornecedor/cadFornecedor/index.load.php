<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    $session = new Session('ajaxSemAcesso');
    if(!empty($_SESSION['idUser'])){
        session_destroy();
        header("Location: /pages/sistema/login/index.php");
    } else {
        session_destroy();
    }

?>
