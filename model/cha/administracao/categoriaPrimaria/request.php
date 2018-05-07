<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/class/cha/administracao/categoriaPrimaria/CategoriaPrimaria.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
$session = new Session('ajax');

if (!$session->vPRh()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    case 'cadastrarCategoriaPrimaria':
        try {
            $dados = filter_input(INPUT_GET, 'caPrimaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaPrimaria();
            $classe->setNmCategoriaPrimaria($dados['nmCaPrimaria']);
            $classe->setIdCategoriaTipo($dados['idCaTipo']);

            $classe->cadastrarCategoriaPrimaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'editarCategoriaPrimaria':
        try {
            $dados = filter_input(INPUT_GET, 'caPrimaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaPrimaria();
            $classe->setIdCategoriaPrimaria($dados['idCategoriaPrimaria']);
            $classe->setNmCategoriaPrimaria($dados['nmCategoriaPrimaria']);
            $classe->setIdCategoriaTipo($dados['idCategoriaTipo']);

            $classe->editarCategoriaPrimaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'listarCategoriaPrimaria':
        try {
            $classe = new CategoriaPrimaria();

            $classe->listarCategoriaPrimaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'desativarCategoriaPrimaria':
        try {
            $dados = filter_input(INPUT_GET, 'caPrimaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaPrimaria();

            $classe->setIdCategoriaPrimaria($dados['idCategoriaPrimaria']);
            $classe->setNmCategoriaPrimaria($dados['nmCategoriaPrimaria']);
            $classe->setIdCategoriaTipo($dados['idCategoriaTipo']);

            $classe->desativarCategoriaPrimaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'ativarCategoriaPrimaria':
        try {
            $dados = filter_input(INPUT_GET, 'caPrimaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaPrimaria();

            $classe->setIdCategoriaPrimaria($dados['idCategoriaPrimaria']);
            $classe->setNmCategoriaPrimaria($dados['nmCategoriaPrimaria']);
            $classe->setIdCategoriaTipo($dados['idCategoriaTipo']);

            $classe->ativarCategoriaPrimaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'removerCategoriaPrimaria':
        try {
            $dados = filter_input(INPUT_GET, 'caPrimaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaPrimaria();

            $classe->setIdCategoriaPrimaria($dados['idCategoriaPrimaria']);
            $classe->setNmCategoriaPrimaria($dados['nmCategoriaPrimaria']);
            $classe->setIdCategoriaTipo($dados['idCategoriaTipo']);

            $classe->removerCategoriaPrimaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'listarCategoriaTipo':
        try {
            $dados = filter_input(INPUT_GET, 'caPrimaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaPrimaria();
            $classe->listarCategoriaTipo();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
}
