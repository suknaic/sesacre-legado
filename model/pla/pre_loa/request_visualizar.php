<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pre_loa/PreLoa.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {                   
     
    case 'valores':
        try {
            
            $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);
            
            $loa = new PreLoa();
            $loa->setAaPreLoa($ano);
                                
            echo $loa->retornaValoresPreLOA();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
        
    
        
        
        
}







?>
