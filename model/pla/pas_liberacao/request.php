<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/PasValidacao.class.php";

$session = new Session('ajax');

if(!$session->vPPlanejamento()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {                   
     
    case 'listaPasParaLiberar':
        try {
            
            $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);
            
            $pas = new Pas();
                    
            echo $pas->retornaTrPasParaLiberar((int)$ano);                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
    case 'informacoes':
        try {
            
            $id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
            
            $pas = new Pas();
            $pas->setIdPas((int)$id);
                    
            $pas->retornaTextAreaDasValidacoes();                      
            echo $pas->getMsgRetorno();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'liberarPas':
        try {
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                        
            $pas = new Pas();
            $pas->setIdPas((int)$get['id']);
            
            echo $pas->liberaBloqueiaPas((int)$session->getIdUser(), $get['msg'], 1);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'bloquearPas':
        try {
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
                        
            $pas = new Pas();
            $pas->setIdPas((int)$get['id']);
                    
            echo $pas->liberaBloqueiaPas((int)$session->getIdUser(), $get['msg'], 0);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
        
        
}







?>
