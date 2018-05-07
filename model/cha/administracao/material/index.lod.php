<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/cha/administracao/material/Material.class.php";

    $session = new Session();
    
    if (!$session->vPGeral()) {
        echo "<script>
                    alert('Você não tem permissão para acessar essa página.');
                    window.location.href='/pages/index.php';
              </script>";
    }

    if (!empty($_REQUEST['idMaterial'])) {
        $idMaterial = $_REQUEST['idMaterial'];
        
        $material = new Material();
        $material->setIdMaterial($idMaterial);
        $dadosMaterial = $material->carregarMaterial();
    } else {
        $dadosMaterial = 0;
    }
    

