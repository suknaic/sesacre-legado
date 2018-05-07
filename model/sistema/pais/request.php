<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pais/Pais.class.php";

$session = new Session('ajax');

if(!$session->verificaPermissao(PERFIL_TI)){
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {
               
    case 'cadPais':
        try {
                        
            $pais = filter_input(INPUT_GET, 'pais', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $vinc = new Pais();
            
            $vinc->setNmPais(trim($pais['nome']));
            $vinc->setNmSigla(trim($pais['sigla']));
            echo $vinc->cadastrarPais();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtPais':
        try {
            
            $pais = filter_input(INPUT_GET, 'pais',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $vinc = new Pais();
            $vinc->setNmPais(trim($pais['nome']));
            $vinc->setNmSigla(trim($pais['sigla']));
            $vinc->setIdPais((int)$pais['id']);
            echo $vinc->editarPais();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
    
    
    case 'remPais':
        try {
                        
            $pais = filter_input(INPUT_GET, 'pais', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $vinc = new Pais();
            $vinc->setIdPais((int)$pais['id']);
            echo $vinc->removerPais();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaPaisesTable':
        try {
        
            $vinc = new Pais();            
            echo $vinc->retornaTrPaises();
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
