<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/liberacao_fonte/LiberacaoFonteUnidade.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {
               
    case 'salvarInicial':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }            
           
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
           
            $lib = new LiberacaoFonteUnidade();             
            $lib->setIdLiberacaoFonte((int)$get['liberacao_fonte']);                       
            $lib->setIdProgramaTrabalho((int)$get['programa']);            
            $lib->setIdLotacao((int)$get['lotacao']);                                    
            $lib->setIdDespesaElemento((int)$get['despesa']);
            $lib->setVlInicial($get['valor']);
            $lib->setIdLiberacaoFonteUnidade((int)$get['id']);
            
            
            echo $lib->salvarInicial();
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
            
            $lib = new LiberacaoFonteUnidade();             
            $lib->setIdLiberacaoFonteUnidade((int)$get['id']);
            echo $lib->removerInicial();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaTable':
        try {
        
            $lib = new LiberacaoFonteUnidade();  
            $id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT); 
            $lib->setIdLiberacaoFonte((int)$id);
            
            echo $lib->retornaTrPorLiberacaoFonte();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'suple_reduz':
        try {
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }            
           
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
                                   
            $lib = new LiberacaoFonteUnidade();             
            $lib->setIdLiberacaoFonteUnidade((int)$get['id']);   
            $lib->setIdPessoa($session->getIdUser());
            
            echo $lib->salvarSuplementadoReduzido($get['valor'], $get['tipo']);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
        
    case 'listaSituacao':
        try {
        
            $lib = new LiberacaoFonteUnidade();  
            $ano = (int)filter_input(INPUT_GET, 'ano', FILTER_DEFAULT); 
            $idFonte = (int)filter_input(INPUT_GET, 'fonte', FILTER_DEFAULT);                         
            
            echo $lib->retornaTabelaSituacao($ano, $idFonte);                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
        
    
    
}







?>
