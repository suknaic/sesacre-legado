<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    CASE 'atualizaEmpenho':
        try {
        
            if(!$session->vPFinanceiro()){
                return Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
            }
        
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
            $empenho = new FinEmpenhoModel();
            $empenho->setIdEmpenho($dados['idEmpenho']);
            $empenho->setNrEmpenho($dados['nrEmpenho']);
            $empenho->setIdPedido($dados['idPedido']);
            $empenho->setIdTipoEmpenho($dados['tpEmpenho']);
            $empenho->setDtEmpenhoSafira($dados['dtEmpenho']);
            $empenho->setIdPessoa($session->getIdUser());
            $empenho->setVlEmpenho($dados['vlEmpenho']);
            $empenho->setDsEmpenho($dados['dsEmpenho']);
            echo $empenho->atualizaEmpenho();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}