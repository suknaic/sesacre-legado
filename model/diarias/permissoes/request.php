<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Perfil.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/perfil_pessoa/PerfilPessoa.class.php";

$session = new Session('ajax');

if(!$session->vPDiariasPermissoes()){
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
               
    case 'cad':
        try {
        
            if(!$session->vPDiariasPermissoes()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
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
        
    case 'rem':
        try {
        
            if(!$session->vPDiariasPermissoes()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                   
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
     
    case 'listaTable':
        try {
        
            $perfil = new Perfil();            
            echo $perfil->retornaTrTodos();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>