<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/administracao/administracao_solicitacao/AdministracaoSolicitacao.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    case 'administracaoOptions':
        try {
            $prog  = new AdministracaoSolicitacao();
            echo '<option value="0" selected>Selecione um Tipo da Administração</option>';
            echo $prog->retornaTipoAdministracaoOptions();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'solicitacaoOptions':
        try {
            $prog  = new AdministracaoSolicitacao();
            echo '<option value="0" selected>Selecione um Tipo de Solicitação</option>';
            echo $prog->retornaTipoSolicitacaoOptions();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'cadAdministracaoSolicitacao':
        try {
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $prog = new AdministracaoSolicitacao();
            $prog->setIdTipoAdministracao($filtro['administracao']);
            $prog->setIdTipoSolicitacao($filtro['solicitacao']);
            echo $prog->salvarAdministracaoSolicitacao();
            return;
            break;
                        
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'remAdministracaoSolicitacao':
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $prog = new AdministracaoSolicitacao();
            $prog->setIdAdministracaoSolicitacao((int)$filtro);
            echo $prog->excluirAdministracaoSolicitacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaAdministracaoSolicitacao':
        try {
            $prog = new AdministracaoSolicitacao();
            echo $prog->retornaListaAdministracaoSolicitacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

}

