<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoPesquisa.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'retornaEmpenhos':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $empenhoPesquisa = new FinEmpenhoPesquisa();
//            $empenhoPesquisa->setAnoExercicio($ano_exercicio)
//                            ->setNrEmpenho($nr_empenho)
//                            ->setFornecedor($fornecedor)
//                            ->setNrContrato($nr_contrato)
//                            ->setNrPedido($nr_pedido)
//                            ->setTipoGasto($tipo_gasto)
//                            ->setSituacao($situacao);
            echo $empenhoPesquisa->retornaEmpenhos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}