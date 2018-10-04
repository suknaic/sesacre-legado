<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/FinTipoDocumento.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    CASE 'retornaTiposDocumentos':
        try {
            $prog = new FinTipoDocumento();            
            echo $prog->listaTodos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'cadastrarTipoDocumento':
        try {
                                
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $prog = new FinTipoDocumento();
            
            $prog->setNmTipoDocumento($filtro['nm_tipo_documento']);
            
            
            echo $prog->cadastrar();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        } 
        
    CASE 'alterarTipoDocumento':
        try {
                                
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $prog = new FinTipoDocumento();
            
            $prog->setIdTipoDocumento($filtro['id_tipo_documento']);
            $prog->setNmTipoDocumento($filtro['nm_tipo_documento']);
            
            
            echo $prog->alterar();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    CASE 'removerTipoDocumento':
        try {
                                
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);                        
            
            $prog = new FinTipoDocumento();
            
            $prog->setIdTipoDocumento($filtro);
            
            
            echo $prog->desativar();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    CASE 'ativarTipoDocumento':
        try {
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);                        
            
            $prog = new FinTipoDocumento();
            
            $prog->setIdTipoDocumento($filtro);
            
            
            echo $prog->ativar();
            return;
            break;
        } catch (Exception $exc) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}