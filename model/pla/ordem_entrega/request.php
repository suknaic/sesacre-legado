<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/ordem_recebido/PtaItemRecebido.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamentoUsuario()){
    echo "SessaoExpirada";
    return;
}

$perfil = 0;
if($session->vPPlanejamento()){
    $perfil = 1;
}


switch ($_REQUEST['acao']) {

    case 'listaOrdens':
        try {
        
            $get = filter_input(INPUT_GET, 'lotacao', FILTER_DEFAULT);
                
            $p = new PtaItemRecebido();            
            
            echo $p->retornaTrOrdemEsperandoRecebido((int)$get, $perfil, $session->getIdUser());                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
   
   
        
   
        
        
                        
}
?>
