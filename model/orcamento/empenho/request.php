<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";

$session = new Session('ajax');



switch ($_REQUEST['acao']) {

    case 'retornaEmpenhos':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finEmpenhoModel = new FinEmpenhoModel();
            echo $finEmpenhoModel->retornaTrPedidoEmpenho($get);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'tpEmpenho':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finEmpenhoModel = new FinEmpenhoModel();
            if (!empty($get)) {
                $finEmpenhoModel->setIdEmpenho($get['idEmpenho']);
            }
            echo $finEmpenhoModel->retornaOptionsTipoEmpenho();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'salvaEmpenho':
        try {
            $get = filter_input(INPUT_GET, 'empenho', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finEmpenhoModel = new FinEmpenhoModel();
            $finEmpenhoModel->setIdPedido($get["pedido"]);
            $finEmpenhoModel->setIdPessoa($_SESSION["idUser"]);
            $finEmpenhoModel->setIdTipoEmpenho($get["tpEmpenho"]);
            $finEmpenhoModel->setNrEmpenho($get["nrEmpenho"]);
            $finEmpenhoModel->setDtEmpenhoSafira($get["dtEmpenho"]);
            $finEmpenhoModel->setVlEmpenho($get["vlEmpenho"]);
            $finEmpenhoModel->setDsEmpenho($get["obsEmpenho"]);
            echo $finEmpenhoModel->salvaEmpenho();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}
