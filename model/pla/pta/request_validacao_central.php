<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItem.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItemValidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItemValidacaoItem.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto_categoria/TipoGastoCategoria.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamentoUsuario()){
    echo "SessaoExpirada";
    return;
}

//Irá determinar se o usuario pode ou não visualizar todos os PAS cadastrados
$perfil = 1;            
if(!$session->vPPlanejamento()){    
    $perfil = 0;                    
}


switch ($_REQUEST['acao']) {
               
    case 'enviarCentral':
        try {
            
            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoAcao()){
                $perfil = 0;                
            }
           
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                                    
            
           
            $obj = new PtaItemValidacao();                                    
            $obj->setIdPas((int)$get['pas']);
            $obj->setIdTipoGastoCategoria((int)$get['id']);
            $obj->setDsPtaItemValidacao(trim($get['mensagem']));
            $obj->setIdPessoa($session->getIdUser());
            
            echo $obj->salvar(1, 1, $perfil);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }                            
                   
        
    case 'retornaItens':
        try {
        
            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoAcao()){
                $perfil = 0;                
            }
        
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);   
                        
            $pas = new Pas(); 
            $pas->setIdPas((int)$dados['pas']);
                        
            echo $pas->retornaTabelasValidacaoCentral($perfil);                   
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


