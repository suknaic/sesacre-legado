<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocFiscalEncaminhamento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocVincEncaminhamento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocTramitacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinDocumentoFiscal.class.php";


$session = new Session('ajax');


switch ($_REQUEST['acao']) {

    CASE 'retornaDocumentosFiscais':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $prog = new DocFiscalEncaminhamento();

            $prog->setNrDocFiscal($dados['nrDocFis'])
                    ->setAnoDocFiscal((int) $dados['anoDocFis'])
                    ->setContratado((int) $dados['contratado'])
                    ->setNrProtocolo($dados['nrProtocolo'])
                    ->setNrContrato($dados['nrContrato'])
                    ->setNrPedido($dados['nrPedido'])
                    ->setNrEmpenho($dados['nrEmpenho'])
                    ->setTpGasto((int) $dados['tpGasto'])
                    ->setSitDocFiscal((int) $dados['sitDoc'])
                    ->setIdUsuario($session->getIdUser())
                    ->setRemetente((int) $dados['remetente']);
            echo $prog->listaTodos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }


    CASE 'retornaDestinatarioPorTipo':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $prog = new DocFiscalEncaminhamento();
            echo $prog->retornaDestinatiroPorTipo($dados);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'cadastrarEncaminhamento':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $prog = new DocFiscalEncaminhamento();
            $prog->setIdUsuario($session->getIdUser());
            $prog->setIdDocumentoFiscal($dados['id']);
            echo $prog->cadastrarEncaminhamento($dados);
        
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    case 'removerDocumentoFiscal':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $doc = new FinDocumentoFiscal();
            $doc->setIdDocumentoFiscal((int)$dados['id']);
            $doc->setIdPessoa($session->getIdUser());
            $doc->setDsObservacao(trim($dados['justificativa']));
            echo $doc->removerDocumentoFiscal();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}