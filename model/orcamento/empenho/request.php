<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoHistorico.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoAnotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/PedidoAnotacao.class.php";

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
            $dados = filter_input(INPUT_POST, 'empenho', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finEmpenhoModel = new FinEmpenhoModel();
            $finEmpenhoModel->setIdPedido($dados["pedido"]);
            $finEmpenhoModel->setIdPessoa($session->getIdUser());
            $finEmpenhoModel->setIdTipoEmpenho($dados["tpEmpenho"]);
            $finEmpenhoModel->setNrEmpenho($dados["nrEmpenho"]);
            $finEmpenhoModel->setDtEmpenhoSafira($dados["dtEmpenho"]);
            $finEmpenhoModel->setVlEmpenho($dados["vlEmpenho"]);
            $finEmpenhoModel->setDsEmpenho($dados["obsEmpenho"]);
            $finEmpenhoModel->setIdLotacao($dados["idLotacao"]);
            $finEmpenhoModel->setIdDocTipoLotacao($dados["idDocTipoLotacao"]);
            echo $finEmpenhoModel->salvaEmpenho();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'salvaAnotacao':
        try {
            $filtro = filter_input(INPUT_POST, 'dados',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
            $prog = new PedidoAnotacao();
            $prog->setIdPedido($filtro['pedido'])
                 ->setDsPedidoAnotacao($filtro['anotacao'])
                 ->setIdPessoa($session->getIdUser());
            
            echo $prog->salvaAnotacaoComRetornoAjax(null);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

}
