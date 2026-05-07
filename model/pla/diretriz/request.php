<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/diretriz/Diretriz.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/eixo/Eixo.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {
               
    case 'cadDiretriz':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
            
            $get = filter_input(INPUT_GET, 'diretriz', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $dir = new Diretriz();
            
            $dir->setNmDiretriz(trim($get['nome']));
            $dir->setNrOrdem((int)$get['ordem']);
            $dir->setIdEixo((int)$get['eixo']);            
            
            echo $dir->cadastrarDiretriz();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtDiretriz':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'diretriz', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $dir = new Diretriz();
            
            $dir->setNmDiretriz(trim($get['nome']));
            $dir->setNrOrdem((int)$get['ordem']);
            $dir->setIdEixo((int)$get['eixo']);   
            $dir->setIdDiretriz((int)$get['id']);
            echo $dir->editarDiretriz();
            
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
    
    
    case 'remDiretriz':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'diretriz', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
             
            $dir = new Diretriz();           
            $dir->setIdDiretriz((int)$get['id']);
            echo $dir->removerDiretriz();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaDiretrizTable':
        try {
        
            $idEixo = (int)filter_input(INPUT_GET, 'eixo');
            
            $dir = new Diretriz();      
            $dir->setIdEixo($idEixo);
            echo $dir->retornaTrDiretrizesPorEixo();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'listaInfo':
        try {
        
            $idEixo = (int)filter_input(INPUT_GET, 'eixo');
            
            $eixo = new Eixo();  
            $eixo->setIdEixo($idEixo);
            echo $eixo->retornaList();                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}







?>
