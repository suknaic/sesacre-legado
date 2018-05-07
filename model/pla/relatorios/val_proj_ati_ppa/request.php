<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/ppa_proj_ati/PpaProjAti.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/relatorio/Relatorio.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {                   
     
    case 'pesquisa':
        try {
        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $rel = new Relatorio();            
            echo $rel->rTrValProjAtiPPAAnoLot((int)$get['ano'], (int)$get['lotacao']);           
            
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
