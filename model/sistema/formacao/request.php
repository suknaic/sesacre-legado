<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/formacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/escolaridade/Escolaridade.class.php";

$session = new Session('ajax');

if (!$session->verificaPermissao(PERFIL_TI)) {
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {

    case 'cadastrarFormacao':
        try {

            $formacao = filter_input(INPUT_POST, 'formacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $sesFormacao = new Formacao();
            $sesFormacao->setNm_formacao(trim($formacao['nome']));
            $sesFormacao->setId_escolaridade((int)($formacao['escolaridade']));
            echo $sesFormacao->cadastrarFormacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'editarFormacao':
        try {

            $formacao = filter_input(INPUT_POST, 'formacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $sesFormacao = new Formacao();
            $sesFormacao->setNm_formacao(trim($formacao['nome']));
            $sesFormacao->setId_escolaridade((int)($formacao['escolaridade']));
            $sesFormacao->setId_formacao((int) $formacao['id']);
            echo $sesFormacao->editarFormacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }


    case 'removerFormacao':
        try {

            $formacao = filter_input(INPUT_POST, 'formacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $sesFormacao = new Formacao();
            $sesFormacao->setId_formacao((int) $formacao['id']);
            echo $sesFormacao->removerFormacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'desativarFormacao':
        try {

            $formacao = filter_input(INPUT_POST, 'formacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $sesFormacao = new Formacao();
            $sesFormacao->setId_formacao((int) $formacao['id']);
            echo $sesFormacao->desativarFormacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'ativarFormacao':
        try {

            $formacao = filter_input(INPUT_POST, 'formacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $sesFormacao = new Formacao();
            $sesFormacao->setId_formacao((int) $formacao['id']);
            echo $sesFormacao->ativarFormacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaFormacaoTable':
        try {
            $nome = isset($_POST['nome']) ? filter_input(INPUT_POST, 'nome', FILTER_DEFAULT) : NULL;
            $escolaridade = isset($_POST['escolaridade']) ? filter_input(INPUT_POST, 'escolaridade', FILTER_DEFAULT) : NULL;
            //***************************
            $formacao = new Formacao();
            echo $formacao->retornaTrFormacao($nome, $escolaridade);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaEscolaridadeOption':
        try {
            $prog = new Escolaridade();
            echo $prog->retornaOptionEscolaridade();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
?>
