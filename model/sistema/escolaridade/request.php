<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/escolaridade/Escolaridade.class.php";

$session = new Session('ajax');

if(!$session->verificaPermissao(PERFIL_TI)){
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {
               
    case 'cadEscolaridade':
        try {
                        
            $esc = filter_input(INPUT_GET, 'escolaridade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $vinc = new Escolaridade();
            $vinc->setNmEscolaridade(trim($esc['nome']));
            echo $vinc->cadastrarEscolaridade();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtEscolaridade':
        try {
            
            $esc = filter_input(INPUT_GET, 'escolaridade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $vinc = new Escolaridade();
            $vinc->setNmEscolaridade(trim($esc['nome']));
            $vinc->setIdEscolaridade((int)$esc['id']);
            echo $vinc->editarEscolaridade();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
    
    
    case 'remEscolaridade':
        try {
                        
            $esc = filter_input(INPUT_GET, 'escolaridade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $vinc = new Escolaridade();
            $vinc->setIdEscolaridade((int)$esc['id']);
            echo $vinc->removerEscolaridade();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaEscolaridadeTable':
        try {
        
            $vinc = new Escolaridade();            
            echo $vinc->retornaTrEscolaridade();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
