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

if (!$session->vPRh()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {

    case 'cadastrarPessoaFisica':
        try {


            if (!$session->vPRh()) {
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
            $pessoa->setNrNumero(trim($dadosPessoa['numero']));
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
                        $pessoaFisica->getSuccess(false);
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
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $dadosPessoa = filter_input(INPUT_POST, 'dadosPessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
//            print_r($dadosPessoa);
//            return;
            //*****************
            $dadosPessoaFisica = filter_input(INPUT_POST, 'dadosPessoaFisica', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //****************
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
            $pessoa->setNrNumero($dadosPessoa['numero']);
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
            $fim = false;
            if ($pessoaFisica->getSuccess()) {
                //********************************* Busca Competencia Pessoa Fisica ************************************
                $competencias = $pessoaFisica->retornaCompetenciaPessoaFisica($dadosPessoaFisica['idPessoaFisica']);
                //******************************************************************************************************

                if ($competencias == null) {
                    //********************** Cadastra as competencias caso não possua nenhuma **************************
                    if (count($dadosCompetencia) > 0) {
                        foreach ($dadosCompetencia as $linha => $v) {
                            $pessoaFisica->setId_escolaridade_formacao_competencia($v['id_escolaridade_formacao']);
                            $cadastra = $pessoaFisica->cadastrarCompetencia($pdo, $dadosPessoaFisica['escolaridade']);
                            if ($cadastra != "Sucesso") {
                                $pdo->rollBack();
                                echo $cadastra;
                                return;
                            }
                        }
                    }
                    $fim = true;
                    //**************************************************************************************************
                } else {
                    $telaCompetancias = array();
                    foreach ($dadosCompetencia as $comp) {
                        $telaCompetancias[] = $comp['id_escolaridade_formacao'];
                    }
                    $bancoCompetencias = array();
                    foreach ($competencias as $bdComp) {
                        $bancoCompetencias[] = $bdComp['id_escolaridade_formacao'];
                    }

                    $inserir = array_diff(array_unique($telaCompetancias), $bancoCompetencias);
                    if (count($inserir) > 0) {
                        foreach ($inserir as $idEscolaridadeFormacao) {
                            $pessoaFisica->setId_escolaridade_formacao_competencia($idEscolaridadeFormacao);
                            $cadastra = $pessoaFisica->cadastrarCompetencia($pdo, $dadosPessoaFisica['escolaridade']);
                            if ($cadastra != "Sucesso") {
                                $pdo->rollBack();
                                echo $cadastra;
                                return;
                            }
                        }
                    }

                    $deletar = array_diff($bancoCompetencias, array_unique($telaCompetancias));
                    if (count($deletar) > 0) {
                        foreach ($competencias as $idEscolaridadeFormacaoBanco => $banco) {
                            foreach ($deletar as $idEscolaridadeFormacaoTela => $tela) {
                                if ($banco['id_escolaridade_formacao'] == $tela) {
                                    $remover = $pessoaFisica->removerCompetencia($banco['id_competencia']);
                                    if ($remover == 'Sucesso') {
                                        unset($competencias[$idEscolaridadeFormacaoBanco]);
                                        unset($deletar[$idEscolaridadeFormacaoTela]);
                                    }
                                }
                            }
                        }
                    }
                    $fim = true;
                }
            }

            if ($fim) {
                $pdo->commit();
                echo Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                return;
                break;
                return;
            } else {
                $pdo->rollBack();
                echo Metodos::retornoAjax("Erro", "alert", $pessoaFisica->getMsg());
                break;
                return;
            }

            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'cadastrarPessoaJuridica':
        try {

            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
            }
            $dadosPessoa = filter_input(INPUT_POST, 'dadosPessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //*****************
            $dadosPessoaJuridica = filter_input(INPUT_POST, 'dadosPessoaJuridica', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //********************valida cpf e email*************************************************
            if (!filter_var(trim($dadosPessoa['email']), FILTER_VALIDATE_EMAIL)) {
                echo Metodos::retornoAjax("Erro", "alert", "O Email Digitado é considerado Inválido");
                return;
                break;
            }
            //*********************************************************************************************************************
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //************************************** Pessoa **************************************************************************
            $pessoa = new Pessoa();
            $telefoneRes = empty($dadosPessoa['telefone_residencial']) ? null:Metodos::removeMascaraCel_Tel($dadosPessoa['telefone_residencial']);
            $telefoneCel = Metodos::removeMascaraCel_Tel($dadosPessoa['telefone_celular']);
            $pessoa->setNm_email(trim($dadosPessoa['email']));
            $pessoa->setDs_bairro(trim($dadosPessoa['bairro']));
            $pessoa->setDs_complemento(trim($dadosPessoa['complemento']));
            $pessoa->setDs_logradouro(trim($dadosPessoa['logradouro']));
            $pessoa->setDs_observacao(trim($dadosPessoa['obs']));
            $pessoa->setId_cidade($dadosPessoa['cidade']);
            $pessoa->setId_naturalidade($dadosPessoa['cidade']);
            $pessoa->setNm_pessoa(trim($dadosPessoa['razaoSocial']));
            $pessoa->setNm_senha(trim($dadosPessoa['senha']));
            $pessoa->setNr_cep($dadosPessoa['cep']);
            $pessoa->setNrNumero($dadosPessoa['numero']);
            $pessoa->setNr_elefone_residencial($telefoneRes);
            $pessoa->setNr_telefone_celular($telefoneCel);
            //********************************
            $pessoa->cadastrarPessoa($pdo);
            if ($pessoa->getSuccess()) {
                $idPessoa = $pessoa->getId_pessoa();
            } else {
                echo Metodos::retornoAjax("Erro", "alert", $pessoa->getMsg());
                return;
                break;
            }
            //**************************** Pessoa Juridica ********************************************************************
            $pessoaJuridica = new pessoaJuridica();
            $pessoaJuridica->setId_pessoa($idPessoa);
            $pessoaJuridica->setNm_fantasia(trim($dadosPessoaJuridica['nomeFantasia']));
            $pessoaJuridica->setId_natureza(($dadosPessoaJuridica['idNatureza']));
            $pessoaJuridica->setNr_cnpj(trim($dadosPessoaJuridica['cnpj']));
            $pessoaJuridica->setNr_cnae(trim(($dadosPessoaJuridica['cnae'])));
            $pessoaJuridica->setNr_safira(trim($dadosPessoaJuridica['safira']));
            $pessoaJuridica->setDs_insc_estadual(trim($dadosPessoaJuridica['inscricaoEstadual']));
            $pessoaJuridica->setDs_insc_municipal(trim($dadosPessoaJuridica['inscricaoMunicipal']));
            $pessoaJuridica->setDt_fundacao(($dadosPessoaJuridica['dtFundacao']));
            $pessoaJuridica->cadastrarPessoaJuridica($pdo);
            if (!$pessoaJuridica->getSuccess()) {
                echo Metodos::retornoAjax("Erro", "alert", $pessoaJuridica->getMsg());
                return;
                break;
            }
            //********************************Competencias****************************************************************
            if ($pessoaJuridica->getSuccess()) {
                $pdo->commit();
                echo Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                return;
                break;
            } else {
                echo Metodos::retornoAjax("Erro", "alert", $pessoaJuridica->getMsg());
                return;
                break;
            }
            //**********************************************************************************************************************

            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'editarPessoaJuridica':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
            }
            $dadosPessoa = filter_input(INPUT_POST, 'dadosPessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //*****************
            $dadosPessoaJuridica = filter_input(INPUT_POST, 'dadosPessoaJuridica', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //********************valida email*****************************
            if (!filter_var(trim($dadosPessoa['email']), FILTER_VALIDATE_EMAIL)) {
                echo Metodos::retornoAjax("Erro", "alert", "O Email Digitado é considerado Inválido");
                return;
                break;
            }
            //*********************************************************************************************************************
            $retorno = "";
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            //**************************** Pessoa ********************************************************************
            $telefoneRes = empty($dadosPessoa['telefone_residencial']) ? null:Metodos::removeMascaraCel_Tel($dadosPessoa['telefone_residencial']);
            $telefoneCel = Metodos::removeMascaraCel_Tel($dadosPessoa['telefone_celular']);
            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($dadosPessoa['idPessoa']);
            $pessoa->setNm_email(trim($dadosPessoa['email']));
            $pessoa->setDs_bairro(trim($dadosPessoa['bairro']));
            $pessoa->setDs_complemento(trim($dadosPessoa['complemento']));
            $pessoa->setDs_logradouro(trim($dadosPessoa['logradouro']));
            $pessoa->setDs_observacao(trim($dadosPessoa['obs']));
            $pessoa->setId_cidade($dadosPessoa['cidade']);
            $pessoa->setId_naturalidade($dadosPessoa['cidade']);
            $pessoa->setNm_pessoa(trim($dadosPessoa['razaoSocial'] === '' ? $dadosPessoaFisica['razaoCivil'] : $dadosPessoa['razaoSocial']));
            $pessoa->setNr_cep($dadosPessoa['cep']);
            $pessoa->setNrNumero($dadosPessoa['numero']);
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
                break;
            }
            //**************************** Pessoa Juridica ********************************************************************
            $pessoaJuridica = new pessoaJuridica();
            //**************************************************************************************************************
            $pessoaJuridica->setId_pessoa($idPessoa);
            $pessoaJuridica->setId_pessoa_juridica($dadosPessoaJuridica['idPessoaJuridica']);
            $pessoaJuridica->setNm_fantasia(trim($dadosPessoaJuridica['nomeFantasia']));
            $pessoaJuridica->setId_natureza(($dadosPessoaJuridica['idNatureza']));
            $pessoaJuridica->setNr_cnpj(trim($dadosPessoaJuridica['cnpj']));
            $pessoaJuridica->setNr_cnae(trim(($dadosPessoaJuridica['cnae'])));
            $pessoaJuridica->setNr_safira(trim($dadosPessoaJuridica['safira']));
            $pessoaJuridica->setDs_insc_estadual(trim($dadosPessoaJuridica['inscricaoEstadual']));
            $pessoaJuridica->setDs_insc_municipal(trim($dadosPessoaJuridica['inscricaoMunicipal']));
            $pessoaJuridica->setDt_fundacao(($dadosPessoaJuridica['dtFundacao']));
            //******************************************
            $pessoaJuridica->editarPessoaJuridica($pdo);
            //******************************************

            if ($pessoaJuridica->getSuccess()) {
                $pdo->commit();
                echo Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
                return;
                break;
            } else {
                echo Metodos::retornoAjax("Erro", "alert", $pessoaJuridica->getMsg());
                return;
                break;
            }
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'returnPessoaFisicaEditar':
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        try {

            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
            }
            $idGet = filter_input(INPUT_POST, 'id_get', FILTER_DEFAULT);

            $idPessoaFisica = explode("-", $idGet)[1];
            //*******************************************************************************************
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->setId_pessoa_fisica($idPessoaFisica);
            $pessoaFisica->setMsg("contrato");
            $pf = $pessoaFisica->retornaPessoaFisica($pdo);
            //*******************************************************************************************
            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($pf['id_pessoa']);
            $pessoa->setMsg("contrato");
            $p = $pessoa->retornaPessoa($pdo);
            //*******************************************************************************************
            if ($p != FALSE) {
                $retorno[] = array(
                    //***********************pessoa****************************************
                    "nm_social" => $p["nm_pessoa"],
                    "id_pais_naturalidade" => $p["id_pais_naturalidade"],
                    "id_estado_naturalidade" => $p["id_estado_naturalidade"],
                    "id_naturalidade" => $p["id_naturalidade"],
                    "ds_logradouro" => $p["ds_logradouro"],
                    "ds_complemento" => $p["ds_complemento"],
                    "ds_bairro" => $p["ds_bairro"],
                    "nr_numero" => $p["nr_numero"],
                    "nr_cep" => $p["nr_cep"],
                    "id_pais_endereco" => $p["id_pais_endereco"],
                    "id_estado_endereco" => $p["id_estado_endereco"],
                    "id_cidade" => $p["id_cidade_endereco"],
                    "nr_telefone_residencial" => $p["nr_telefone_residencial"],
                    "nr_telefone_celular" => $p["nr_telefone_celular"],
                    "nm_email" => $p["nm_email"],
                    "ds_observacao" => $p["ds_observacao"],
                    //************************pessoaFisica***************************************
                    "id_pessoa_fisica" => $pf["id_pessoa_fisica"],
                    "id_pessoa" => $pf["id_pessoa"],
                    "tp_sexo" => $pf["tp_sexo"],
                    "nm_civil" => $pf["nm_civil"],
                    "nr_cpf" => $pf["nr_cpf"],
                    "nr_rg" => $pf["nr_rg"],
                    "ds_orgao_expedidor" => $pf["ds_orgao_expedidor"],
                    "id_estado_orgao_expedidor" => $pf["id_estado_orgao_expedidor"],
                    "ds_habilidade" => $pf["ds_habilidade"],
                    "id_estado_civil" => $pf["id_estado_civil"],
                    "nm_mae" => $pf["nm_mae"],
                    "nm_pai" => $pf["nm_pai"],
                    "dt_nascimento" => $pf["dt_nascimento"] == "" ? $pf["dt_nascimento"] : date("d/m/Y", strtotime($pf["dt_nascimento"])),
                    "nr_cns" => $pf["nr_cns"],
                    "id_escolaridade" => $pf["id_escolaridade"],
                    "st_ativo" => $pf["st_ativo"],
                );
            }
            echo json_encode($retorno);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'returnPessoaJuridicaEditar':
        $conexao = new Conexao();
        $pdo = $conexao->connect();
        try {

            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
            }
            $idGet = filter_input(INPUT_POST, 'id_get', FILTER_DEFAULT);
            $idPessoaJuridica = explode("-", $idGet)[1];
            //*******************************************************************************************
            $pessoaJuridica = new pessoaJuridica();
            $pessoaJuridica->setId_pessoa_juridica($idPessoaJuridica);
            $pj = $pessoaJuridica->retornaPessoaJuridica($pdo);
            //*******************************************************************************************
            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($pj['id_pessoa']);
            $pessoa->setMsg("contrato");
            $p = $pessoa->retornaPessoa($pdo);
            //*******************************************************************************************
            $cnpj = Metodos::formataCnpj($pj["nr_cnpj"]);
            if ($p != FALSE) {
                $retorno[] = array(
                    //***********************pessoa****************************************
                    "nm_pessoa" => $p["nm_pessoa"],
                    "id_pais_naturalidade" => $p["id_pais_naturalidade"],
                    "id_estado_naturalidade" => $p["id_estado_naturalidade"],
                    "id_naturalidade" => $p["id_naturalidade"],
                    "ds_logradouro" => $p["ds_logradouro"],
                    "ds_complemento" => $p["ds_complemento"],
                    "ds_bairro" => $p["ds_bairro"],
                    "nr_cep" => $p["nr_cep"],
                    "nr_numero" => $p['nr_numero'],
                    "id_pais_endereco" => $p["id_pais_endereco"],
                    "id_estado_endereco" => $p["id_estado_endereco"],
                    "id_cidade" => $p["id_cidade_endereco"],
                    "nr_telefone_residencial" => $p["nr_telefone_residencial"],
                    "nr_telefone_celular" => $p["nr_telefone_celular"],
                    "nm_email" => $p["nm_email"],
                    "ds_observacao" => $p["ds_observacao"],
                    //************************pessoaFisica***************************************
                    "id_pessoa_juridica" => $pj["id_pessoa_juridica"],
                    "id_pessoa" => $pj["id_pessoa"],
                    "id_natureza" => $pj["id_natureza"],
                    "nm_fantasia" => $pj["nm_fantasia"],
                    "nr_cnae" => $pj["nr_cnae"],
                    "nr_safira" => $pj["nr_safira"],
                    "nr_cnpj" => $cnpj,
                    "ds_insc_estadual" => $pj["ds_insc_estadual"],
                    "ds_insc_municipal" => $pj["ds_insc_municipal"],
                    "dt_fundacao" => $pj["dt_fundacao"] == "" ? $pj["dt_fundacao"] : date("d/m/Y", strtotime($pj["dt_fundacao"])),
                );
            }
            echo json_encode($retorno);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'returnCompetencia':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
            }
            $dadosPessoa = filter_input(INPUT_POST, 'dadosPessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->retornaCompetencia($dadosPessoa);

            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'inserirCompetencia':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->setId_escolaridade_formacao_competencia($_REQUEST['competencia']);
            $pessoaFisica->setId_pessoa_fisica($_REQUEST['pessoaFisica']);
            $pessoaFisica->cadastrarCompetencia($pdo);

            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'excluirCompetencia':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
            }
            $idCompetencia = $_REQUEST['idCompetencia'];
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->removerCompetencia($idCompetencia);

            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'inativarPessoa':
        try {

            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
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
                    break;
                }
                if ($pessoa->getSuccess()) {
                    $pdo->commit();
                    echo Metodos::retornoAjax("ok", "html", "Realizado Com Sucesso");
                    return;
                    break;
                } else {
                    $pdo->rollBack();
                    echo Metodos::retornoAjax("Erro", "alert", $pessoa->getMsg());
                    return;
                    break;
                }
            }
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'removerPessoa':
        try {

            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
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

    case 'listaPessoaTable':
        try {
            
            $pessoaPost = filter_input(INPUT_POST, 'pessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $nome = isset($pessoaPost['nome']) ? $pessoaPost['nome'] : NULL;
            $tipoPessoa = isset($pessoaPost['tipoPessoa']) ? $pessoaPost['tipoPessoa'] : NULL;
            $cpf = isset($pessoaPost['cpf']) ? $pessoaPost['cpf'] : NULL;
            $cnpj = isset($pessoaPost['cnpj']) ? $pessoaPost['cnpj'] : NULL;

            if ($tipoPessoa == 1) {
                $pessoaFisica = new pessoaFisica();
                echo $pessoaFisica->retornaTrPessoaFisica($nome, $cpf);
            }
            if ($tipoPessoa == 2) {
                $pessoaJuridica = new pessoaJuridica();
                echo $pessoaJuridica->retornaTrPessoaJuridica($nome, $cnpj);
            }

            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaEstadoCivilOption':
        try {
            $prog = new pessoaFisica();
            $id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
            echo $prog->retornaOptionEc($id);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listaEscolaridadeOption':
        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
            $prog = new Escolaridade();
            echo $prog->retornaOptionEscolaridade($id);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'returnCompetencia':
        try {
            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
            }
            $idPessoaFisica = $_REQUEST['id_pessoa_fisica'];
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->retornaCompetencia($idPessoaFisica);

            //return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'inserirCompetencia':
        try {
            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->setId_escolaridade_formacao_competencia($_REQUEST['competencia']);
            $pessoaFisica->setId_pessoa_fisica($_REQUEST['pessoaFisica']);
            $pessoaFisica->cadastrarCompetencia($pdo);

            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'excluirCompetencia':
        try {
            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
            }
            $idCompetencia = $_REQUEST['idCompetencia'];
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->removerCompetencia($idCompetencia);

            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'redefinirSenha':
        try {

            if (!$session->vPRh() && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
            }
            $postPessoa = filter_input(INPUT_POST, 'pessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pessoa = new Pessoa();
            $pessoa->setId_pessoa($postPessoa['idPessoa']);
            echo $pessoa->redefinirSenha();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaCidadeOption':
        try {
            $prog = new Cidade();
            $idEstado = $_REQUEST['idEstado'];
            $idCidade = $_REQUEST['idCidade'];
            $nmCidade = $_REQUEST['nmCidade'];

            if (empty($nmCidade)) {
                echo $prog->retornaOptionCidade($idEstado, $idCidade);
            } else {
                echo $prog->retornaOptionCidadeUf($idEstado, $nmCidade);
            }
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaCidadeOptionUf':
        try {
            if (!$session->vPRh()  && !$session->vPFinanceiro()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
                break;
            }
            $idEstado = filter_input(INPUT_POST, 'idEstado', FILTER_DEFAULT);
            $uf = filter_input(INPUT_POST, 'uf', FILTER_DEFAULT);
            $cidade = new Cidade();
            echo $cidade->retornaCidadeUf($uf);

            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaEstadoOption':
        try {
            $prog = new Estado();
            $idPais = $_REQUEST['idPais'];
            $idEstado = $_REQUEST['idEstado'];

            echo $prog->retornaOptionEstado($idPais, $idEstado);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listaOrgaoExpeditor':
        try {
            $prog = new Estado();
            $idPais = $_REQUEST['idPais'] == null ? null:$_REQUEST['idPais'];
            $idEstado = $_REQUEST['idEstado'] == null ? null:$_REQUEST['idEstado'];
            $orgaoExpeditor = $_REQUEST['orgaoExpedidor'] == null ? null:$_REQUEST['orgaoExpedidor'];

            echo $prog->retornaOptionEstado($idPais, $idEstado, $orgaoExpeditor);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listaPaisOption':
        try {
            $pais = new Pais();
            $pais->setIdPais($_REQUEST['idPais'] != null ? $_REQUEST['idPais']:null);
            echo $pais->retornaOptionPaises();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listaEscolaridadeFormacaoOption':
        try {
            $prog = new Escolaridade();
            echo $prog->retornaOptionEscolaridadeFormacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listaNaturezaOption':
        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);

            $natureza = new pessoaJuridica();
            echo $natureza->retornaNatureza($id);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
?>
