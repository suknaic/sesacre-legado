<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/FinFornecedorModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/ProgramaTrabalho.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/pedido/Pedido.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Despesa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/liberacaoCentral/FinCentralLiberacaoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/CentralResponsavel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    CASE 'carregaSolicitacao':
        try {
            $qddValor = new QddValor();
            echo $qddValor->retornaTipoSolicitacao();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaTipoGasto':
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $tipoGasto = new TipoGasto();
            echo "<option value = '0'>Selecione um tipo de gasto</option>";
            echo $tipoGasto->retornaOption(0, $pdo);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaOptionsAtaContrato':
        try {
            $finFornecedoresModel = new FinFornecedoresModel();
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            echo $finFornecedoresModel->optionsAtaContPorTipoGasto(null, $dados['tipo'], $dados['tipoGasto']);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaAno':
        try {
            echo '<option value="" >Selecione uma ano</option>';
            echo Metodos::retornaAnosSelect('0');
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaFonte':
        try {
            $qddValor = new QddValor();
            echo $qddValor->retornaFonteQDD();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaProgramaTrabalho':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $qddValor = new QddValor();
            $qddValor->setAno($dados['ano']);
            $qddValor->setIdFonte($dados['fonte']);
            echo $qddValor->retornaProgramaPorFonteQDD();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaDespesa':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $qddValor = new QddValor();
            $qddValor->setIdProgramaTrabalho($dados['programa']);
            $qddValor->setIdFonte($dados['fonte']);
            echo $qddValor->retornaDespesaElementoQDD();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaSubElemento':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $despesa = new Despesa();
            $despesa->setIdDespesa($dados['despesa']);
            echo $despesa->retornaOptionsSubElemento();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'cadastrarPedido':
        try {

            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pedido = new Pedido();
            $pedido->setAno($dados['ano']);
            $pedido->setIdTipoSolicitacao($dados['tipoSolicitacao']);
            $pedido->setIdFornecedor($dados['contratada']);
            $pedido->setIdFonte($dados['fonte']);
            $pedido->setIdProgramaTrabalho($dados['programa']);
            $pedido->setIdDespesaElemento($dados['despesa']);
            $pedido->setIdDespesa($dados['subElemento']);
            $pedido->setIdTipoGasto($dados['tipoDeGasto']);
            $pedido->setIdLotacao($dados['idLotacao']);
            $pedido->setDsPedido($dados['descPedido']);
            $pedido->setVlPedido(0);
            $pedido->setIdPortaria(0);
            $pedido->setIdConvenio(0);
            $pedido->setContratado($dados['contratado']);
            echo $pedido->salvaPedido();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'cadastrarPedidoSemFornecedor':
        try {

            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pedido = new Pedido();
            $pedido->setAno($dados['ano']);
            $pedido->setIdTipoSolicitacao($dados['tipoSolicitacao']);
            $pedido->setIdFornecedor($dados['contratada']);
            $pedido->setIdFonte($dados['fonte']);
            $pedido->setIdProgramaTrabalho($dados['programa']);
            $pedido->setIdDespesaElemento($dados['despesa']);
            $pedido->setIdDespesa($dados['subElemento']);
            $pedido->setIdTipoGasto($dados['tipoDeGasto']);
            $pedido->setIdLotacao($dados['idLotacao']);
            $pedido->setDsPedido($dados['descPedido']);
            $pedido->setVlPedido($dados["valor"]);
            echo $pedido->salvaPedidoSemFornecedor();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'carregaLotacao':
        try {

            if ($session->vPFinanceiroAcao()) {
                $central = new FinCentralModel();
                echo $central->retornaOptionsCentrais();
            } else {
                $central = new CentralResponsavel();
                $central->setIdPessoa($_SESSION['idUser']);
                echo $central->retornaLotacaoUsuarioCentral(null);
            }
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}
?>
