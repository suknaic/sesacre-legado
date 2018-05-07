<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pre_loa/PreLoa.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {                   
     
    case 'valores':
        try {
            
            $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);
            
            $loa = new PreLoa();
            $loa->setAaPreLoa($ano);
                                
            echo $loa->retornaValoresPreLOAParaEdicao();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'retornaEdicao':
        try {
            
            $id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
            
            $loa = new PreLoa();
            $loa->setIdPreLoaValores((int)$id);
                                
            echo $loa->retornaDadosParaEdicao();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'salvarRegistro':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $loa = new PreLoa();
            $loa->setAaPreLoa((int)$get['ano']);
            $loa->setIdPreLoaValores((int)$get['id']);
            $loa->setIdProgramaTrabalho((int)$get['programa']);
            $loa->setIdDespesaElemento((int)$get['despesa']);
            $loa->setIdFonte((int)$get['fonte']);
            $loa->setVlPreLoaValores($get['valor']);
                                
            echo $loa->salvar();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'removerRegistro':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $loa = new PreLoa();            
            $loa->setIdPreLoaValores((int)$get['id']);
            
                                
            echo $loa->removerRegistro();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'desativar':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $loa = new PreLoa();            
            $loa->setAaPreLoa((int)$get['ano']);
            $loa->setDsPreLoaHistorico(trim($get['msg']));
            $loa->setIdPessoa($session->getIdUser());
            
                                
            echo $loa->desativar();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
     
        
        
}







?>
