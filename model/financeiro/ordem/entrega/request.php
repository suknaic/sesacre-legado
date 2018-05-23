<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinProtocoloModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'salvaProtocolo':
        try {
            $protocolo = filter_input(INPUT_POST, 'protocolo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finProtocoloModel = new FinProtocoloModel();
            $finProtocoloModel->setIdOrdem($protocolo["ordem"]);
            $finProtocoloModel->setNmRepresentante($protocolo["nomeRepresentante"]);
            $finProtocoloModel->setNrRgCpf($protocolo["rgCpf"]);
            $finProtocoloModel->setNmEmailRepresentante($protocolo["email"]);
            $finProtocoloModel->setDhRecebimentoSistema($protocolo["dataRecebimento"]);
            $finProtocoloModel->setQdEntrega($protocolo["quantidade"]);
            $finProtocoloModel->setDsProtocolo($protocolo["obsProtocolo"]);
            $finProtocoloModel->setIdPessoa($session->getIdUser());
            echo $finProtocoloModel->salvaProtocolo();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'listaEntregas':
        try {
            
            $protocolo = filter_input(INPUT_GET, 'idOrdem', FILTER_DEFAULT);
            $finProtocoloModel = new FinProtocoloModel();
            $finProtocoloModel->setIdOrdem($protocolo);
            echo json_encode($finProtocoloModel->retornaEntregaConfirmacao());
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

