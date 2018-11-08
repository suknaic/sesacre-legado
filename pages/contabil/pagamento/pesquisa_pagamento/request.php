<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/pagamento/ConPagamentoPesquisa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/pagamento/ConPagamento.class.php";


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
        
    CASE 'retornaPagamentos':
        $dados = filter_input(INPUT_GET,'dados',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        try {
            $pagamento =  new ConPagamentoPesquisa();
            $pagamento->setNumero_pagamento($dados["nrPagamento"]);
            $pagamento->setExecio_pagamento($dados['exercicio']);
            $pagamento->setNumero_contrato($dados['fornecedor']);
            $pagamento->setNumero_pedido($dados["pedido"]);
            $pagamento->setNumero_empenho($dados["empenho"]);
            $pagamento->setNumero_documento_fiscal($dados["nrDoc"]);
            $pagamento->setTipo_gato($dados["tpGasto"]);
            $pagamento->setSituacao($dados["situacao"]);
            echo $pagamento->retornaPagamento();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'cancelarPagamento':
        $dados = filter_input(INPUT_POST,'dados',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        
        try {
            $pagamento = new ConPagamento();
            $pagamento->setIdPagamento($dados['id']);
            $pagamento->setIdPessoa($session->getIdUser());
            $pagamento->setDsAnotacao($dados['justificativa']);
            echo $pagamento->cancelarPagamento();
            return;
            break;
            
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }


}