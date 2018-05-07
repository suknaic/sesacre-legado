<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItem.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pre_loa/PreLoa.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {                   
     
    case 'simulaValores':
        try {
            
            $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);
            
            $pas = new Pas();
                                
            echo $pas->retornaSimulacaoValoresPreLOA((int)$ano);                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'criar':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            
            
            $loa = new PreLoa();
            $loa->setAaPreLoa((int)$get['ano']);
            $loa->setIdPessoa($session->getIdUser());
            $loa->setDsPreLoaHistorico(trim($get['texto']));
                                
            echo $loa->criar();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
    
        
        
        
}







?>
