<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/pagamento/ConPagamentoAnotacoes.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'salvaAnotacao':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $conPagamentoAnotacoes = new ConPagamentoAnotacoes();
            $conPagamentoAnotacoes->setIdPessoa($session->getIdUser());
            $conPagamentoAnotacoes->setIdPagamento($dados["id_pagamento"]);
            $conPagamentoAnotacoes->setDsPagamentoAnotacao($dados["anotacao"]);
            $conPagamentoAnotacoes->salvaAnotacaoPagamento(null);
            if($conPagamentoAnotacoes->Sucesso()){
                echo Metodos::retornoAjax("ok", "html", "Anotação salva com sucesso.");
            }else{
                echo Metodos::retornoAjax("Erro", "alert", "Erro ao salva a Anotação.");
            }
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

//    CASE 'listaAnotacoes':
//        try {
//            $dados = filter_input(INPUT_POST, 'documento_fiscal', FILTER_DEFAULT);
//            $finDocumentoFiscalAnotacao = new FinDocumentoFiscalAnotacao();
//            $finDocumentoFiscalAnotacao->setIdDocumentoFiscal($dados);
//            echo $finDocumentoFiscalAnotacao->retornaAnotacao();
//            return;
//            break;
//        } catch (Error $e) {
//            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
//            return;
//            break;
//        }
}

