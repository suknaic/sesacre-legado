<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoaJuridica/PessoaJuridica.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/cidade/Cidade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/estado/Estado.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pais/Pais.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";

$session = new Session('ajax');


switch ($_REQUEST['acao']) {

    case 'cadastrarLotacao':
        try {

            $getLotacao = filter_input(INPUT_GET, 'dadosLotacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $getTelefone = filter_input(INPUT_GET, 'dadosTelefone', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $lotacao = new Lotacao();
            $lotacao->setId_pai($getLotacao['idPaiLotacao']);
            $lotacao->setNm_lotacao($getLotacao['nomeLotacao']);
            $lotacao->setId_lotacao_categoria($getLotacao['idCategoria']);
            $lotacao->setNr_cnpj($getLotacao['cnpj']);
            $lotacao->setNm_email($getLotacao['email']);
            $lotacao->setId_pessoa_juridica($getLotacao['pessoaJuridica']);
            $lotacao->setId_pessoa($getLotacao['pessoa']);
            $lotacao->setDs_logradouro($getLotacao['logradouro']);
            $lotacao->setDs_bairro($getLotacao['bairro']);
            $lotacao->setNr_cep($getLotacao['cep']);
            $lotacao->setMp_latitude($getLotacao['latitude']);
            $lotacao->setMp_longitute($getLotacao['longitude']);
            $lotacao->setId_cidade($getLotacao['cidade']);
            echo $lotacao->cadastrarLotacao($getTelefone);
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'editarLotacao':
        try {
            if (!$session->vPRh() && !$session->vPContratosTecnico()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $getLotacao = filter_input(INPUT_GET, 'dadosLotacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //$getTelefone = filter_input(INPUT_GET, 'dadosTelefone', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $lotacao = new Lotacao();
            $lotacao->setId_lotacao($getLotacao['idLotacao']);
            $lotacao->setId_pai($getLotacao['idPaiLotacao']);
            $lotacao->setNm_lotacao($getLotacao['nomeLotacao']);
            $lotacao->setId_lotacao_categoria($getLotacao['idCategoria']);
            $lotacao->setNr_cnpj($getLotacao['cnpj']);
            $lotacao->setNm_email($getLotacao['email']);
            $lotacao->setId_pessoa_juridica($getLotacao['pessoaJuridica']);
            $lotacao->setId_pessoa($getLotacao['pessoa']);
            $lotacao->setDs_logradouro($getLotacao['logradouro']);
            $lotacao->setDs_bairro($getLotacao['bairro']);
            $lotacao->setNr_cep($getLotacao['cep']);
            $lotacao->setMp_latitude($getLotacao['latitude']);
            $lotacao->setMp_longitute($getLotacao['longitude']);
            $lotacao->setId_cidade($getLotacao['cidade']);
            echo $lotacao->editarLotacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'desativarLotacao':
        try {

            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $get = filter_input(INPUT_GET, 'lotacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $lotacao = new Lotacao();
            $lotacao->setId_lotacao((int) $get['idLotacao']);
            echo $lotacao->desativarLotacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'ativarLotacao':
        try {

            if (!$session->vPRh()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $get = filter_input(INPUT_GET, 'lotacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $lotacao = new Lotacao();
            $lotacao->setId_lotacao((int) $get['idLotacao']);
            echo $lotacao->ativarLotacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'returnLotacaoEditar':
        try {
            //fazendo
            if (!$session->vPRh() && !$session->vPContratosTecnico()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }

            $idGet = $_REQUEST['id_get'];
            $lotacao = new Lotacao();
            echo $lotacao->retornaLotacao($idGet);
            return;

            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'inserirTelefones':
        try {
            if (!$session->vPRh() && !$session->vPContratosTecnico()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            //$conexao = new Conexao();
            //$pdo = $conexao->connect();
            $telefone = filter_input(INPUT_POST, 'telefone', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $lotacao = new Lotacao();
            $nr = Metodos::removeMascaraCel_Tel($telefone['telefone']);
//            print_r($nr);
//            return;
            $lotacao->setId_lotacao($telefone['idLotacao']);
            $lotacao->setNr_telefone($nr);
            $lotacao->setSt_principal($telefone['principal']);
            $lotacao->inserirTelefone();

            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'returnTelefones':
        try {
            if (!$session->vPRh() && !$session->vPContratosTecnico()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $idLotacao = $_REQUEST['idLotacao'];
            $lotacao = new Lotacao();
            $lotacao->retornaTelefones($idLotacao);

            //return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'excluirTelefone':
        try {

            if (!$session->vPRh() && !$session->vPContratosTecnico()) {
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
                return;
            }
            $telefone = new Lotacao();
            $telefone->setId_telefone((int) $_REQUEST['idTelefone']);
            echo $telefone->excluirTelefone();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaCategoriaOption':
        try {
            $id = $_REQUEST['id'];
            $prog = new Lotacao();
            echo $prog->retornaOptionCategoriaLotacao(null, $id);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaLotacaoTable':
        try {
            $nome = isset($_POST['nome']) ? filter_input(INPUT_POST, 'nome', FILTER_DEFAULT) : NULL;
            $categoria = isset($_POST['categoria']) ? filter_input(INPUT_POST, 'categoria', FILTER_DEFAULT) : NULL;
            $lotacaoPai = isset($_POST['lotacaoPai']) ? filter_input(INPUT_POST, 'lotacaoPai', FILTER_DEFAULT) : NULL;

            //***************************
            $lotacao = new Lotacao();
            echo $lotacao->retornaTrLotacao($nome, $categoria, $lotacaoPai);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaLotacaoOption':
        try {
            $id = $_REQUEST['id'];
            $prog = new Lotacao();

            echo $prog->retornaOptionLotacao(null, $id == null ? 0:$id);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
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
            if (!$session->vPRh() && !$session->vPContratosTecnico()) {
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
    case 'listaPessoaTable':
        try {

            $pessoaPost = filter_input(INPUT_POST, 'pessoa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $nome = isset($pessoaPost['nome']) ? $pessoaPost['nome'] : NULL;
            $tipoPessoa = isset($pessoaPost['tipoPessoa']) ? $pessoaPost['tipoPessoa'] : NULL;
            if ($tipoPessoa == 1) {
                $pessoaFisica = new pessoaFisica();
                echo $pessoaFisica->listaPessoaFisica($nome);
            }
            if ($tipoPessoa == 2) {
                $pessoaJuridica = new pessoaJuridica();
                echo $pessoaJuridica->listaPessoaJuridica($nome);
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
