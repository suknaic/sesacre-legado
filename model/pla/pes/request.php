<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pes/Pes.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {
               
    case 'cadPes':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'pes', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $pes = new Pes();
            
            $pes->setNmPes(trim($get['nome']));
            $pes->setVigenciaInicio((int)$get['dt_inicio']);
            $pes->setVigenciaFim((int)$get['dt_fim']);
            echo $pes->cadastrarPes();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtPes':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
            
            $get = filter_input(INPUT_GET, 'pes', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $pes = new Pes();
            $pes->setNmPes(trim($get['nome']));
            $pes->setVigenciaInicio((int)$get['dt_inicio']);
            $pes->setVigenciaFim((int)$get['dt_fim']);
            $pes->setIdPes((int)$get['id']);
            echo $pes->editarPes();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
    
    
    case 'remPes':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'pes', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $pes = new Pes();            
            $pes->setIdPes((int)$get['id']);
            echo $pes->removerPes();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaPesTable':
        try {
        
            $pes = new Pes();            
            echo $pes->retornaTrPes();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
