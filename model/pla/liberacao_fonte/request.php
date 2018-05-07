<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/liberacao_fonte/LiberacaoFonte.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {
               
    case 'inserir':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                   
           
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
           
            $lib = new LiberacaoFonte();             
            $lib->setIdFonte((int)$get['fonte']);                       
            $lib->setAaLiberacaoFonte((int)$get['ano']);            
            $lib->setVlLiberacaoFonte(trim($get['valor']));                                    
            
            echo $lib->inserir();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }     
        
    case 'editar':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $lib = new LiberacaoFonte();           
            $lib->setIdLiberacaoFonte((int)$get['id']);
            $lib->setIdFonte((int)$get['fonte']);                       
            $lib->setAaLiberacaoFonte((int)$get['ano']);            
            $lib->setVlLiberacaoFonte(trim($get['valor']));                                    
            
            echo $lib->editar();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        } 
    
    
    case 'rem':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $lib = new LiberacaoFonte();             
            $lib->setIdLiberacaoFonte((int)$get['id']);
            echo $lib->remover();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaTable':
        try {
        
            $lib = new LiberacaoFonte();            
            echo $lib->retornaTr();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
