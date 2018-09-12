<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/Liquidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoDoc.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoHistorico.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinDocumentoFiscal.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'retornaEmpenho':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $finEmpenhoModel = new FinEmpenhoModel();
            $finEmpenhoModel->setNrEmpenho($dados);
            echo $finEmpenhoModel->trEmpenhoBuscaLiquidacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }


    CASE 'retornaContratosLiquidacao':
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

    CASE 'retornaPedidoLiquidacao':
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

    CASE 'retornaEmpenhoLiquidacao':
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
        
    CASE 'retornaDocFiscaisLiquidacao':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
            $liquidacao = new Liquidacao();
            $liquidacao->setIdEmpenho($dados['id_empenho']);
            echo $liquidacao->retornaOptionsDocsEmpenho();
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
            echo $vincTramitacao->listaLotacaoTipoPorUsuario();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }



    CASE 'cadastrarLiquidacao':
        try {
            $dados = filter_input(INPUT_POST,'dados',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            if (empty($dados['docsLiquidacao'])) {
                $dados['docsLiquidacao'] = array();
            }
            
            $liquidacao = new Liquidacao();
            $liquidacao->setIdEmpenho($dados['idEmpenho'])
                       ->setUsuario($session->getIdUser())
                       ->setIdLotacao($dados['idLotacao'])
                       ->setIdDocTipoLotacao($dados['idDocTipoLotacao'])
                       ->setNrLiquidacao($dados['nrLiquidacao'])
                       ->setVlLiquidacao($dados['vlLiquidacao'])
                       ->setDtLiquidacao($dados['dtLiquidacao'])
                       ->setDsLiquidacao($dados['obsLiquidacao'])
                       ->setDocumentos($dados['docsLiquidacao']);
            echo $liquidacao->salvarLiquidacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }


}

