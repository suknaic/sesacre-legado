<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/class/cha/administracao/categoriaTipo/CategoriaTipo.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
$session = new Session('ajax');

if (!$session->vPRh()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    case 'cadastrarCategoriaTipo':
        try {
            $dados = filter_input(INPUT_GET, 'caTipo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaTipo();
            $classe->setNmCategoriaTipo($dados['nmCaTipo']);
            $classe->setIdCategoriaPrincipal($dados['idCatipo']);

            $classe->cadastrarCategoriaTipo();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'editarCategoriaTipo':
        try {
            $dados = filter_input(INPUT_GET, 'caTipo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaTipo();
            $classe->setIdCategoriaTipo($dados['idCategoriaTipo']);
            $classe->setNmCategoriaTipo($dados['nmCategoriaTipo']);
            $classe->setIdCategoriaPrincipal($dados['idCategoriaPrincipal']);

            $classe->editarCategoriaTipo();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'listarCategoriaTipo':
        try {
            $classe = new CategoriaTipo();

            $classe->listarCategoriaTipo();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'desativarCategoriaTipo':
        try {
            $dados = filter_input(INPUT_GET, 'caTipo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaTipo();

            $classe->setIdCategoriaTipo($dados['idCategoriaTipo']);
            $classe->setNmCategoriaTipo($dados['nmCategoriaTipo']);
            $classe->setIdCategoriaPrincipal($dados['idCategoriaPrincipal']);

            $classe->desativarCategoriaTipo();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'ativarCategoriaTipo':
        try {
            $dados = filter_input(INPUT_GET, 'caTipo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaTipo();

            $classe->setIdCategoriaTipo($dados['idCategoriaTipo']);
            $classe->setNmCategoriaTipo($dados['nmCategoriaTipo']);
            $classe->setIdCategoriaPrincipal($dados['idCategoriaPrincipal']);

            $classe->ativarCategoriaTipo();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'removerCategoriaTipo':
        try {
            $dados = filter_input(INPUT_GET, 'caTipo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaTipo();

            $classe->setIdCategoriaTipo($dados['idCategoriaTipo']);
            $classe->setNmCategoriaTipo($dados['nmCategoriaTipo']);
            $classe->setIdCategoriaPrincipal($dados['idCategoriaPrincipal']);

            $classe->removerCategoriaTipo();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'listarCategoriaPrincipal':
        try {
            $dados = filter_input(INPUT_GET, 'caTipo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new CategoriaTipo();
            $classe->listarCategoriaPrincipal();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
        
        case 'listaTiposTable':
        try {
        
            $est = new CategoriaTipo();            
            echo $est->listarCategoriaTipo();
           // echo 'teste';
            return;
            
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        case 'SelectPrincipaisOpt':
        try {
        
            $est = new CategoriaTipo();            
            echo $est->retornaOptionPrincipais();
           // echo 'teste';
            return;
            
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}
