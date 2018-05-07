<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/cha/administracao/categoriaPrincipal/CategoriaPrincipal.class.php";

$session = new Session('ajax');

if (!$session->verificaPermissao(PERFIL_TI)) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {

    case 'cadPrincipal':
        try {
            $get = filter_input(INPUT_GET, 'principal', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $prin = new Principal();
            $prin->setNmCategoriaPrincipal(trim($get['nome']));
            
            echo $prin->cadastrarPrincipal();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'edtPrincipal':
        try {
            $get = filter_input(INPUT_GET, 'principal', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $prin = new Principal();
            $prin->setNmCategoriaPrincipal(trim($get['nome']));
            $prin->setIdCategoriaPrincipal((int) $get['id']);
            
            echo $prin->editarPrincipal();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }


    case 'remPrincipal':
        try {
            $get = filter_input(INPUT_GET, 'principal', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $prin = new Principal();
            $prin->setIdCategoriaPrincipal((int) $get['id']);
            
            echo $prin->removerPrincipal();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'desPrincipal':
        try {
            $get = filter_input(INPUT_GET, 'principal', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $prin = new Principal();
            $prin->setIdCategoriaPrincipal((int) $get['id']);
            
            echo $prin->desativarPrincipal();
            return;
            break;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
            break;
        }

    case 'atiPrincipal':
        try {
            $get = filter_input(INPUT_GET, 'principal', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $prin = new Principal();
            $prin->setIdCategoriaPrincipal((int) $get['id']);
            
            echo $prin->ativarPrincipal();
            return;
            break;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
            break;
        }

    case 'listaPrincipalTable':
        try {
            $prin = new Principal();
            $prin->retornaTrPrincipal();

            echo $prin->getMsgRetorno();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
?>
