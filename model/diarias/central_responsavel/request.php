<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/CentralResponsavel.class.php";

$session = new Session('ajax');


switch ($_REQUEST['acao']) {
    case 'cadCentralRespDiaria':
        try {
            
            if(!$session->vPDiariasPermissoes()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $central = new CentralResponsavel();
            
            $central->setIdPessoa((int)$get['pessoa']);
            $central->setIdLotacao((int)$get['central']);
            $central->setTiposAdministracoes([3]);
            echo $central->cadastrar();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'remCentralRespDiaria':
        try {
        
            if(!$session->vPDiariasPermissoes()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $central = new CentralResponsavel();            
            $central->setIdCentralResponsavel((int)$get['id']); 
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
        
            $cp = new CentralResponsavel();
            $cp->setTiposAdministracoes([3]);
            echo $cp->retornaTrCentralRespDiaria();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}