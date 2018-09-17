<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocFiscalRecebimento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocVincRecebimento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocTramitacao.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'retornaDocumentosFiscais':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $prog = new DocFiscalRecebimento();

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
                    ->setDestinatario((int) $dados['destinatario']);
            echo $prog->listaTodos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'cadastrarRecebimento':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT);
            $prog = new DocFiscalRecebimento();
            $prog->setIdUsuario($session->getIdUser());
            $prog->setIdDocumentoFiscal((int)$dados);
            echo $prog->cadastrarRecebimento();
        
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}