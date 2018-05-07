<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddSupRed.class.php";

$session = new Session('ajax');

if(!$session->vPQdd()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {                   
        
    case 'validar':
        try {
        
            if(!$session->vPQddAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                                                                    
                                   
            $qdd = new QddSupRed();                        
            $qdd->setIdQddSupRed((int)$get['id']);            
            $ano = (int)$get['ano'];
            $validacao = (int)$get['validacao'];
            
            echo $qdd->validar((int)$session->getIdUser(), $validacao);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'removerRegistro':
        try {
        
            if(!$session->vPQddAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                                                
            
            $qddValor = new QddValor();       
            $qddValor->setIdQddValor((int)$get['id']);                                
                        
            echo $qddValor->remover();               
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
    case 'listaSupleReduzParaValidar':
        try {                    
        
            $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);
                                    
            $qdd = new QddSupRed();                 
                        
            echo $qdd->retornaTrComSupRedParaValidar((int)$ano);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
        
        
        
}







?>
