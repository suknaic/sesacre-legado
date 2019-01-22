<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PessoaFisica.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/cidade/Cidade.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/estado/Estado.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/escolaridade/Escolaridade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
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
    case 'listaVinculoOption':
        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
            $vinculo = new Vinculo();
            echo $vinculo->retornaOptionVinculo($id);
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
    case 'pesquisaGrafico1':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            if (!empty($dados['dt_inicio']) && !empty($dados['dt_fim'])) {
                //*********************** Valida a data de início ********************
                $dtInicio = explode('/', $dados['dt_inicio']);
                $d = $dtInicio[0];
                $m = $dtInicio[1];
                $y = $dtInicio[2];
                if (!checkdate($m, $d, $y)) {
                    echo('A data início informada é inválida.');
                    return;
                    break;
                }
                //********************************************************************

                //*********************** Valida a data de fim ********************
                $dtFim = explode('/', $dados['dt_fim']);
                $d = $dtFim[0];
                $m = $dtFim[1];
                $y = $dtFim[2];
                if (!checkdate($m, $d, $y)) {
                    echo('A data final informada é inválida.');
                    return;
                    break;
                }
                //********************************************************************
            }

            $todos = $dados['todos'];
            $dataInicio = strtotime(date(str_replace('/', '-', $dados['dt_inicio'])));
            $dataFim = strtotime(date(str_replace('/', '-', $dados['dt_fim'])));
            $dataAtual = strtotime(date('d-m-Y'));

            if ($dataInicio > $dataAtual && $dataFim > $dataAtual) {
                echo 'maior';
                return;
                break;
            }

            //**************************************
            $banco = new Contrato();
            echo $banco->pesquisaGrafico($dados['dt_inicio'], $dados['dt_fim'], $todos, 1, 0, 0);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'pesquisaGrafico2':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $todos = $dados['todos'];
            $dataInicio = $dados['dt_inicio'];
            $dataFim = $dados['dt_fim'];
            $idVinculo = $dados['idVinculo'];
            //**************************************

            if (!empty($dataInicio) && !empty($dataFim)) {
                //*********************** Valida a data de início ********************
                $dtInicio = explode('/', $dataInicio);
                $d = $dtInicio[0];
                $m = $dtInicio[1];
                $y = $dtInicio[2];
                if (!checkdate($m, $d, $y)) {
                    echo('A data início informada é inválida.');
                    return;
                    break;
                }
                //********************************************************************

                //*********************** Valida a data de fim ********************
                $dtFim = explode('/', $dataFim);
                $d = $dtFim[0];
                $m = $dtFim[1];
                $y = $dtFim[2];
                if (!checkdate($m, $d, $y)) {
                    echo('A data fim informada é inválida.');
                    return;
                    break;
                }
                //********************************************************************
            }

            $banco = new Contrato();
            echo $banco->pesquisaGrafico($dataInicio, $dataFim, $todos, 2, $idVinculo, 0);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'pesquisaGraficoFuncionario':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $todos = $dados['todos'];
            $dataInicio = $dados['dt_inicio'];
            $dataFim = $dados['dt_fim'];
            $idVinculo = $dados['idVinculo'];
            $idLotacao = $dados['idLotacao'];
            //**************************************

            if (!empty($dataInicio) && !empty($dataFim)) {
                //*********************** Valida a data de início ********************
                $dtInicio = explode('/', $dataInicio);
                $d = $dtInicio[0];
                $m = $dtInicio[1];
                $y = $dtInicio[2];
                if (!checkdate($m, $d, $y)) {
                    echo('A data início informada é inválida.');
                    return;
                    break;
                }
                //********************************************************************

                //*********************** Valida a data de fim ********************
                $dtFim = explode('/', $dataFim);
                $d = $dtFim[0];
                $m = $dtFim[1];
                $y = $dtFim[2];
                if (!checkdate($m, $d, $y)) {
                    echo('A data fim informada é inválida.');
                    return;
                    break;
                }
                //********************************************************************
            }

            $banco = new Contrato();
            echo $banco->pesquisaGrafico($dataInicio, $dataFim, $todos, 3, $idVinculo, $idLotacao);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listaAnoSituacaoOption':
        try {
            $id = filter_input(INPUT_POST, 'id', FILTER_DEFAULT);
            $prog = new Contrato();
            echo $prog->retornaOptionAnoSituacao($id);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
?>
