<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemAdministracaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemAdministracaoAnotacaoModel.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'retornaItensEntrega':
        try {
            $dados = filter_input(INPUT_GET, 'ordem', FILTER_DEFAULT);
            $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
            $finEntregaConfirmacaoModel->setIdOrdem($dados);
            echo json_encode($finEntregaConfirmacaoModel->retornaItensCadEntrega());
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaTipoRemetenteERemetente':
        try {
            $vincTramitacao = new VincularTramitacao();
            $vincTramitacao->setIdPessoa($session->getIdUser());
            echo $vincTramitacao->listaLotacaoTipoPorUsuarioReativacaoOrdem();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'cadastraReativacao':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finOrdemAdministracaoModel = new FinOrdemAdministracaoModel();
            $finOrdemAdministracaoModel->setIdOrdem($dados["id_ordem"]);
            $finOrdemAdministracaoModel->setIdProtocolo($dados["id_protocolo"]);
            $finOrdemAdministracaoModel->setIdSolicitante($session->getIdUser());
            $finOrdemAdministracaoModel->setIdLotacaoSolicitante($dados["id_remetente"]);
            $finOrdemAdministracaoModel->setDsOrdemAdministracaoAnotacao($dados["anotacoes"]);
            echo $finOrdemAdministracaoModel->reativacaoOrdem();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

