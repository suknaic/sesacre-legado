<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocFiscalPesquisa.class.php";

$session = new Session('ajax');


switch ($_REQUEST['acao']) {

    CASE 'retornaLiquidacoes':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
            
//            $prog = new DocFiscalPesquisa();
//            
//            $prog->setNrDocFiscal($dados['nrDocFis'])
//                 ->setAnoDocFiscal((int)$dados['anoDocFis'])
//                 ->setContratado((int)$dados['contratado'])
//                 ->setNrProtocolo((int)$dados['nrProtocolo'])
//                 ->setNrContrato($dados['nrContrato'])
//                 ->setNrPedido($dados['nrPedido'])
//                 ->setNrEmpenho($dados['nrEmpenho'])
//                 ->setTpGasto((int)$dados['tpGasto'])
//                 ->setSitDocFiscal((int)$dados['sitDoc'])
//                 ->setTramitacao((int)$dados["tramitacao"])   
//                 ->setDestinatario((int)$dados['destinatario']);
//            
//            echo $prog->listaTodos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}