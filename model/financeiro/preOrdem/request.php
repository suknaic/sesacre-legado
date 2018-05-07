<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/itens/Itens.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/ItemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/FinFornecedorModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/preOrdem/PreOrdem.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/liberacaoCentral/FinCentralLiberacaoTransModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Fonte.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/liberacaoCentral/FinCentralLiberacaoModel.class.php";
$session = new Session('ajax');


switch ($_REQUEST['acao']) {

    case 'retornaTrFornecedor':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //retorno o id do fornecedor atraves do pedido
            $finFornecedoresModel = new FinFornecedoresModel();
            $finFornecedoresModel->retornaFornecedorPeloIdPedido(null, $get['id']);
            //retorna dados do pedido
            $pedido = new Pedido();
            $pedido->setIdPedido($get['id']);
            //classe de item e responsavel por retorna os tr
            $itemModel = new ItemModel();
            $itemModel->setIdFornecedor($finFornecedoresModel->getMsgRetorno()['id_fornecedor']);
            echo $itemModel->retornaTrPedido($pedido->retornaDadosPedido()['id_despesa']);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'cadatrarItemPreOrdem':
        try {
            $get = filter_input(INPUT_POST, 'itens', FILTER_DEFAULT);
            $get = json_decode($get);
            $preOrdem = new PreOrdem();
            echo $preOrdem->cadastrarPreOrdem($get);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornaItemPreOrdem':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $preOrdem = new PreOrdem();
            $preOrdem->setIdPedido($get['id']);
            echo $preOrdem->retornaTrPreOrdemPorPedido();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornaDadosEdicao':

        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $preOrdem = new PreOrdem();
            $preOrdem->setIdContItens($get['idItem']);
            $preOrdem->setIdPedido($get['idPedido']);
            echo $preOrdem->retornaDadosPreOrdem();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'editarItemPreOrdem':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $preOrdem = new PreOrdem();
            $preOrdem->setIdPreOrdem($get['idPreOrdem']);
            $preOrdem->setIdContItens($get['idItem']);
            $preOrdem->setQtItensPre($get['qtd']);
            $preOrdem->setVlItensPre($get['valor_unitario']);
            $preOrdem->setTipoMaterial($get['tipo']);
            $preOrdem->setIdPedido($get['id']);
            echo $preOrdem->editarPreOrdem();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'removeItemPreOrdem':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $preOrdem = new PreOrdem();
            $preOrdem->setIdPreOrdem($get['idItem']);
            $preOrdem->setIdPedido($get["id"]);
            echo $preOrdem->deletaItemPreOrdem();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'finalizaPreOrdem':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $preOrdem = new PreOrdem();
            $preOrdem->setIdPedido($get['id']);
            echo $preOrdem->atualizaStatusPedidoOrdem(null);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}
