<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/ppa_prog/PpaProg.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {
               
    case 'cadPpaProg':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $prog = new PpaProg(); 
            
            $prog->setNmPpaProg(trim($get['nome']));
            $prog->setAaInicio((int)$get['dt_inicio']);
            $prog->setAaFim((int)$get['dt_fim']);
            $prog->setCdPpaProg(trim($get['codigo']));
            echo $prog->cadastrarPpaProg();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtPpaProg':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $prog = new PpaProg();             
            $prog->setIdPpaProg((int)$get['id']);
            $prog->setNmPpaProg(trim($get['nome']));
            $prog->setAaInicio((int)$get['dt_inicio']);
            $prog->setAaFim((int)$get['dt_fim']);            
            $prog->setCdPpaProg(trim($get['codigo']));
            echo $prog->editarPpaProg();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
    
    
    case 'remPpaProg':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'ppaprog', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $prog = new PpaProg();             
            $prog->setIdPpaProg((int)$get['id']);
            echo $prog->removerPpaProg();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaPpaProgTable':
        try {
        
            $prog = new PpaProg();            
            echo $prog->retornaTrPpaProg();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
