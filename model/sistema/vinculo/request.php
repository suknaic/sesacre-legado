<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/vinculo/Vinculo.class.php";

$session = new Session('ajax');

if(!$session->verificaPermissao(PERFIL_TI)){
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {
               
    case 'cadVinculo':
        try {
                        
            $vinculo = filter_input(INPUT_GET, 'vinculo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $vinc = new Vinculo();
            $vinc->setNmVinculo(trim($vinculo['nome']));
            echo $vinc->cadastrarVinculo();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtVinculo':
        try {
            
            $vinculo = filter_input(INPUT_GET, 'vinculo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $vinc = new Vinculo();
            $vinc->setNmVinculo(trim($vinculo['nome']));
            $vinc->setIdVinculo((int)$vinculo['id']);
            echo $vinc->editarVinculo();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
    
    
    case 'remVinculo':
        try {
                        
            $vinculo = filter_input(INPUT_GET, 'vinculo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $vinc = new Vinculo();
            $vinc->setIdVinculo((int)$vinculo['id']);
            echo $vinc->removerVinculo();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaVinculosTable':
        try {
        
            $vinc = new Vinculo();            
            echo $vinc->retornaTrVinculos();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaVinculoOption':
        try {
            $prog = new Vinculo();
            echo $prog->retornaOptionVinculo();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    
}







?>
