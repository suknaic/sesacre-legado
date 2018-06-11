<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

try {
    $conexao = new Conexao();
    $pdo = $conexao->connect();
    $pdo->beginTransaction();

    $sql = $pdo->query('SELECT id_anexo, ds_anexo, lk_anexo FROM gco_anexo');
    $dados = $sql->fetchAll(PDO::FETCH_ASSOC);
//    print_r($dados);
//    return;
    //********** Mostrar Arquivo *********
//    header('Content-type: '.$dados[0]['nm_mime_type']);
//    header('Content-Disposition: inline; filename="' . $dados[0]['ds_anexo'] . '"');
//    fpassthru($dados[0]['aq_anexo']);
//    return;
    //************************************
    foreach ($dados as $linha) {
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . $linha['lk_anexo'])) {
            $nomeAnexo = $linha['ds_anexo'];
            $idAnexo = $linha['id_anexo'];
            $tipoAnexo = mime_content_type($_SERVER["DOCUMENT_ROOT"] . $linha['lk_anexo']);
            $binAnexo = fopen($_SERVER["DOCUMENT_ROOT"] . $linha['lk_anexo'], 'rb');

            $update = $pdo->prepare('UPDATE gco_anexo SET nm_mime_type = :tipo, aq_anexo = :bin WHERE id_anexo = :idAnexo');
            $update->bindValue(':tipo', $tipoAnexo, PDO::PARAM_STR);
            $update->bindVAlue(':bin', $binAnexo, PDO::PARAM_LOB);
            $update->bindValue(':idAnexo', $idAnexo, PDO::PARAM_INT);
            $update->execute();
            
            echo $idAnexo.' --> '.$nomeAnexo . '  --> <font color="green"> TRANSFERIDO.</font><br>';
        } else {
            echo $linha['id_anexo'] . ' --> ' . $linha['lk_anexo'] .' --> '. $linha['ds_anexo'] . '  --> <font color="red"> NÃO ENCONTRADO.</font><br>';
        }
    }
    $pdo->commit();
    return;
    //**************************************************************************************************************
} catch (Exception $ex) {
    echo $ex->getMessage();
    return;
}