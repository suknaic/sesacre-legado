<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinOrdemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/ordem/FinEntregaConfirmacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/Liquidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoDoc.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoHistorico.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoAnotacao.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinDocumentoFiscal.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vincular_tramitacao/VincularTramitacao.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/empenho/EmpenhoAnulacao.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/preOrdem/PreOrdem.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";




$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'retornaEmpenho':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $finEmpenhoModel = new FinEmpenhoModel();
            $finEmpenhoModel->setNrEmpenho($dados);
            echo $finEmpenhoModel->trEmpenhoBuscaLiquidacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }


    CASE 'retornaContratosLiquidacao':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $finContratoModel = new FinContratoModel();
            echo $finContratoModel->retornaContratoGdof(null, $dados["nr_pedido"]);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaPedidoLiquidacao':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pedido = new Pedido();
            $pedido->setNrPedido($dados["nr_pedido"]);
            echo $pedido->retornaPedidoGdof(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaEmpenhoAnulacao':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pedido = new Pedido();
            $pedido->setNrPedido($dados);
            $finEmpenhoModel = new FinEmpenhoModel();
            $finEmpenhoModel->setIdPedido($dados["id_pedido"]);
            echo $finEmpenhoModel->retornaEmpenhoAnulacao(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'retornaItensPedido':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
            $finOrdem = new FinOrdemModel();
            $finOrdem->setIdPedido((int)$dados['id_pedido']);
            echo $finOrdem->retornaItensParaAnulacaoEmpenho();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }      



    CASE 'cadastrarAnulacao':
        try {
            $dados = filter_input(INPUT_POST,'dados',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            if (empty($dados['itens'])) {
                $dados['itens'] = array();
            }                                              
            
            $perfilTI = false;
            if($session->vPGeralAcao()){
                $perfilTI = true;
            }
            
//            echo "<pre>";
//            print_r($dados);
//            echo "</pre>";
//            return;
            $empenho = new EmpenhoAnulacao();
            $empenho->setIdEmpenho((int)$dados['idEmpenho'])
                        ->setIdPessoa($session->getIdUser())
                        ->setVlAnulacao($dados['vlAnulacao'])
                        ->setDsEmpenhoAnulacaoAnotacao(trim($dados['anotacoes']))
                        ->setItens($dados['itens'])
                        ->setDsJustificativa(trim($dados['justificativa']));                       
            $empenho->setIdDocTipoLotacao((int)$dados['idDocTipoLotacao']);
            $empenho->setIdLotacao((int)$dados['idLotacao']);
            $empenho->setVlEmpenhoSaldo($dados['saldo_empenho']);
            echo $empenho->salvarAnulacao($perfilTI);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'buscaEmpenho':
        try {
            $dados = filter_input(INPUT_GET, 'empenho', FILTER_DEFAULT);
            $finEmpenhoModel = new FinEmpenhoModel();
            $finEmpenhoModel->setNrEmpenho($dados);
            echo $finEmpenhoModel->buscaEmpenhoParaLiquidacao();
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
            echo $vincTramitacao->listaLotacaoTipoPorUsuarioAnulacaoEmpenho();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }


}

