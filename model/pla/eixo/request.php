<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/eixo/Eixo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pes/Pes.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {
               
    case 'cadEixo':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
            
            $get = filter_input(INPUT_GET, 'eixo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);           
                        
            $eixo = new Eixo();
            
            $eixo->setNmEixo(trim($get['nome']));
            $eixo->setNrOrdem((int)$get['ordem']);
            $eixo->setIdPes((int)$get['pes']);
            if(array_key_exists("proj_ati", $get)){
                $eixo->setIdPpaProjAti($get['proj_ati']);            
            }                       
            echo $eixo->cadastrarEixo();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtEixo':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
        
            $get = filter_input(INPUT_GET, 'eixo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $eixo = new Eixo();
            
            $eixo->setNmEixo(trim($get['nome']));
            $eixo->setNrOrdem((int)$get['ordem']);
            $eixo->setIdPes((int)$get['pes']);            
            $eixo->setIdEixo((int)$get['id']);
            if(array_key_exists("proj_ati", $get)){
                $eixo->setIdPpaProjAti($get['proj_ati']);            
            }
            
            echo $eixo->editarEixo();
            
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
    
    
    case 'remEixo':
        try {
            
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'eixo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
             
            $eixo = new Eixo();           
            $eixo->setIdEixo((int)$get['id']);
            echo $eixo->removerEixo();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'retornaDadosParaEdicao':
        try{
        
            if(!$session->vPPlanejamentoAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'eixo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
             
            $eixo = new Eixo();           
            $eixo->setIdEixo((int)$get['id']);
            echo $eixo->retornaDadosJson();
            return;
            break; 
                
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'listaEixoTable':
        try {
        
            $idPes = (int)filter_input(INPUT_GET, 'pes');
            
            $eixo = new Eixo();      
            $eixo->setIdPes($idPes);
            echo $eixo->retornaTrEixoPorPes();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'listaInfo':
        try {
        
            $idPes = (int)filter_input(INPUT_GET, 'pes');
            
            $pes = new Pes();
            $pes->setIdPes($idPes);
            echo $pes->retornaList();                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
