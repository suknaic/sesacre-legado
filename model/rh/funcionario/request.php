<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/cidade/Cidade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/estado/Estado.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pais/Pais.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/escolaridade/Escolaridade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vinculo/Vinculo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/cargo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/funcao.class.php";
$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    case 'cadastrarContrato':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $dadosPessoa = filter_input(INPUT_POST, 'dadosPessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //******************************************************************************************************************
            $dadosPessoaFisica = filter_input(INPUT_POST, 'dadosPessoaFisica', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $dadosCompetencia = filter_input(INPUT_POST, 'dadosCompetencia', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //******************************************************************************************************************
            $dadosContrato = filter_input(INPUT_POST, 'dadosContrato', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $dadosContratoLotacao = filter_input(INPUT_POST, 'dadosContrato_Lotacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //***************************************************************
            if (!filter_var(trim($dadosPessoa['email']), FILTER_VALIDATE_EMAIL)) {
                echo Metodos::retornoAjax("Erro", "alert", "Informe seu E-mail Institucional do domínio ac.gov.br.");
                return;
            }
            $validaCpf = Metodos::validaCPF(trim($dadosPessoaFisica['cpf']));
            if (!$validaCpf) {
                echo Metodos::retornoAjax("Erro", "alert", "CPF inválido, tente com outro número de CPF.");
                return;
            }
            //*************************************************
            $contrato = new Contrato();
            echo $contrato->cadastrarContrato($dadosPessoa, $dadosPessoaFisica, $dadosCompetencia, $dadosContrato, $dadosContratoLotacao);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'editarContrato':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }

            $dadosPessoa = filter_input(INPUT_POST, 'dadosPessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //******************************************************************************************************************
            $dadosPessoaFisica = filter_input(INPUT_POST, 'dadosPessoaFisica', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //******************************************************************************************************************
            $dadosContrato = filter_input(INPUT_POST, 'dadosContrato', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $dadosContratoLotacao = filter_input(INPUT_POST, 'dadosContrato_Lotacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //***************************************************************
            if (!filter_var(trim($dadosPessoa['email']), FILTER_VALIDATE_EMAIL)) {
                echo Metodos::retornoAjax("Erro", "alert", "Informe seu E-mail Institucional do domínio ac.gov.br.");
                return;
            }
            $validaCpf = Metodos::validaCPF(trim($dadosPessoaFisica['cpf']));
            if (!$validaCpf) {
                echo Metodos::retornoAjax("Erro", "alert", "CPF inválido, tente com outro número de CPF.");
                return;
            }

            $contrato = new Contrato();
            echo $contrato->editarContrato($dadosPessoa, $dadosPessoaFisica, $dadosContrato, $dadosContratoLotacao);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornaPessoaFisica':
        try {

            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }

            $cpf = $_REQUEST['cpf'];
            $contrato = new Contrato();
            echo $contrato->retornaPessoaFisica($cpf);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornaFuncionarioNome':
        try {

            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }

            $nome = $_REQUEST['nome'];

            $contrato = new Contrato();
            echo $contrato->retornaTrPessoaFisica($nome, NULL, NULL, NULL, NULL, TRUE);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'returnContratoEditar':
        try {

            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $idGet = filter_input(INPUT_POST, 'id_get', FILTER_DEFAULT);
            $contrato = new Contrato();
            echo $contrato->retornaContrato($idGet);
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
            }
            $dadosPessoa = filter_input(INPUT_POST, 'dadosPessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->retornaCompetencia($dadosPessoa);

            //return;
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
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->setId_escolaridade_formacao_competencia($_REQUEST['competencia']);
            $pessoaFisica->setId_pessoa_fisica($_REQUEST['pessoaFisica']);
            echo $pessoaFisica->cadastrarCompetencia($pdo, $_REQUEST['escolaridade']);
            return;
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
            }
            $idCompetencia = $_REQUEST['idCompetencia'];
            $pessoaFisica = new pessoaFisica();
            $pessoaFisica->removerCompetencia($idCompetencia);

            //return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'inserirContratoLotacao':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $dadosContratoLotacao = filter_input(INPUT_GET, 'dadosContratoLotacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $contratoLotacao = new Contrato();
            $contratoLotacao->cadastrarContratoLotacao($dadosContratoLotacao);
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'atualizarContratoLotacao':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $dadosContratoLotacao = filter_input(INPUT_GET, 'dadosContratoLotacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //*********************************
            $contratoLotacao = new Contrato();
            echo $contratoLotacao->editarContratoLotacao($dadosContratoLotacao);
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'atualizarContratoHistorico':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $dadosContratoLHistorico = filter_input(INPUT_GET, 'dadosContratoHistorico', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            //*********************************
            $contratoHistorico = new Contrato();
            echo $contratoHistorico->editarContratoHistorico($dadosContratoLHistorico);
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'removerContrato':
        try {

            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $get = filter_input(INPUT_POST, 'pessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
//            print_r($get);
//            return;
            $contrato = new Contrato();
            $contrato->setId_contrato((int) $get['idContrato']);
            echo $contrato->removerContrato();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'redefinirSenha':
        try {

            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
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
    case 'returnLotacaoFuncao':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $idContrato = $_REQUEST['idContrato'];
            $pessoaFisica = new Contrato();
            $pessoaFisica->retornaLotacaoFuncao($idContrato);

            //return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'cadastraSituacao':
        try {

            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $dadosSituacao = filter_input(INPUT_GET, 'dadosSituacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $contrato = new Contrato();
            echo $contrato->cadastraSituacao($dadosSituacao);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'returnHistorico':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $idContrato = $_REQUEST['idContrato'];
            $pessoaFisica = new Contrato();
            $pessoaFisica->retornaHistorico($idContrato);

            //return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'buscaCidadeUf':
        try {
            $uf = filter_input(INPUT_POST, 'uf', FILTER_DEFAULT);
            $cidade = new Cidade();

            echo $cidade->retornaCidadeUf($uf);

            //return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'excluirContratoHistorico':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $idContratoHistorico = $_REQUEST['idContratoHistorico'];
            $contrato = new Contrato();
            echo $contrato->removerContratoHistorico($idContratoHistorico);

            //return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'excluirContratoLotacao':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $idContratoLotacao = $_REQUEST['idContratoLotacao'];
            $contrato = new Contrato();
            echo $contrato->removerContratoLotacao($idContratoLotacao);

            //return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaPessoaFisicaTable':
        try {

            $nome = isset($_POST['nome']) ? filter_input(INPUT_POST, 'nome', FILTER_DEFAULT) : NULL;
            $cpf = isset($_POST['cpf']) ? filter_input(INPUT_POST, 'cpf', FILTER_DEFAULT) : NULL;
            $matricula = isset($_POST['matricula']) ? filter_input(INPUT_POST, 'matricula', FILTER_DEFAULT) : NULL;
            $vinculo = isset($_POST['vinculo']) ? filter_input(INPUT_POST, 'vinculo', FILTER_DEFAULT) : NULL;
            $lotacao = isset($_POST['lotacao']) ? filter_input(INPUT_POST, 'lotacao', FILTER_DEFAULT) : NULL;

            $contrato = new Contrato();
            echo $contrato->retornaTrPessoaFisica($nome, $cpf, $matricula, $vinculo, $lotacao, false);
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
            echo $prog->retornaOptionCidade($idEstado, $idCidade);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaCidadeOptionUf':
        try {
            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $idEstado = filter_input(INPUT_POST, 'idEstado', FILTER_DEFAULT);
            $uf = filter_input(INPUT_POST, 'uf', FILTER_DEFAULT);
            $cidade = new Cidade();
            echo $cidade->retornaOptionCidadeUf($idEstado, $uf);

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

            echo "<option value = '0'>Selecione um estado</option>";
            echo $prog->retornaOptionEstado($idPais, $idEstado);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listaPaisOption':
        try {
            $pais = new Pais();
            echo $pais->retornaOptionPaises();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listaSituacaoOption':
        try {
            $id = $_REQUEST['id'];
//            print_r($id);
            
            $prog = new Contrato();
            
            echo $prog->retornaOptionSituacao($id);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
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
    case 'listaPessoaJuridicaOption':
        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
            $pj = new pessoaFisica();

            echo $pj->retornaOptionPj($id);
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
        }

    case 'listaCargoOption':
        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
            $prog = new Cargo();
            echo $prog->retornaOptionCargo($id);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listaFuncaoOption':
        try {
            $prog = new Funcao();
            echo $prog->retornaOptionFuncao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listaVinculoOption':
        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
            $prog = new Vinculo();
            echo $prog->retornaOptionVinculo($id);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listaLotacaoOption':
        try {
            $prog = new Lotacao();
            echo $prog->retornaOptionLotacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'aniversario':
        try {
            $func = new pessoaFisica();
            $idPessoaFisica = $_SESSION['idUser'];
            $data = new DateTime();
            $data = $data->format('m-d');
            $func->setId_pessoa_fisica((int)$idPessoaFisica);
            $func->setDt_nascimento(trim($data));
            echo $func->retornaAniversario();

            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}
?>
