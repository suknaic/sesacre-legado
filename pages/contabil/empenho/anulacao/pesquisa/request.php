<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/empenho/EmpenhoAnulacaoPesquisa.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'retornaAnulacoesEmpenho':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
            $empenhoAnulacaoPesquisa = new EmpenhoAnulacaoPesquisa();
            $empenhoAnulacaoPesquisa->setAnoEmpenhoAnulacao($dados['ano_empenho_anulacao'])
                            ->setNrEmpenho($dados['nr_empenho'])
                            ->setNrEmpenhoAnulacao($dados['nr_empenho_anulacao'])
                            ->setIdFornecedor($dados['fornecedor'])
                            ->setNrContrato($dados['nr_contrato'])
                            ->setNrPedido($dados['nr_pedido'])
                            ->setTipoGasto($dados['tipo_gasto'])
                            ->setSituacao($dados['situacao'])
                            ->setCentralDemanda($dados['central_demanda']);
            echo $empenhoAnulacaoPesquisa->retornaAnulacoes();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
    
    CASE 'retornaOptionsEmpenhoAnulacaoSituacoes':
        try {
            $empenhoAnulacaoPesquisa = new EmpenhoAnulacaoPesquisa();
            echo $empenhoAnulacaoPesquisa->retornaOptionsEmpenhoAnulacaoSituacoes();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

}
