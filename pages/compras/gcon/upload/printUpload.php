<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/anexo/Anexo.class.php";

$session = new Session();

try {

    if ($_SESSION['idUser'] != NULL && $session->vPComprasTecAdmin() && $session->vPComprasAdminTi()) {
        $anexo = new Anexo();
        $anexo->setIdAnexo($_REQUEST['idAnexo']);
        $anexo->setIdProcesso($_REQUEST['idProcesso']);

        $dados = $anexo->carregarAnexo();
        if ($dados['aq_anexo'] == NULL) {
            echo "<script>
                    alert('Arquivo Nao Encontrado.');
                    window.close();
                  </script>";
        } else {
            header('Content-type: ' . $dados['nm_mime_type']);
            header('Content-Disposition: inline; filename="' . $dados['ds_anexo'] . '"');
            fpassthru($dados['aq_anexo']);
            return;
        }
    } else {
        echo "<script>
                alert('Você não tem permissão para acessar essa página.');
                top.location='/pages/index.php';
              </script>";
    }
    return;
} catch (Exception $ex) {
    echo $ex->getMessage();
}

