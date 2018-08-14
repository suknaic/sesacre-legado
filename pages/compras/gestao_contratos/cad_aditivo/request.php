<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoAditivo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/ItemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/FinFornecedorModel.class.php";

/**/
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/SesPessoaJuridicaModel.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/processo/Processo.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";


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

    CASE 'retornaAditivosDoContrato':
        try {
            
            $idContrato = (int)filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);            
            $gestaoContratoModel = new FinContratoAditivo();
            $gestaoContratoModel->setIdContrato($idContrato);
            echo $gestaoContratoModel->retornaAditivosDoContrato();
            
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'pesquisaItens':
        try {
            $idContrato = (int)filter_input(INPUT_GET, 'id', FILTER_DEFAULT);            
            $gestaoContratoModel = new ItemModel();                      
            echo $gestaoContratoModel->retornaTrItensParaAditamento($idContrato);
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    case 'retornaGestoresDoContrato':
        try{
            $contratoModel = new FinContratoAditivo();    
            $idContrato = (int)filter_input(INPUT_GET, 'id', FILTER_DEFAULT);  
            $contratoModel->setIdContrato($idContrato);
            echo $contratoModel->retornaUltimoGestoresDoContratoAditivo();            
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    case 'salvar':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $contrato = new FinContratoAditivo();
            echo $contrato->salvar($dados);            
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    case 'removerAditivo':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $contrato = new FinContratoAditivo();
            $contrato->setIdContrato((int)$dados['id']);
            echo $contrato->remover($dados);            
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
  
    case 'buscaInformacoesAditivo':
        try{
            $contratoModel = new FinContratoAditivo();    
            $idContrato = (int)filter_input(INPUT_GET, 'id', FILTER_DEFAULT);  
            $contratoModel->setIdContrato($idContrato);
            echo $contratoModel->retornaInformacoesCompletaAditivo();            
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
    
    case 'buscaHistoricoDosItens':
        try{
            $contratoModel = new FinContratoAditivo();    
            $idContrato = (int)filter_input(INPUT_GET, 'id', FILTER_DEFAULT);  
            $contratoModel->setIdContrato($idContrato);
            echo $contratoModel->retornaHistoricoDosItens();            
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    case 'buscaContrato':
        try{
        
            $idContrato = (int)filter_input(INPUT_GET, 'id', FILTER_DEFAULT);  
            $gestaoContratoModel = new FinContratoModel();
            $gestaoContratoModel->setIdContrato($idContrato);
            echo $gestaoContratoModel->retornaDadosContratoJson();
            return;                        
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }    
     
}
