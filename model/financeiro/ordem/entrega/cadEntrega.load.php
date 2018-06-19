<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinProtocoloModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";

$session = new Session();

$token = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
$token2 = filter_input(INPUT_GET, 'ordem', FILTER_DEFAULT);

if (empty($token) && empty($token2)) {
    header("location: /index.php");
} else {
    $id = (int) ($token);
    $ordem = (int) ($token2);
    if ($id == 0 || $ordem == 0) {
        header("location: /index.php");
    }

    $situacao = 0;

    $finProtocoloModel = new FinProtocoloModel();
    $finProtocoloModel->setIdOrdem($ordem);
    $dados = [];
    $dados = $finProtocoloModel->inforLoadProtocolo();
    var_dump($dados);

// $finProtocoloModel = new FinProtocoloModel();
// $finProtocoloModel->setIdOrdem($ordem);
// $protocolo = $finProtocoloModel->retornaIdProtocoloPorOrdem();
// 
// $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
// $finEntregaConfirmacaoModel->setIdEntregaConfirmacao($id);
// $situacao = 0;
// $situacao = $finEntregaConfirmacaoModel->verificaSerAEntregaTotal(null);
}



