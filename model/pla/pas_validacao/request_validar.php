<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/PasValidacao.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}
           



switch ($_REQUEST['acao']) {                   
       
     
   
    case 'valida':
        try {         
        
            if(!$session->vPPlanejamentoAcao()){    
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                 
            }
                                                       
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);         
            
            $pas = new Pas();
            $pas->setIdPas((int)$get['pas']);                                    
            
            echo $pas->pasValida($session->getIdUser(), trim($get['msg']));
            return;
            break;

        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'naovalida':
        try {           
                 
            if(!$session->vPPlanejamentoAcao()){    
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                 
            }
        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                                                
           
            $pas = new Pas();
            $pas->setIdPas((int)$get['pas']);  
            
            echo $pas->pasNaoValida($session->getIdUser(), trim($get['msg']));
            return;
            break;

        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}







?>
