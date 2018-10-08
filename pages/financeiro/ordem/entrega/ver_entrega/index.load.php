<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";


$session = new Session();

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

$itens_entrega = '';
$dados = '';

if (empty($id)) {
    header("location: /index.php");
} else {
    
    $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
    $finEntregaConfirmacaoModel->setIdEntregaConfirmacao($id);
    
    $itens_entrega = $finEntregaConfirmacaoModel->retornaItensDaEntrega();
    $dados = $finEntregaConfirmacaoModel->retornaDadosEntregaConfirmacao();
}