<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/objetivo/Objetivo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/diretriz/Diretriz.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {
               
    case 'cadObjetivo':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
            
            $get = filter_input(INPUT_GET, 'objetivo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $obj = new Objetivo();
            
            $obj->setNmObjetivo(trim($get['nome']));
            $obj->setNrOrdem((int)$get['ordem']);
            $obj->setIdDiretriz((int)$get['diretriz']);            
            
            echo $obj->cadastrarObjetivo();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtObjetivo':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'objetivo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $obj = new Objetivo();
            
            $obj->setNmObjetivo(trim($get['nome']));
            $obj->setNrOrdem((int)$get['ordem']);
            $obj->setIdDiretriz((int)$get['diretriz']);   
            $obj->setIdObjetivo((int)$get['id']);
            echo $obj->editarObjetivo();
            
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
    
    
    case 'remObjetivo':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'objetivo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
             
            $obj = new Objetivo();           
            $obj->setIdObjetivo((int)$get['id']);
            echo $obj->removerObjetivo();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaObjetivoTable':
        try {
        
            $idDiretriz = (int)filter_input(INPUT_GET, 'diretriz');
            
            $obj = new Objetivo();      
            $obj->setIdDiretriz($idDiretriz);
            echo $obj->retornaTrObjetivoPorDiretriz();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaInfo':
        try {
        
            $idDiretriz = (int)filter_input(INPUT_GET, 'diretriz');
            
            $dir = new Diretriz();     
            $dir->setIdDiretriz($idDiretriz);
            echo $dir->retornaList();                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}







?>
