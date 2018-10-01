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


    CASE 'retornaOrdemGdof':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $finOrdemModel = new FinOrdemModel();
            $finOrdemModel->setIdPedido($dados);
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

    CASE 'retornaOptionsDaEntrega':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
            echo $finEntregaConfirmacaoModel->retornaOptionsEntregaOrdemGdof($dados);
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
            $finEntregaDocumento = new FinEntregaDocumento();
            $finEntregaDocumento->setIdEntregaConfirmacao($dados['entrega']);
            $finEntregaDocumento->setIdDocumentoFiscal($dados['documento']);
            echo $finEntregaDocumento->retornaTabelaEntregaGdofEdicao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'editarDocumentoFiscal':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
//            $entrega = filter_input(INPUT_POST, 'entrega', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
           
            $finDocumentoFiscal = new FinDocumentoFiscal();
            $finDocumentoFiscal->setIdPessoa($session->getIdUser());
            $finDocumentoFiscal->setIdDocumentoFiscal((int)$dados['documento_fiscal']);
            $finDocumentoFiscal->setNrProcessoAdministrativo($dados["processoAdm"]);
            $finDocumentoFiscal->setNrDocumentoFiscal($dados["nr_documento"]);
            $finDocumentoFiscal->setIdTipoDocumento((int)$dados["tpDocumento"]);
            $finDocumentoFiscal->setCompetencia($dados["competencia"]);
            $finDocumentoFiscal->setDtAtesto($dados["atesto"]);
            $finDocumentoFiscal->setDtEmissao($dados["emissao"]);
            $finDocumentoFiscal->setVlDocumento($dados["valorDocumentoFiscal"]);
            $finDocumentoFiscal->setFlGrp($dados["grp"]);
            $finDocumentoFiscal->setNrGrpNumero($dados["grpNumero"]);
            $finDocumentoFiscal->setEntrega($dados['entregas']);
            $finDocumentoFiscal->setIdPedido((int)$dados['pedido']);            
            echo $finDocumentoFiscal->editaDocumentoFiscal((int)$dados['tipo_solicitacao']);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

