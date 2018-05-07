<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/cha/administracao/condicao/Condicao.class.php";

$session = new Session('ajax');

if (!$session->verificaPermissao(PERFIL_TI)) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {

    case 'cadCondicao':
        try {
            $get = filter_input(INPUT_GET, 'condicao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $con = new Condicao();
            $con->setNmCondicao(trim($get['nome']));
            
            echo $con->cadastrarCondicao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'edtCondicao':
        try {
            $get = filter_input(INPUT_GET, 'condicao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $con = new Condicao();
            $con->setNmCondicao(trim($get['nome']));
            $con->setIdCondicao((int) $get['id']);
            
            echo $con->editarCondicao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }


    case 'remCondicao':
        try {
            $get = filter_input(INPUT_GET, 'condicao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $con = new Condicao();
            $con->setIdCondicao((int) $get['id']);
            
            echo $con->removerCondicao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'desCondicao':
        try {
            $get = filter_input(INPUT_GET, 'condicao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $con = new Condicao();
            $con->setIdCondicao((int) $get['id']);
            
            echo $con->desativarCondicao();
            return;
            break;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
            break;
        }

    case 'atiCondicao':
        try {
            $get = filter_input(INPUT_GET, 'condicao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $con = new Condicao();
            $con->setIdCondicao((int) $get['id']);
            
            echo $con->ativarCondicao();
            return;
            break;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
            break;
        }

    case 'listaCondicaoTable':
        try {
            $con = new Condicao();
            $con->retornaTrCondicao();

            echo $con->getMsgRetorno();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
?>
