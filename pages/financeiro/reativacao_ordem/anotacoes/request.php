<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemAdministracaoAnotacaoModel.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {


    CASE 'salvaAnotacao':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finOrdemAdministracaoAnotacaoModel = new FinOrdemAdministracaoAnotacaoModel();
            $finOrdemAdministracaoAnotacaoModel->setIdOrdemAdministracao($dados["id_ordem_administracao"]);
            $finOrdemAdministracaoAnotacaoModel->setDsOrdemAdministracaoAnotacao($dados["anotacao"]);
            $finOrdemAdministracaoAnotacaoModel->setIdPessoa($session->getIdUser());
            $finOrdemAdministracaoAnotacaoModel->cadastrarAnotacao(null);
            if ($finOrdemAdministracaoAnotacaoModel->Sucesso()) {
                echo Metodos::retornoAjax("ok", "html", "Anotação salva com sucesso.");
            } else {
                echo Metodos::retornoAjax("Erro", "alert", "Erro ao salva a Anotação.");
            }

            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'listaAnotacoes':
        try {
            $dados = filter_input(INPUT_GET, 'id_ordem_administracao', FILTER_DEFAULT);
            $finOrdemAdministracaoAnotacaoModel = new FinOrdemAdministracaoAnotacaoModel();
            $finOrdemAdministracaoAnotacaoModel->setIdOrdemAdministracao($dados);
            echo $finOrdemAdministracaoAnotacaoModel->retornaAnotacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

