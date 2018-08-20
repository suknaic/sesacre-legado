<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocFiscalEncaminhamento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocVincRecebimento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocTramitacao.class.php";

$session = new Session('ajax');


switch ($_REQUEST['acao']) {

    CASE 'retornaDocumentosFiscais':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $prog = new DocFiscalEncaminhamento();

            $prog->setNrDocFiscal($dados['nrDocFis'])
                    ->setAnoDocFiscal((int) $dados['anoDocFis'])
                    ->setContratado((int) $dados['contratado'])
                    ->setNrProtocolo((int) $dados['nrProtocolo'])
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
            echo $prog->cadastrarEncaminhamento($dados);
        
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}