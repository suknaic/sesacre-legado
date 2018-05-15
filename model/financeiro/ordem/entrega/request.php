<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinProtocoloModel.class.php";
$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'salvaProtocolo':
        try {
            $protocolo = filter_input(INPUT_POST, 'protocolo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            var_dump($protocolo);
            return false;
            $finProtocoloModel = new FinProtocoloModel();
            $finProtocoloModel->setIdOrdem($protocolo["ordem"]);
            $finProtocoloModel->setNmRepresentante($protocolo["nomeRepresentante"]);
            $finProtocoloModel->setNrRgCpf($protocolo["rgCpf"]);
            $finProtocoloModel->setNmEmailRepresentante($protocolo["email"]);
            $finProtocoloModel->setDhRecebimentoSistema($protocolo["dataRecebimento"]);
            $finProtocoloModel->setDsProtocolo($protocolo["obsProtocolo"]);
            echo $finProtocoloModel->salvaProtocolo();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

}

