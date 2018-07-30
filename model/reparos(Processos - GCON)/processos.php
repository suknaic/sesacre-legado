<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Metodos.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/compras/gcon/anotacao/DaoGcoAnotacao.class.php";

$conexao = new Conexao();
$pdo = $conexao->connect();
$pdo->beginTransaction();

$_SESSION['idUser'] = 6;
$idsProcesso = array(50, 51, 54, 53);
foreach ($idsProcesso as $idProcesso) {
    //************************ Insere a anotacao do processo *********************
    //***************************************************
    if ($idProcesso == 50) {
        $dh = "2017-04-10 15:21:00";
        $situacao = 23;
        $anotacao = 'Encaminhado para posicionamento quanto ao resultado da licitação em 10/04/2017.';
    }
    if ($idProcesso == 51) {
        $dh = "2017-04-07 15:59:00";
        $situacao = 23;
        $anotacao = 'Encaminhado em 27/03/2017 para área demandante para posicionamento quanto ao resultado da licitação, através do ADA nº 19-16-0070268';
    }
    if ($idProcesso == 54) {
        $dh = "2017-04-07 15:59:00";
        $situacao = 26;
        $anotacao = 'Encaminhado em 27/03/2017 para área demandante para posicionamento quanto ao resultado da licitação.';
    }
    if ($idProcesso == 53) {
        $dh = "2017-04-07 15:48:00";
        $situacao = 23;
        $anotacao = 'Encaminhado em 27/03/2017 para área demandante para posicionamento quanto ao resultado da licitação.';
    }
    //***************************************************
    try {
        $cadanota = $pdo->prepare("INSERT INTO gco_anotacao(ds_anotacao, dh_anotacao, id_processo, id_situacao, id_pessoa, id_usuario)
                                       VALUES(:anotacoes_process, :dhAnotacao,:id_processo, :id_situacao, :id_tecnico, :id_usuario)");

        $cadanota->bindValue(":anotacoes_process", $anotacao === '' ? null : $anotacao, PDO::PARAM_STR);
        $cadanota->bindValue(":id_processo", $idProcesso, PDO::PARAM_INT);
        $cadanota->bindValue(":id_situacao", $situacao, PDO::PARAM_INT);
        $cadanota->bindValue(":id_usuario", 6, PDO::PARAM_INT);
        $cadanota->bindValue(":id_tecnico", 1723, PDO::PARAM_INT);
        $cadanota->bindValue(":dhAnotacao", $dh, PDO::PARAM_STR);
        $cadanota->execute();
        if (Log::SalvaLogI('gco_anotacao', $pdo->lastInsertId('gco_anotacao_id_anotacao_seq'), $pdo)) {
            echo 'Processo ' . $idProcesso . ' OK...<br>';
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    //*********************************************************************************
}
$pdo->commit();
echo 'Pronto!';
