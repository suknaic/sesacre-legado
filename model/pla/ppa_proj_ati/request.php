<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/ppa_proj_ati/PpaProjAti.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {
               
    case 'cadPpaProjAti':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $proj = new PpaProjAti(); 
            
            $proj->setNmPpaProjAti(trim($get['nome']));
            $proj->setIdPpaProg((int)$get['ppa_prog']);
            $proj->setCdPpaProjAti($get['codigo']);
            $proj->setTpPpaProjAti($get['tipo']);
            echo $proj->cadastrarPpaProjAti();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtPpaProjAti':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $proj = new PpaProjAti();             
            $proj->setIdPpaProjAti((int)$get['id']);
            $proj->setNmPpaProjAti(trim($get['nome']));   
            $proj->setCdPpaProjAti($get['codigo']);
            $proj->setTpPpaProjAti($get['tipo']);
            echo $proj->editarPpaProjAti();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
    
    
    case 'remPpaProjAti':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $proj = new PpaProjAti();             
            $proj->setIdPpaProjAti((int)$get['id']);
            echo $proj->removerPpaProjAti();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaPpaProjAtiTable':
        try {
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);       
                        
            $proj = new PpaProjAti();
            $proj->setIdPpaProg((int)$get['ppa_prog']);
            echo $proj->retornaTrPpaProjAtiPorPpaProg();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
