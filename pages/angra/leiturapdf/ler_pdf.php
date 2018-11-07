<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";
?>

<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>TESTE</title>                       
    </head>
    <body>
        <?php
$session = new Session();
$diaria = new Diaria();

$idAnexo  = $_REQUEST['id'];

if ($idAnexo) {
    $arquivo = $diaria->baixarAnexo(null,$idAnexo);
    header('Content-type: ' . $arquivo['nm_mime_type']);
    header('Content-Disposition: inline; filename= "' .$arquivo['nm_anexo'].'"');
    fpassthru($arquivo['aq_anexo']);
}

?>
        
    </body>
</html>


