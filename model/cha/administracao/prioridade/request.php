<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/class/cha/administracao/prioridade/Prioridade.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
$session = new Session('ajax');

if (!$session->vPRh()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    case 'cadastrarPrioridade':
        try {
            $dados = filter_input(INPUT_GET, 'prioridade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new Prioridade();
            $classe->setNmPrioridade($dados['prioridade']);
            $classe->setCsPrioridade($dados['classificacao']);

            $classe->cadastrarPrioridade();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'editarPrioridade':
        try {
            $dados = filter_input(INPUT_GET, 'prioridade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new Prioridade();
            $classe->setIdPrioridade($dados['idPrioridade']);
            $classe->setNmPrioridade($dados['nmPrioridade']);
            $classe->setCsPrioridade($dados['csPrioridade']);
            $verifica = $dados['veriNmPrioridade'];

            $classe->editarPrioridade($verifica);
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'listarPrioridade':
        try {
            $classe = new Prioridade();

            $classe->listarPrioridades();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'desativarPrioridade':
        try {
            $dados = filter_input(INPUT_GET, 'prioridade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new Prioridade();
            $classe->setIdPrioridade($dados['idPrioridade']);

            $classe->desativarPrioridade();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'ativarPrioridade':
        try {
            $dados = filter_input(INPUT_GET, 'prioridade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new Prioridade();
            $classe->setIdPrioridade($dados['idPrioridade']);

            $classe->ativarPrioridade();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'removerPrioridade':
        try {
            $dados = filter_input(INPUT_GET, 'prioridade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new Prioridade();
            $classe->setIdPrioridade($dados['idPrioridade']);

            $classe->deletarPrioridade();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
}
