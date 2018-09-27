<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/contabil/administracao/Perfil.class.php";

$session = new Session('ajax');


switch ($_REQUEST['acao']) {
    
    CASE 'retornaPessoasPerfis':
        try {
            $prog = new Perfil();            
            echo $prog->retornaTrTodos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'cadastrarPessoaPerfil':
        try {
                                
            $get = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $perfil = new Perfil();
            
            $perfil->setIdPessoa((int)$get['pessoa']);
            $perfil->setIdPerfil((int)$get['perfil']);
            
            echo $perfil->cadastrar();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }     
        
    CASE 'removerPessoaPerfil':
        try {
                           
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);             
            
            $perfil = new Perfil();
            
            $perfil->setIdPessoa((int)$get['pessoa']);
            $perfil->setIdPerfil((int)$get['perfil']);
            
            echo $perfil->remover();            
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}



