<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/anexo/Anexo.class.php";

$session = new Session();

try {
    $idAnexo = $_REQUEST['idAnexo'];
    $idProcesso = $_REQUEST['idProcesso'];
    
    if (empty($idAnexo && $idProcesso)) {
        echo '<font color="red"> ' . STR_PREENCHER_CAMPOS . '</font>';
        return;
    }
    
    if ($session->vPComprasTecAdmin() && $session->vPComprasAdminTi()) {
        $anexo = new Anexo();
        $anexo->setIdAnexo($idAnexo);
        $anexo->setIdProcesso($idProcesso);

        $dados = $anexo->carregarAnexo();
        if (empty($dados)) {
            echo 'Anexo Não Encontrado.';
            return;
        }
        
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

