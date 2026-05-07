<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/PasValidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pre_loa/PreLoa.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {                   
     
    case 'verificaSituacaoPreLoa':
        try {
            
            $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);
            
                        
            $pas = new Pas();
                                
            echo $pas->retornaValidacaoPreLoa((int)$ano);                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
    case 'enviarPlanejamento':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
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
        
    case 'retornarPlanejamento':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
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
