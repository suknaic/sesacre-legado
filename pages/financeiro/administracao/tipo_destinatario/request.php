<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/DocTipoDestinatario.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    
    CASE 'cadastrarTipoDestinatario':
        try {
                                
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $prog = new DocTipoDestinatario();
            
            $prog->setNmDocTipoDestinatario($filtro['nmTpDest']);
            
            
            echo $prog->cadastrar();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }    
    CASE 'alterarTipoDestinatario':
        try {
                                
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $prog = new DocTipoDestinatario();
            
            $prog->setIdDocTipoDestinatario($filtro['idTpDest']);
            $prog->setNmDocTipoDestinatario($filtro['nmTpDest']);
            
            
            echo $prog->alterar();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }    
    CASE 'removerTipoDestinatario':
        try {
                                
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);                        
            
            $prog = new DocTipoDestinatario();
            
            $prog->setIdDocTipoDestinatario($filtro);
            
            
            echo $prog->excluir();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    CASE 'retornaTiposDestinatarios':
        try {
            $prog = new DocTipoDestinatario();            
            echo $prog->listaTodos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}