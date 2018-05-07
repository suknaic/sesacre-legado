<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Autorizacao.class.php";


$session = new Session('ajax');



switch ($_REQUEST['acao']) {

    case 'cadastrar_autorizacao':
        try {
            if (!$session->vPFinanceiro()) {
                echo "SessaoExpirada";
                return;
            }
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $autorizacao = new Autorizacao();
            $autorizacao->setTipoAutorizacao((int) $filtro['autorizacao']);
            $autorizacao->setDtIni($filtro['dt_ini']);
            $autorizacao->setDtFim($filtro['dt_fim']);
            $autorizacao->setIdPessoa((int) $filtro['pessoa']);

            if ((int) $filtro['lotacao']) {
                $autorizacao->setIdLotacao((int) $filtro['lotacao']);
            }

            echo $autorizacao->salvarAutorizacao();

            return;
            break;
        } catch (Exception $exc) {
            echo Metodos::retornoAjax("Erro", "console", $exc->getMessage());
            return;
            break;
        }

    case 'atualizar_autorizacao':
        try {
            if (!$session->vPFinanceiro()) {
                echo "SessaoExpirada";
                return;
            }
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $autorizacao = new Autorizacao();
            $autorizacao->setTipoAutorizacao((int) $filtro['autorizacao']);
            $autorizacao->setDtIni($filtro['dt_ini']);
            $autorizacao->setDtFim($filtro['dt_fim']);
            $autorizacao->setIdPessoa((int) $filtro['pessoa']);
            $autorizacao->setIdAutorizacao((int) $filtro['id']);
            if ((int) $filtro['lotacao']) {
                $autorizacao->setIdLotacao((int) $filtro['lotacao']);
            }

            echo $autorizacao->atualizaAutorizacao();

            return;
            break;
        } catch (Exception $exc) {
            echo Metodos::retornoAjax("Erro", "console", $exc->getMessage());
            return;
            break;
        }


    case 'excluir_autorizacao':
        try {
            if (!$session->vPFinanceiro()) {
                echo "SessaoExpirada";
                return;
            }
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $autorizacao = new Autorizacao();
            $autorizacao->setTipoAutorizacao($filtro['autorizacao']);
            $autorizacao->setIdAutorizacao($filtro['id']);

            echo $autorizacao->excluiAutorizacao();

            return;
            break;
        } catch (Exception $exc) {
            echo Metodos::retornoAjax("Erro", "console", $exc->getMessage());
            return;
            break;
        }


    case 'listaAutorizacoes':
        try {
            if (!$session->vPFinanceiro()) {
                echo "SessaoExpirada";
                return;
            }
            $autorizacao = new Autorizacao();
            echo $autorizacao->listaAutorizacoes();
            return;
            break;
        } catch (Exception $exc) {
            echo Metodos::retornoAjax("Erro", "console", $exc->getMessage());
            return;
            break;
        }

    case 'retornaAutorizacao':
        //Aqui busca uma autorização específica
        try {
            if (!$session->vPFinanceiro()) {
                echo "SessaoExpirada";
                return;
            }
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $autorizacao = new Autorizacao();
            $autorizacao->setTipoAutorizacao((int) $filtro['autorizacao']);
            $autorizacao->setIdAutorizacao((int) $filtro['id']);
            echo $autorizacao->retornaAutorizacao();
            return;
            break;
        } catch (Exception $exc) {
            echo Metodos::retornoAjax("Erro", "console", $exc->getMessage());
            return;
            break;
        }

    case 'listaLotacaoOption':
        try {
            if (!$session->vPFinanceiro()) {
                echo "SessaoExpirada";
                return;
            }
            $prog = new Lotacao();
            echo $prog->retornaOptionLotacao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listaContratoOption':
        try {

            $contrato = new Contrato();
            echo $contrato->retornaOptionPessoaContrato(null);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornaPedidoCentral':
        try {
            $autorizacao = new Autorizacao();
            $autorizacao->setTipoAutorizacao(11);
            $autorizacao->setIdPessoa($session->getIdUser());
            echo $autorizacao->retornaPedidoAutorizacaoCentral();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornaPedidoOrcamento':
        try {
            $autorizacao = new Autorizacao();
            $autorizacao->setTipoAutorizacao(12);
            $autorizacao->setIdPessoa($session->getIdUser());
            echo $autorizacao->retornaPedidoAutorizacaoOrcamentario();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornaPedidoFinanceiro':
        try {
            $autorizacao = new Autorizacao();
            $autorizacao->setTipoAutorizacao(13);
            $autorizacao->setIdPessoa($session->getIdUser());
            echo $autorizacao->retornaPedidoAutorizacaoFinanceiro();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornaPedidoOrdenado':
        try {
            $autorizacao = new Autorizacao();
            $autorizacao->setTipoAutorizacao(14);
            $autorizacao->setIdPessoa($session->getIdUser());
            echo $autorizacao->retornaPedidoAutorizacaoOrdenado();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}
?>
