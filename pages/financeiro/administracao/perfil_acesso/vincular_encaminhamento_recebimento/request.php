<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocLotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocVincEncaminhamento.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocVincRecebimento.class.php";

$session = new Session('ajax');


switch ($_REQUEST['acao']) {

    CASE 'retornaDocVincTramitacoes':
        try {
            $prog = new DocVincRecebimento();
//            $prog2 = new DocVincEncaminhamento();
            echo $prog->listaTodos();
//            echo $prog2->listaTodos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
    CASE 'retornaLotacoes':
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $prog = new DocLotacao();
            $prog->setIdDocTipoLotacao((int) $filtro);
            echo $prog->optionsLotacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'salvarDocVincTramitacao':
        try {
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            if ($filtro['tpTramitacao'] == '1') {
                $prog = new DocVincEncaminhamento();
                $prog->setIdDocLotacao($filtro['idDocLotacao'])
                        ->setIdPessoa($filtro['idPessoa']);

                echo $prog->cadastrar();
            } else {
                $prog = new DocVincRecebimento();
                $prog->setIdDocLotacao($filtro['idDocLotacao'])
                        ->setIdPessoa($filtro['idPessoa']);

                echo $prog->cadastrar();
            }


            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'removerDocVincTramitacao':
        try {

            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            if ($filtro['tipo'] == '1') { //Encaminhar
                $prog = new DocVincEncaminhamento();

                $prog->setIdDocVincEncaminhamento((int) $filtro['id']);

                echo $prog->excluir();
            } else {                      //Receber
                $prog = new DocVincRecebimento();

                $prog->setIdDocVincRecebimento((int) $filtro['id']);

                echo $prog->excluir();
            }

            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}
