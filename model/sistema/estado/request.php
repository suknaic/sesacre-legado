<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/estado/Estado.class.php";

$session = new Session('ajax');

if(!$session->verificaPermissao(PERFIL_TI)){
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {
               
    case 'cadEstado':
        try {
                        
            $est = filter_input(INPUT_GET, 'estado', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $vinc = new Estado();
            
            $vinc->setNmEstado(trim($est['nome']));
            $vinc->setNmSigla(trim($est['sigla']));
            $vinc->setIdPais((int)($est['idp']));
            
            echo $vinc->cadastrarEstado();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtEstado':
        try {
            
            $est = filter_input(INPUT_GET, 'estado',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            //print_r($est);
            $vinc = new Estado();
            $vinc->setNmEstado(trim($est['nome']));            
            $vinc->setNmSigla(trim($est['sigla']));            
            $vinc->setIdEstado((int)$est['id']);            
            $vinc->setIdPais((int)($est['idp']));            
            echo $vinc->editarEstado();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
        
    
    case 'remEstado':
        try {
                        
            $est = filter_input(INPUT_GET, 'estado', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $vinc = new Estado();
            $vinc->setIdEstado((int)$est['id']);
            echo $vinc->removerEstado();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaEstadosTable':
        try {
        
            $vinc = new Estado();            
            echo $vinc->retornaTrEstados();
           // echo 'teste';
            return;
            
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        case 'SelectPaisesOpt':
        try {
        
            $vinc = new Estado();            
            echo $vinc->retornaOptionPaises();
           // echo 'teste';
            return;
            
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
