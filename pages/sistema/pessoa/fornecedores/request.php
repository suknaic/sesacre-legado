<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
$session = new Session('ajax');

if (!$session->vPRh() && !$session->vPFinanceiro()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {

    case 'removerPessoaFisica':
        try {

            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }

            $get = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            if ((explode("-", $get['idPessoa'])[0]) == '1') {
                $pessoaFisica = new pessoaFisica();
                $pessoaFisica->setId_pessoa((int) explode("-", $get['idPessoa'])[1]);
                $pessoaFisica->setId_pessoa_fisica((int) explode("-", $get['idPessoa'])[2]);
                echo $pessoaFisica->removerPessoaFisica();
            }

            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'pesquisaPessoaFisica':
        try {
            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $pessoa = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $nome = isset($pessoa['nome']) ? $pessoa['nome'] : NULL;
            $cpf = isset($pessoa['cpf']) ? $pessoa['cpf'] : NULL;

            $pessoaFisica = new pessoaFisica();
            echo $pessoaFisica->retornaTrPessoaFisica($nome, $cpf);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'desativarPessoa':
        try {

            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $get = filter_input(INPUT_GET, 'pessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            if ((explode("-", $get['idPessoa'])[0]) == '1') {
                $pessoaFisica = new pessoaFisica();
                $pessoaFisica->setId_pessoa((int) explode("-", $get['idPessoa'])[1]);
                $pessoaFisica->setId_pessoa_fisica((int) explode("-", $get['idPessoa'])[2]);
                $pessoaFisica->setSt_ativo((int) explode("-", $get['idPessoa'])[3]);
                echo $pessoaFisica->mudarStatusPessoaFisica();
            }
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}
?>
