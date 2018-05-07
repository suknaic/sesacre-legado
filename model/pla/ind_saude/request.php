<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/ind_saude/IndicadorSaude.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {
               
    case 'salvaIndicador':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $pla = new IndicadorSaude(); 
            
            $pla->setNmIndicadorSaude(trim($get['nome']));
            $pla->setAaIndicadorSaude((int)$get['ano']);
            $pla->setCdNota(trim($get['nota']));
            $pla->setTpIndicadorSaude(trim($get['tipo']));
            $pla->setDsMeta(trim($get['meta']));
            $pla->setDsUnidade(trim($get['unidade']));            
            $pla->setIdIndicadorSaude((int)$get['id']);
            
            echo $pla->salvarIndicadorSaude();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }            
    
    
    case 'remIndicador':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $dao = new IndicadorSaude();             
            $dao->setIdIndicadorSaude((int)$get['id']);
            echo $dao->removerIndicadorSaude();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaIndicadorTable':
        try {
        
            $pla = new IndicadorSaude();            
            echo $pla->retornaTrIndicadorSaude();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
