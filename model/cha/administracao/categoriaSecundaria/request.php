<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/class/cha/administracao/categoriaSecundaria/CategoriaSecundaria.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
$session = new Session('ajax');

if (!$session->vPRh()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    case 'cadastrarCategoriaSecundaria':
        try {
            $dados = filter_input(INPUT_GET, 'caSecundaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaSecundaria();
            $classe->setNmCategoriaSecundaria($dados['nmCaSecundaria']);
            $classe->setIdCategoriaPrimaria($dados['idCaPrimaria']);
            $classe->setVlCategoriaSecundaria($dados['vlCaSecundaria']);

            $classe->cadastrarCategoriaSecundaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'editarCategoriaSecundaria':
        try {
            $dados = filter_input(INPUT_GET, 'caSecundaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaSecundaria();
            $classe->setIdCategoriaSecundaria($dados['idCategoriaSecundaria']);
            $classe->setNmCategoriaSecundaria($dados['nmCategoriaSecundaria']);
            $classe->setVlCategoriaSecundaria($dados['vlCategoriaSecundaria']);
            $classe->setIdCategoriaPrimaria($dados['idCategoriaPrimaria']);

            $classe->editarCategoriaSecundaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'listarCategoriaSecundaria':
        try {
            $classe = new CategoriaSecundaria();

            $classe->listarCategoriaSecundaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'desativarCategoriaSecundaria':
        try {
            $dados = filter_input(INPUT_GET, 'caSecundaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaSecundaria();

            $classe->setIdCategoriaSecundaria($dados['idCategoriaSecundaria']);
            $classe->setNmCategoriaSecundaria($dados['nmCategoriaSecundaria']);
            $classe->setIdCategoriaPrimaria($dados['idCategoriaPrimaria']);
            $classe->setVlCategoriaSecundaria($dados['vlCategoriaSecundaria']);

            $classe->desativarCategoriaSecundaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'ativarCategoriaSecundaria':
        try {
            $dados = filter_input(INPUT_GET, 'caSecundaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaSecundaria();

            $classe->setIdCategoriaSecundaria($dados['idCategoriaSecundaria']);
            $classe->setNmCategoriaSecundaria($dados['nmCategoriaSecundaria']);
            $classe->setIdCategoriaPrimaria($dados['idCategoriaPrimaria']);
            $classe->setVlCategoriaSecundaria($dados['vlCategoriaSecundaria']);

            $classe->ativarCategoriaSecundaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'removerCategoriaSecundaria':
        try {
            $dados = filter_input(INPUT_GET, 'caSecundaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaSecundaria();

            $classe->setIdCategoriaSecundaria($dados['idCategoriaSecundaria']);
            $classe->setNmCategoriaSecundaria($dados['nmCategoriaSecundaria']);
            $classe->setIdCategoriaPrimaria($dados['idCategoriaPrimaria']);
            $classe->setVlCategoriaSecundaria($dados['vlCategoriaSecundaria']);

            $classe->removerCategoriaSecundaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'listarCategoriaPrimaria':
        try {
            $dados = filter_input(INPUT_GET, 'caSecundaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaSecundaria();
            $classe->listarCategoriaPrimaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
        
        case 'listarCategoriaSecundarias':
        try {
            $dados = filter_input(INPUT_GET, 'caSecundaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaSecundaria();            
            $classe->listarCategoriaSecundarias();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
}
