<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaAcaoDet.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaTitulo.class.php";

$session = new Session('ajax');

//Irá determinar se o usuario pode ou não visualizar todos os PAS cadastrados
$perfil = 1;            
if(!$session->vPPlanejamento()){
    $perfil = 0;                
}



switch ($_REQUEST['acao']) {
               
    case 'cad':
        try {              
            
            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoAcao()){
                $perfil = 0;                
            }
           
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $pad = new PtaAcaoDet();           
            
            $pad->setNmPtaAcaoDet(trim($get['nome']));
            $pad->setIdPtaTitulo((int)$get['id']);                        
            $pad->setIdAcao((int)$get['acao']);    
            echo $pad->cadastrar($perfil);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edt':
        try {
        
            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoAcao()){
                $perfil = 0;                
            }
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $pad = new PtaAcaoDet();
                        
            $pad->setNmPtaAcaoDet(trim($get['nome']));
            $pad->setIdPtaAcaoDet((int)$get['id']);                  
            $pad->setIdAcao((int)$get['acao']);
            $pad->setIdPtaTitulo((int)$get['pta_titulo']);
            
            echo $pad->editar($perfil);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
    
    
    case 'rem':
        try {
        
            require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/Pta.class.php";
            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoAcao()){
                $perfil = 0;                
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $pad = new PtaAcaoDet();            
            $pad->setIdPtaAcaoDet((int)$get['id']);
            echo $pad->remover($perfil);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
            
    case 'retornaTabela':
        try {
            
            $pad = new PtaAcaoDet();            
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
                        
            $pad->setIdPta((int)$get['id']);
            $pad->setIdPtaTitulo((int)$get['pta_titulo']);
            
            echo $pad->retornaTrPorPta();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'listaInfo':
        try {
            
            $ptaTitulo = new PtaTitulo();            
            
            $get = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);        
            
            $idPtaTitulo = (int)$get;   
            $ptaTitulo->setIdPtaTitulo($idPtaTitulo);
            $ptaTitulo->carregaDados();                 
            echo $ptaTitulo->retornaList();                  
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
           
        
        
        
}







?>
