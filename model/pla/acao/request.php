<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/acao/Acao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/objetivo/Objetivo.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {
               
    case 'cadAcao':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
            
            $get = filter_input(INPUT_GET, 'pla_acao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $acao = new Acao();
            
            $acao->setNmAcao(trim($get['nome']));
            $acao->setDsIndicador($get['indicador']);
            $acao->setIdObjetivo((int)$get['objetivo']);    
            $acao->setDsMetaPlano($get['meta']);
            $acao->setTpCadastro("P");
            
            echo $acao->cadastrarAcao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtAcao':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'pla_acao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $acao = new Acao();
            
            $acao->setNmAcao(trim($get['nome']));
            $acao->setDsIndicador($get['indicador']);
            $acao->setIdObjetivo((int)$get['objetivo']);                
            $acao->setIdAcao((int)$get['id']);
            $acao->setDsMetaPlano($get['meta']);
            echo $acao->editarAcao();                        
            
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
    
    
    case 'remAcao':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'pla_acao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
             
            $acao = new Acao();           
            $acao->setIdAcao((int)$get['id']);
            echo $acao->removerAcao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaAcaoTable':
        try {
        
            $idObjetivo = (int)filter_input(INPUT_GET, 'objetivo');
            
            $acao = new Acao();     
            $acao->setIdObjetivo($idObjetivo);
            echo $acao->retornaTrAcaoPorObjetivo();                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    case 'listaInfo':
        try {
        
            $idObjetivo = (int)filter_input(INPUT_GET, 'objetivo');
            
            $acao = new Objetivo();     
            $acao->setIdObjetivo($idObjetivo);
            echo $acao->retornaList();                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
