<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoPesquisa.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/Liquidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoDoc.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoHistorico.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinDocumentoFiscal.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";

$session = new Session('ajax');


switch ($_REQUEST['acao']) {

    CASE 'retornaOptionsSituacaoLiquidacao':
        try {
            
            $liquidacao = new LiquidacaoPesquisa();
            echo $liquidacao->retornaOptionsSituacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'retornaLiquidacoes':
        $dados = filter_input(INPUT_GET,'dados',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        try {
            $liquidacao = new LiquidacaoPesquisa();
            $liquidacao->setNrLiquidacao($dados['nrLiq'])
                       ->setAnoLiquidacao($dados['exercicio'])
                       ->setContratado($dados['fornecedor'])
                       ->setNrPedido($dados['pedido'])
                       ->setNrEmpenho($dados['empenho'])
                       ->setNrContrato($dados['contrato'])
                       ->setNrDocumentoFiscal($dados['nrDoc'])
                       ->setTipoGasto($dados['tpGasto'])
                       ->setSituacao($dados['situacao'])
                       ->setUsuario($session->getIdUser());
            echo $liquidacao->retornaLiquidacoes();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'cancelarLiquidacao':
        $dados = filter_input(INPUT_POST,'dados',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        
        try {
            $liquidacao = new Liquidacao();
            $liquidacao->setIdLiquidacao($dados['id'])
                       ->setUsuario($session->getIdUser())
                       ->setMotivoCancelamento($dados['justificativa']);
            echo $liquidacao->cancelarLiquidacao();
            return;
            break;
            
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }


}