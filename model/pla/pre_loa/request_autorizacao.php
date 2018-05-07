<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pre_loa/PreLoa.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamentoPreLoa()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {                   
     
    case 'verificaAutorizacaoPreLoa':
        try {                                   
                        
            $loa = new PreLoa();
                                
            echo $loa->retornaTabelaPreLoaAutorizar((int)$session->getIdUser(), $session->getPerfis());                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'retornarAnos':
        try {                                   
                        
            $loa = new PreLoa();
                                
            echo $loa->retornaAnosQueExiste();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
        
    case 'valores':
        try {
            
            $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);
            
            $loa = new PreLoa();
            $loa->setAaPreLoa($ano);
                                
            echo $loa->retornaValoresPreLOA();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
    case 'autorizar':
        try {
        
            if(!$session->vPPlanejamentoPreLoaAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $loa = new PreLoa();            
            $loa->setAaPreLoa((int)$get['ano']);
            $loa->setDsPreLoaHistorico(trim($get['mensagem']));
            $loa->setIdPessoa($session->getIdUser());
                        
            echo $loa->enviarProximaAutorizacao($session->getPerfis(), "autorizar");                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'retornar':
        try {
        
            if(!$session->vPPlanejamentoPreLoaAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $loa = new PreLoa();            
            $loa->setAaPreLoa((int)$get['ano']);
            $loa->setDsPreLoaHistorico(trim($get['mensagem']));
            $loa->setIdPessoa($session->getIdUser());
                        
            echo $loa->enviarProximaAutorizacao($session->getPerfis(), "retornar");                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    
        
        
        
}







?>
