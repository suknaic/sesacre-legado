<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinDocumentoFiscal.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinEntregaDocumento.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'retornaPedido':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $pedido = new Pedido();
            $pedido->setNrPedido($dados);
            echo $pedido->retornaPedidoComOrdemGdof(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaContratosGdof':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finContratoModel = new FinContratoModel();
            echo $finContratoModel->retornaContratoGdof(null, $dados["nr_pedido"]);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaPedidoGdof':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pedido = new Pedido();
            $pedido->setNrPedido($dados["nr_pedido"]);
            echo $pedido->retornaPedidoGdof(null, $dados);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaEmpenhoGdof':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pedido = new Pedido();
            $pedido->setNrPedido($dados);
            $finEmpenhoModel = new FinEmpenhoModel();
            $finEmpenhoModel->setIdPedido($dados["id_pedido"]);
            echo $finEmpenhoModel->retornaEmpenhoGdof(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaOrdemGdof':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finOrdemModel = new FinOrdemModel();
            $finOrdemModel->setIdPedido($dados["id_pedido"]);
            echo $finOrdemModel->retornaOrdemGdof();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaTipoValorOrdem':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $finOrdemModel = new FinOrdemModel();
            $finOrdemModel->setIdOrdem($dados);
            echo $finOrdemModel->retornaTipoValorOrdem();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaTabelaOrdem':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finOrdemModel = new FinOrdemModel();
            echo $finOrdemModel->montaTabelaOrdemGdof($dados);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }  

    CASE 'retornaTabelaEntrega':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
            echo $finEntregaConfirmacaoModel->retornaTabelaEntregasGdof($dados);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'cadastrarDocumentoFiscal':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $entrega = filter_input(INPUT_POST, 'entrega', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
           
            $finDocumentoFiscal = new FinDocumentoFiscal();
            $finDocumentoFiscal->setNrProcessoAdministrativo($dados["processoAdm"]);
            $finDocumentoFiscal->setNrDocumentoFiscal($dados["nr_documento"]);
            $finDocumentoFiscal->setIdTipoDocumento($dados["tpDocumento"]);
            $finDocumentoFiscal->setCompetencia($dados["competencia"]);
            $finDocumentoFiscal->setDtAtesto($dados["atesto"]);
            $finDocumentoFiscal->setDtEmissao($dados["emissao"]);
            $finDocumentoFiscal->setVlDocumento($dados["valorDocumentoFiscal"]);
            $finDocumentoFiscal->setFlGrp($dados["grp"]);
            $finDocumentoFiscal->setNrGrpNumero($dados["grpNumero"]);
            $finDocumentoFiscal->setEntrega($entrega);
            echo $finDocumentoFiscal->salvaDocumentoFiscal();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

