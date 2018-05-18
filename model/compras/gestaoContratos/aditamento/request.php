<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";

/**/
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/SesPessoaJuridicaModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/processo/Processo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";

$session = new Session('ajax');

if (!$session->vPContratos()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    
    
    CASE 'retornaOptionsGestores':
        try {
            $contratoModel = new Contrato();            
            echo $contratoModel->retornaOptionPessoaContrato(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        

    CASE 'pesquisaContrato':
        try {
            
            $numero = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            
            $gestaoContratoModel = new FinContratoModel();
            $gestaoContratoModel->setNrContrato($numero);
            echo $gestaoContratoModel->retornaContratoSelectItem();
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

    CASE 'retornaFornecedor':
        try {
            $pessoaJuridicaModel = new SesPessoaJuridicaModel();
            echo "<option value = '0'>Selecione um contratado</option>";
            echo $pessoaJuridicaModel::retornaOptionsPessoaJuridicaCadastrada(null);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaModalidade':
        try {
            $processo = new Processo();
            echo "<option value = '0'>Selecione uma modalidade</option>";
            echo $processo->retornarModalidade();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaCentrais':
        try {
            $finCentralModel = new FinCentralModel();
            echo $finCentralModel->retornaOptionsCentrais();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
    

    CASE 'editarItens':
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
            $finContratoModel = new FinContratoModel();
            $finContratoModel->setIdFornecedor($id);
            echo $finContratoModel->verificarAtaContrato();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}
