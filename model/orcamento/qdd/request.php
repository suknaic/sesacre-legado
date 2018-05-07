<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";

$session = new Session('ajax');

if(!$session->vPQdd()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {                   
        
    case 'criarQdd':
        try {
        
            if(!$session->vPQddAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $qdd = new Qdd();         
            $qdd->setAaQdd((int)$get['ano']);                        
                        
            echo $qdd->criar();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'removerQdd':
        try {
        
            if(!$session->vPQddAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                                                
            
            $qdd = new Qdd();         
            $qdd->setAaQdd((int)$get['ano']);                        
                        
            echo $qdd->remover();               
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    
        
        
        
}







?>
