<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/central/CentralPessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/perfil_pessoa/PerfilPessoa.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {
               
    case 'cad':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $central = new CentralPessoa();
            
            $central->setIdPessoa((int)$get['pessoa']);
            $central->setIdLotacao((int)$get['central']);
            
            echo $central->cadastrar();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }          
        
    case 'rem':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $central = new CentralPessoa();            
            $central->setIdCentralPessoa((int)$get['id']); 
            echo $central->remover();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaTable':
        try {
        
            $cp = new CentralPessoa();            
            echo $cp->retornaTrCentralResponsaveis();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
