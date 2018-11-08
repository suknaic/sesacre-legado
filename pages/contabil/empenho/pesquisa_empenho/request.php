<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoPesquisa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/autorizacoes/FinAutorizacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/PedidoAnotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'retornaEmpenhos':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
            $empenhoPesquisa = new FinEmpenhoPesquisa();
            $empenhoPesquisa->setAnoExercicio($dados['ano_exercicio'])
                            ->setNrEmpenho($dados['nr_empenho'])
                            ->setFornecedor($dados['fornecedor'])
                            ->setNrContrato($dados['nr_contrato'])
                            ->setNrPedido($dados['nr_pedido'])
                            ->setTipoGasto($dados['tipo_gasto'])
                            ->setSituacao($dados['situacao'])
                            ->setCentral($dados['central'])
                            ->setUsuario($session);
            echo $empenhoPesquisa->retornaEmpenhos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
                           
    CASE 'cancelarEmpenho':
        try {
        
            if(!$session->vPFinanceiro()){
                return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
            }
        
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);                        
            $empenho = new FinEmpenhoModel();
            $empenho->setIdEmpenho($dados['id']);   
            $empenho->setIdPessoa($session->getIdUser());
            echo $empenho->cancelarEmpenho(trim($dados['justificativa']));
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
}