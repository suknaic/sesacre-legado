<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinProtocoloModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";
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

    $finProtocoloModel = new FinProtocoloModel();
    $finProtocoloModel->setIdOrdem($ordem);
    $finProtocoloModel->setIdProtocolo($id);
 
    $dados = [];
    $dados = $finProtocoloModel->inforLoadProtocolo();
    
    
    $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
    $finEntregaConfirmacaoModel->setIdOrdem($ordem);
    
    
    $classOrdem = new FinOrdemModel();
   
    $classOrdem->setIdOrdem($ordem);
    $situacao = $classOrdem->retornaValorSituacaoOrdem(null); 
  
}



