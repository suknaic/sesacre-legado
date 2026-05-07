<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/central/CentralPessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItem.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamentoCentral()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {                   
     
    case 'listaUnidadeParaValidao':
        try {
        
            $get = filter_input(INPUT_GET, 'lotacao', FILTER_DEFAULT);
                
            $cen = new CentralPessoa();            
            $cen->setIdLotacao($get);
            $cen->setIdPessoa($session->getIdUser());
            echo $cen->retornaUnidadesParaValidacao();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
