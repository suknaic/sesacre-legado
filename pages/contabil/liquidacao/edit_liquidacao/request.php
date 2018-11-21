<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/Liquidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoDoc.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/liquidacao/LiquidacaoHistorico.class.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinDocumentoFiscal.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    CASE 'atualizaLiquidacao':
        try {
            $dados = filter_input(INPUT_POST,'dados',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            if (empty($dados['docsLiquidacao'])) {
                $dados['docsLiquidacao'] = array();
            }
            
            $liquidacao = new Liquidacao();
            $liquidacao->setIdLiquidacao($dados['idLiquidacao'])
                       ->setUsuario($session->getIdUser())
                       ->setNrLiquidacao($dados['nrLiquidacao'])
                       ->setVlLiquidacao($dados['vlLiquidacao'])
                       ->setDtLiquidacao($dados['dtLiquidacao'])
                        ->setTipoSolicitacao($dados['tipoSolicitacao'])
                       ->setQtdDocumentosDisponiveis($dados['qtdDocumentos'])
                       ->setDocumentos($dados['docsLiquidacao']);
            echo $liquidacao->alterarLiquidacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}