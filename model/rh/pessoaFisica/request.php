<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
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

    case 'cadPessoaFisica':
        try {


            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
//            $dadosPessoa = filter_input(INPUT_GET, 'dadosPessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
//            //*****************
//            $dadosPessoaFisica = filter_input(INPUT_GET, 'dadosPessoaFisica', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
//            $dadosCompetencia = filter_input(INPUT_GET, 'dadosCompetencia', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
//            //****************
//            $dadosContrato = filter_input(INPUT_GET, 'dadosContrato', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
//            $dadosContratoLotacao = filter_input(INPUT_GET, 'dadosContrato_Lotacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
//            
////            print_r($dadosPessoaFisica);
////            return;
//            //**************************************Pessoa**************************************************************************
//            $pessoa = new Pessoa(); 
//            $pessoa->setNm_email(trim($dadosPessoa['email']));
//            $pessoa->setDs_bairro(trim($dadosPessoa['bairro']));
//            $pessoa->setDs_complemento(trim($dadosPessoa['complemento']));
//            $pessoa->setDs_logradouro(trim($dadosPessoa['logradouro']));
//            $pessoa->setDs_observacao(trim($dadosPessoa['obs']));
//            $pessoa->setId_cidade($dadosPessoa['cidade']);
//            $pessoa->setId_naturalidade($dadosPessoa['naturalidade']);
//            $pessoa->setNm_pessoa(trim($dadosPessoa['nomeCivil']));
//            $pessoa->setNm_senha(trim($dadosPessoa['senha']));
//            $pessoa->setNr_cep($dadosPessoa['cep']);
//            $pessoa->setNr_elefone_residencial($dadosPessoa['telefone_residencial']);
//            $pessoa->setNr_telefone_celular($dadosPessoa['telefone_celular']);
////            print_r($pessoa);
////            return;
//            echo $pessoa->cadastrarPessoa();
            //**********************************************************************************************************************
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'edtPpaProg':
        try {
//            if(!$session->vPPlanejamentoAcao()){
//                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
//                return;
//            }
//            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
//            
//            $prog = new PpaProg();             
//            $prog->setIdPpaProg((int)$get['id']);
//            $prog->setNmPpaProg(trim($get['nome']));
//            $prog->setAaInicio((int)$get['dt_inicio']);
//            $prog->setAaFim((int)$get['dt_fim']);            
//            $prog->setCdPpaProg(trim($get['codigo']));
//            echo $prog->editarPpaProg();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }


    case 'remPessoaFisica':
        try {
            
            if(!$session->vPRh()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
            $get = filter_input(INPUT_GET, 'pessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pessoaFisica = new pessoaFisica();             
            $pessoaFisica->setId_pessoa_fisica((int)$get['idPessoaFisica']);
            $pessoaFisica->setId_pessoa((int)$get['idPessoa']);
            $pessoaFisica->setSt_ativo('0');
            echo $pessoaFisica->mudarStatusPessoaFisica();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

//    case 'listaPessoaFisicaTable':
//        try {
//            $nome = $_REQUEST['nome'];
//            $cpf = $_REQUEST['cpf'];
//            $matricula = $_REQUEST['matricula'];
//            $vinculo = $_REQUEST['vinculo'];
//            $lotacao = $_REQUEST['lotacao'];
//            
//            $pessoaFisica = new pessoaFisica();
//            echo $pessoaFisica->retornaTrPessoaFisica($nome, $cpf, $matricula, $vinculo, $lotacao);
//            return;
//            break;
//        } catch (Exception $e) {
//            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
//            return;
//            break;
//        }
    case 'retornaPessoaFisica':
        try {
            //falta
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
            echo $prog->retornaOptionCidade();
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
            echo $prog->retornaOptionEstado();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listaEstadoCivilOption':
        try {
            $prog = new pessoaFisica();
            echo $prog->retornaOptionEc();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listaPessoaJuridicaOption':
        try {
            $prog = new pessoaFisica();
            echo $prog->retornaOptionPj();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
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
    case 'listaVinculoOption':
        try {
            $prog = new Vinculo();
            echo $prog->retornaOptionVinculo();
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
        }
    case 'listaCargoOption':
        try {
            $prog = new Cargo();
            echo $prog->retornaOptionCargo();
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
}
?>
