<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
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

//if (!$session->vPFinanceiroCentral()) {
//    echo "SessaoExpirada";
//    return;
//}

switch ($_REQUEST['acao']) {
    
        
    case 'pesquisaTipoDeSolicitacao':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            //print_r($dados);
            $todos = $dados['todos'];
            $dataInicio = $dados['dt_inicio'];
            $dataFim = $dados['dt_fim'];
            //**************************************
            $pedido = new Pedido();
            echo $pedido->listaTipoSolicitacaoQuantidadeJSON();
            return;                       
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    
    case 'pesquisaSituacaoPorTipoDeSolicitacao':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $pedido = new Pedido();
            $pedido->setIdTipoSolicitacao((int)$dados['idTipoSolicitacao']);
            echo $pedido->listaSituacaoQuantidadePorSolicitacaoJSON();
            return;
                        
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    
    case 'pesquisaCentralPorTipoDeSolicitacaoSituacao':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                                    
            $pedido = new Pedido();
            $pedido->setIdTipoSolicitacao((int)$dados['idTipoSolicitacao']);
            $pedido->setStPedido((int)$dados['idSituacao']);
            echo $pedido->listaLotacaoQuantidadePorSolicitacaoSituacaoJSON();
            return;
                        
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'pesquisaPedidos':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                                               
            $pedido = new Pedido();
            $pedido->setIdTipoSolicitacao((int)$dados['idTipoSolicitacao']);
            $pedido->setStPedido((int)$dados['idSituacao']);
            $pedido->setIdLotacao((int)$dados['idLotacao']);
            echo $pedido->retornaPorSolicitacaoSituacaoLotacaoTR();
            return;
            
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
        
    
}
?>
