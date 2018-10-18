<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoaJuridica/PessoaJuridica.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pais/Pais.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/cidade/Cidade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/estado/Estado.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/escolaridade/Escolaridade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vinculo/Vinculo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/cargo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/funcao.class.php";
$session = new Session('ajax');

if (!$session->vPRh() && !$session->vPFinanceiro()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {

    case 'cadastrarPessoaFisica':
        try {

            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $dadosPessoa = filter_input(INPUT_POST, 'dadosPessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //*****************
            $dadosPessoaFisica = filter_input(INPUT_POST, 'dadosPessoaFisica', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $dadosCompetencia = filter_input(INPUT_POST, 'dadosCompetencia', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //********************valida cpf e email*****************************
            if (!filter_var(trim($dadosPessoa['email']), FILTER_VALIDATE_EMAIL)) {
                echo Metodos::retornoAjax("Erro", "alert", "O Email Digitado é considerado Inválido");
                return;
            }
            $validaCpf = Metodos::validaCPF(trim($dadosPessoaFisica['cpf']));
            if (!$validaCpf) {
                echo Metodos::retornoAjax("Erro", "alert", "CPF inválido, tente com outro número de CPF");
                return;
            }

            //*********************************************************************************************************************
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //**************************************Pessoa**************************************************************************
            $pessoa = new Pessoa();
            $telefoneRes = Metodos::removeMascaraCel_Tel($dadosPessoa['telefone_residencial']);
            $telefoneCel = Metodos::removeMascaraCel_Tel($dadosPessoa['telefone_celular']);
            $pessoa->setNm_email(trim($dadosPessoa['email']));
            $pessoa->setDs_bairro(trim($dadosPessoa['bairro']));
            $pessoa->setDs_complemento(trim($dadosPessoa['complemento']));
            $pessoa->setDs_logradouro(trim($dadosPessoa['logradouro']));
            $pessoa->setDs_observacao(trim($dadosPessoa['obs']));
            $pessoa->setId_cidade($dadosPessoa['cidade']);
            $pessoa->setId_naturalidade($dadosPessoa['naturalidade']);
            $pessoa->setNm_pessoa(trim($dadosPessoa['nomeSocial'] === '' ? $dadosPessoaFisica['nomeCivil'] : $dadosPessoa['nomeSocial']));
            $pessoa->setNm_senha(trim($dadosPessoa['senha']));
            $pessoa->setNr_cep($dadosPessoa['cep']);
            $pessoa->setNr_elefone_residencial($telefoneRes);
            $pessoa->setNr_telefone_celular($telefoneCel);
            //********************************
            $pessoa->cadastrarPessoa($pdo);
            if ($pessoa->getSuccess()) {
                $idPessoa = $pessoa->getId_pessoa();
            } else {
                echo Metodos::retornoAjax("Erro", "alert", $pessoa->getMsg());
                return;
            }
            //**************************** Pessoa Fisica********************************************************************
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->setId_pessoa($idPessoa);
            $pessoaFisica->setTp_sexo(trim($dadosPessoaFisica['tpSexo']));
            $pessoaFisica->setNm_civil(trim($dadosPessoaFisica['nomeCivil']));
            $pessoaFisica->setNr_cpf(trim($dadosPessoaFisica['cpf']));
            $pessoaFisica->setNr_rg(trim($dadosPessoaFisica['rg']));
            $pessoaFisica->setDs_orgao_expedidor(trim(strtoupper($dadosPessoaFisica['orgaoExpedidor'])));
            $pessoaFisica->setDs_habilidade(trim($dadosPessoaFisica['habilidade']));
            $pessoaFisica->setId_estado_expedidor(($dadosPessoaFisica['orgaoExpedidorEst']));
            $pessoaFisica->setId_estado_civil(($dadosPessoaFisica['estadoCivil']));
            $pessoaFisica->setNm_pai(trim($dadosPessoaFisica['pai']));
            $pessoaFisica->setNm_mae(trim($dadosPessoaFisica['mae']));
            $pessoaFisica->setDt_nascimento(($dadosPessoaFisica['dtNascimento']));
            $pessoaFisica->setNr_cns(trim($dadosPessoaFisica['cns']));
            $pessoaFisica->setId_escolaridade_formacao(($dadosPessoaFisica['escolaridade']));
            $pessoaFisica->cadastrarPessoaFisica($pdo);
            if (!$pessoaFisica->getSuccess()) {
                echo Metodos::retornoAjax("Erro", "alert", $pessoaFisica->getMsg());
                return;
            }
            //********************************Competencias****************************************************************
            if (count($dadosCompetencia) > 0) {
                foreach ($dadosCompetencia as $linha => $v) {
                    $pessoaFisica->setId_escolaridade_formacao_competencia($v['id_escolaridade_formacao']);
                    $rs = $pessoaFisica->cadastrarCompetencia($pdo);
                    if ($rs != "Sucesso") {
                        $pdo->rollBack();
                        echo Metodos::retornoAjax("Erro", "alert", $rs);
                        return;
                    }
                }
            }
            if ($pessoaFisica->getSuccess()) {
                $pdo->commit();
                echo Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                return;
            } else {
                echo Metodos::retornoAjax("Erro", "alert", STR_ERROR);
                return;
            }
//          **********************************************************************************************************************
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'editarPessoaFisica':
        try {
            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $dadosPessoa = filter_input(INPUT_POST, 'dadosPessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //*****************
            $dadosPessoaFisica = filter_input(INPUT_POST, 'dadosPessoaFisica', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            //********************valida cpf e email*****************************
            if (!filter_var(trim($dadosPessoa['email']), FILTER_VALIDATE_EMAIL)) {
                echo Metodos::retornoAjax("Erro", "alert", "O Email Digitado é considerado Inválido");
                return;
            }
            $validaCpf = Metodos::validaCPF(trim($dadosPessoaFisica['cpf']));
            if (!$validaCpf) {
                echo Metodos::retornoAjax("Erro", "alert", "CPF inválido, tente com outro número de CPF");
                return;
            }
            //*********************************************************************************************************************
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //**************************** Pessoa ********************************************************************
            $telefoneRes = Metodos::removeMascaraCel_Tel($dadosPessoa['telefone_residencial']);
            $telefoneCel = Metodos::removeMascaraCel_Tel($dadosPessoa['telefone_celular']);
            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($dadosPessoa['idPessoa']);
            $pessoa->setNm_email(trim($dadosPessoa['email']));
            $pessoa->setDs_bairro(trim($dadosPessoa['bairro']));
            $pessoa->setDs_complemento(trim($dadosPessoa['complemento']));
            $pessoa->setDs_logradouro(trim($dadosPessoa['logradouro']));
            $pessoa->setDs_observacao(trim($dadosPessoa['obs']));
            $pessoa->setId_cidade($dadosPessoa['cidade']);
            $pessoa->setId_naturalidade($dadosPessoa['naturalidade']);
            $pessoa->setNm_pessoa(trim($dadosPessoa['nomeSocial'] === '' ? $dadosPessoaFisica['nomeCivil'] : $dadosPessoa['nomeSocial']));
            $pessoa->setNr_cep($dadosPessoa['cep']);
            $pessoa->setNr_elefone_residencial($telefoneRes);
            $pessoa->setNr_telefone_celular($telefoneCel);
            //********************************
            $pessoa->editarPessoa($pdo);
            //********************************
            if ($pessoa->getSuccess()) {
                $idPessoa = $pessoa->getId_pessoa();
            } else {
                echo Metodos::retornoAjax("Erro", "alert", $pessoa->getMsg());
                return;
            }
            //**************************** Pessoa Fisica********************************************************************
            $pessoaFisica = new pessoaFisica();
            //**************************************************************************************************************
            $pessoaFisica->setId_pessoa($dadosPessoa['idPessoa']);
            $pessoaFisica->setId_pessoa_fisica($dadosPessoaFisica['idPessoaFisica']);
            $pessoaFisica->setTp_sexo(trim($dadosPessoaFisica['tpSexo']));
            $pessoaFisica->setNm_civil(trim($dadosPessoaFisica['nomeCivil']));
            $pessoaFisica->setNr_cpf(trim($dadosPessoaFisica['cpf']));
            $pessoaFisica->setNr_rg(trim($dadosPessoaFisica['rg']));
            $pessoaFisica->setDs_orgao_expedidor(trim(strtoupper($dadosPessoaFisica['orgaoExpedidor'])));
            $pessoaFisica->setDs_habilidade(trim($dadosPessoaFisica['habilidade']));
            $pessoaFisica->setId_estado_expedidor(($dadosPessoaFisica['orgaoExpedidorEst']));
            $pessoaFisica->setId_estado_civil(($dadosPessoaFisica['estadoCivil']));
            $pessoaFisica->setNm_pai(trim($dadosPessoaFisica['pai']));
            $pessoaFisica->setNm_mae(trim($dadosPessoaFisica['mae']));
            $pessoaFisica->setDt_nascimento(($dadosPessoaFisica['dtNascimento']));
            $pessoaFisica->setNr_cns(trim($dadosPessoaFisica['cns']));
            $pessoaFisica->setId_escolaridade_formacao(($dadosPessoaFisica['escolaridade']));
            //******************************************
            $pessoaFisica->editarPessoaFisica($pdo);
            
            // print_r($pessoaFisica);
            //return;
            //******************************************

            if ($pessoaFisica->getSuccess()) {
                $pdo->commit();
                echo Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                return;
            } else {
                $pdo->rollBack();
                echo Metodos::retornoAjax("Erro", "alert", $pessoaFisica->getMsg());
                return;
            }
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
            //************************************************
            if ((explode("-", $get['idPessoa'])[0]) == '2') {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                $pessoa = new Pessoa();
                $st_ativo = '';
                if (explode("-", $get['idPessoa'])[3] == '0') {
                    $st_ativo = '1';
                }
                if (explode("-", $get['idPessoa'])[3] == '1') {
                    $st_ativo = '0';
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
                    echo Metodos::retornoAjax("ok", "html", "Realizado Com Sucesso");
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
    case 'removerPessoaFisica':
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
                echo $pessoaFisica->removerPessoaFisica();
            }
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

    case 'pesquisaPessoaFisica':
        try {
            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $pessoa = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            print_r($pessoa);
            return;
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

}
?>
