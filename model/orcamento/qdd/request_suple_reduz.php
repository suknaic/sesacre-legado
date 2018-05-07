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
        
    case 'salvar':
        try {
        
            if(!$session->vPQddAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            $inicial = filter_input(INPUT_GET, 'inicial', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);  
            $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);                                                            
            
            $qdd = new QddSupRed();
            $qdd->setIdPessoa($session->getIdUser());
                        
            echo $qdd->salvar($inicial, $get, $ano);
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
    
    case 'listaSupleReduz':
        try {                    
        
            $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);
                                    
            $qdd = new QddSupRed();                     
                        
            echo $qdd->retornaTrComSupRed((int)$ano);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
        
        
        
}
