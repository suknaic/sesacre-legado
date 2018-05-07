<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/central/CentralPessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItem.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItemValidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItemValidacaoItem.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto_categoria/TipoGastoCategoria.class.php";



$session = new Session('ajax');

if(!$session->vPPlanejamentoCentral()){
    echo "SessaoExpirada";
    return;
}

$perfil = 1;            
if(!$session->vPPlanejamento()){    
    $perfil = 0;                    
}


switch ($_REQUEST['acao']) {                   
       
    case 'listaTbItens':
        try {
                                       
            //PAS
            $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);
            //Id da Lotação da Central
            $central = filter_input(INPUT_GET, 'central', FILTER_DEFAULT);                        
            
            $cen = new CentralPessoa();            
            $cen->setIdLotacao($central);    
            $cen->setIdPessoa($session->getIdUser());            
            echo $cen->retornaTbItensDaCentral((int)$ano, $perfil, NULL);                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
    case 'retornaInfoDoItem':
        try {           

            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            $pta = new PtaItem();
            $pta->setIdPtaItem((int)$get['id']);            
            echo $pta->retornaInformacoesDoItem();
            return;
            break;

        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
   
}







?>
