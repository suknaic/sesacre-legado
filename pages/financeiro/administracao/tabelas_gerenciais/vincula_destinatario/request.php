<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/DocDestinatario.class.php";


$session = new Session('ajax');


switch ($_REQUEST['acao']) {
    CASE 'retornaTiposDestinatarios':
        try {
            $prog = new DocDestinatario();            
            echo $prog->listaTodos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'cadastrarTiposDestinatarios':
        try {
                                
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $prog = new DocDestinatario();
            
            $prog->setIdDocTipoDestinatario((int)$filtro['idDocTpDest']);
            $prog->setIdLotacao((int)$filtro['idLotacao']);
            
            echo $prog->cadastrar();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }     
        
    CASE 'removerTiposDestinatarios':
        try {
                           
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);             
            
            $prog = new DocDestinatario();
            
            $prog->setIdDocDestinatario((int)$filtro);
            
            echo $prog->excluir();            
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

