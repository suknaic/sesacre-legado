<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/cargo.class.php";
       

$session = new Session('ajax');

if(!$session->verificaPermissao(PERFIL_TI)){
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {
               
    case 'cadastrarCargo':
        try {
                        
            $cargo = filter_input(INPUT_POST, 'cargo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $sesCargo = new Cargo();
            $sesCargo->setNm_cargo(trim($cargo['nome']));
            echo $sesCargo->cadastrarCargo();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'editarCargo':
        try {
            
            $cargo = filter_input(INPUT_POST, 'cargo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $sesCargo = new Cargo();
            $sesCargo->setNm_cargo(trim($cargo['nome']));
            $sesCargo->setId_cargo((int)$cargo['id']);
            echo $sesCargo->editarCargo();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
    
    
    case 'removerCargo':
        try {
                        
            $cargo = filter_input(INPUT_POST, 'cargo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $sesCargo = new Cargo();
            $sesCargo->setId_cargo((int)$cargo['id']);
            echo $sesCargo->removerCargo();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaCargoTable':
        try {
        
            $sesCargo = new Cargo();            
            echo $sesCargo->retornaTrCargo();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
