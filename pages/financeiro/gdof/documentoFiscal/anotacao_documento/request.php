<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinDocumentoFiscalAnotacao.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'salvaAnotacao':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finDocumentoFiscalAnotacao = new FinDocumentoFiscalAnotacao();
            $finDocumentoFiscalAnotacao->setIdPessoa($session->getIdUser());
            $finDocumentoFiscalAnotacao->setIdDocumentoFiscal($dados["documento_fiscal"]);
            $finDocumentoFiscalAnotacao->setDsDocumentoFiscalAnotacao($dados["anotacao"]);
            echo $finDocumentoFiscalAnotacao->salvarComRetorno();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'listaAnotacoes':
        try {
            $dados = filter_input(INPUT_POST, 'documento_fiscal', FILTER_DEFAULT);
            $finDocumentoFiscalAnotacao = new FinDocumentoFiscalAnotacao();
            $finDocumentoFiscalAnotacao->setIdDocumentoFiscal($dados);
            echo $finDocumentoFiscalAnotacao->listaAnotacoes();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

