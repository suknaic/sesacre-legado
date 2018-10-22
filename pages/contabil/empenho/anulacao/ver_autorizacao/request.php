<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/Liquidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoDoc.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoHistorico.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoAnotacao.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinDocumentoFiscal.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/empenho/EmpenhoAnulacao.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/preOrdem/PreOrdem.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";




$session = new Session('ajax');

switch ($_REQUEST['acao']) {


    CASE 'cadastrarAnulacao':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $empenhoAnulacao = new EmpenhoAnulacao();
            $empenhoAnulacao->setIdEmpenhoAnulacao($dados["pagamento"]);
            $empenhoAnulacao->setIdPessoa($session->getIdUser());
            $empenhoAnulacao->setIdEmpenhoAnulacaoSituacao($dados["deferir"]);
            $empenhoAnulacao->setNrAnulacao($dados['nr_anulacao']);
            $empenhoAnulacao->setDtAnulacao($dados['dt_anulacao']);
            $empenhoAnulacao->setIdLotacao($dados['idLotacao']);
            $empenhoAnulacao->setIdDocTipoLotacao($dados['idDocTipoLotacao']);
            $empenhoAnulacao->setDsJustificativa($dados["justificativa"]);
            echo $empenhoAnulacao->deferimentoDaAnulacaoEmpenho();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
    CASE 'retornaTipoRemetenteERemetente':
        try {
            $vincTramitacao = new VincularTramitacao();
            $vincTramitacao->setIdPessoa($session->getIdUser());
            echo $vincTramitacao->listaLotacaoTipoPorUsuarioAutorizacaoAnulacaoEmpenho();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

