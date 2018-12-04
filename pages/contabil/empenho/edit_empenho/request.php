<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoAnotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";

$session = new Session('ajax');

if(!$session->vPContabilEmpenho()){
    echo "SessionEXpirada";
    return;
}

switch ($_REQUEST['acao']) {
    CASE 'atualizaEmpenho':
        try {
                           
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
            $empenho = new FinEmpenhoModel();
            $empenho->setIdEmpenho($dados['idEmpenho']);
            $empenho->setNrEmpenho($dados['nrEmpenho']);
            $empenho->setIdPedido($dados['idPedido']);
            $empenho->setIdTipoEmpenho($dados['tpEmpenho']);
            $empenho->setDtEmpenhoSafira($dados['dtEmpenho']);
            $empenho->setIdPessoa($session->getIdUser());
            $empenho->setVlEmpenho($dados['vlEmpenho']);
            $empenho->setIdLotacao($dados['idLotacao']);
            $empenho->setIdDocTipoLotacao($dados['idDocTipoLotacao']);
            echo $empenho->atualizaEmpenho();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'insereAnotacao':
        try {
                       
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
            $empenhoAnotacao = new FinEmpenhoAnotacao();
            $empenhoAnotacao->setIdEmpenho($dados['idEmpenho']);
            $empenhoAnotacao->setIdPessoa($session->getIdUser());
            $empenhoAnotacao->setDsEmpenhoAnotacao($dados['anotacao']);
            echo $empenhoAnotacao->salvaAnotacaoComRetorno();
            return;
            break;
            
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

}