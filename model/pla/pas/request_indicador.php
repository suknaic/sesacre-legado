<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/PasAcaoIndicador.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/acao/Acao.class.php";

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
               
    case 'cad':
        try {
            
            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoAcao()){
                $perfil = 0;                
            }
           
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $pas = new PasAcaoIndicador();                                    
            $pas->setIdPas((int)$get['pas']);
            $pas->setIdAcao((int)$get['acao']);
            if(array_key_exists("indicadores", $get)){
                $pas->setIdIndicadorSaude($get['indicadores']);
            } 
            
            echo $pas->cadastrar($perfil);
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
            
            $pas = new PasAcaoIndicador();                                    
            $pas->setIdPas((int)$get['pas']);
            $pas->setIdAcao((int)$get['acao']);
            if(array_key_exists("indicadores", $get)){
                $pas->setIdIndicadorSaude($get['indicadores']);
            } 
            
            echo $pas->editar($perfil);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break; 
        }  
    
    
    case 'rem':
        try {
        
            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoAcao()){
                $perfil = 0;                
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $pas = new PasAcaoIndicador();            
            $pas->setIdAcao((int)$get['id']);
            $pas->setIdPas((int)$get['pas']);
            echo $pas->remover($perfil);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
     
    case 'listaInfo':
        try {
        
            $idPas = (int)filter_input(INPUT_GET, 'pas');
            
            $pas = new Pas();
            $pas->setIdPas($idPas);
            echo $pas->retornaList();                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
        
        
    case 'retornaDadosAcao':
        try {
        
            $dados = filter_input(INPUT_GET, 'dados');
            $dados = json_decode($dados);                               
            $acao = new Acao(); 
            $acao->setIdAcao((int)$dados->id);            
            
            echo $acao->retornaListAcao();                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }    
        
    case 'retornaDadosEdicao':
        try {
        
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);   
                        
            $pas = new PasAcaoIndicador(); 
            $pas->setIdAcao((int)$dados['id']);
            $pas->setIdPas((int)$dados['pas']);
            echo $pas->retornaDadosParaEdicao();                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }    
        
    case 'retornaPasAcao':
        try {
        
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);   
                        
            $pas = new PasAcaoIndicador(); 
            $pas->setIdPas((int)$dados['pas']);
            
            echo $pas->retornaTrPasAcao();                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
          
        
        
}


