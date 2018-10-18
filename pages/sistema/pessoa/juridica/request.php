<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoaJuridica/PessoaJuridica.class.php";
$session = new Session('ajax');

if (!$session->vPRh() && !$session->vPFinanceiro()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {

    case 'removerPessoaJuridica':
        try {

            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }

            $get = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            if ((explode("-", $get['idPessoa'])[0]) == '2') {
                $pessoaJuridica = new pessoaJuridica();
                $pessoaJuridica->setId_pessoa((int) explode("-", $get['idPessoa'])[1]);
                $pessoaJuridica->setId_pessoa_juridica((int) explode("-", $get['idPessoa'])[2]);
                echo $pessoaJuridica->removerPessoaJuridica();
            }

            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'pesquisaPessoaJuridica':
        try {
            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $pessoa = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $nome = isset($pessoa['nome']) ? $pessoa['nome'] : NULL;
            $cpf = isset($pessoa['cnpj']) ? $pessoa['cnpj'] : NULL;

            $pessoaFisica = new pessoaJuridica();
            echo $pessoaFisica->retornaTrPessoaJuridica($nome, $cpf);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'desativaAtivaPessoa':
        try {

            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $get = filter_input(INPUT_GET, 'pessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            if ((explode("-", $get['idPessoa'])[0]) == '2') {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                $pessoa = new Pessoa();
                $st_ativo = '';
                $retorno = '';
                if (explode("-", $get['idPessoa'])[3] == '0') {
                    $st_ativo = '1';
                    $retorno = Metodos::retornoAjax("ok", "html", STR_ATIVADO_SUCESSO);
                }
                if (explode("-", $get['idPessoa'])[3] == '1') {
                    $st_ativo = '0';
                    $retorno = Metodos::retornoAjax("ok", "html", STR_DESATIVADO_SUCESSO);
                }
                $pessoa->setId_pessoa((int) explode("-", $get['idPessoa'])[1]);
                $pessoa->setSt_ativo($st_ativo);
                $pessoa->mudarStatusPessoa($pdo);
                if (!$pessoa->getSuccess()) {
                    $pdo->rollBack();
                    echo Metodos::retornoAjax("Erro", "console", $rs);
                    return;
                }
                if ($pessoa->getSuccess()) {
                    $pdo->commit();
                    echo $retorno;
                    return;
                } else {
                    $pdo->rollBack();
                    echo Metodos::retornoAjax("Erro", "alert", $pessoa->getMsg());
                    return;
                }
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
