<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItem.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaTitulo.class.php";

$session = new Session('ajax');

//Irá determinar se o usuario pode ou não visualizar todos os PAS cadastrados      
if(!$session->vPPlanejamentoUsuario()){
    return "SesãoExpirada";
}



switch ($_REQUEST['acao']) {
               
    case 'retornaDadosAcoes':
        try {              
                                   
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $pta = new PtaTitulo();           
            $pta->setIdPtaTitulo((int)$get['pta_titulo']);                        
            echo $pta->retornaTabelaAcoes();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
        
    case 'retornaGraficoColunaFonte':
        try {              
                                   
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $pta = new PtaTitulo();           
            $pta->setIdPtaTitulo((int)$get['pta_titulo']);                        
            echo $pta->retornaDadosValoresFonte();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
       
    case 'retornaPizzaCategoriaEconomica':
        try {              
                                   
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $pta = new PtaTitulo();           
            $pta->setIdPtaTitulo((int)$get['pta_titulo']);                        
            echo $pta->retornaDadosValoresCatEconomica();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
                                
}

?>
