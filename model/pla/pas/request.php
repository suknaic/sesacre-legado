<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/Pta.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/PasValidacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItem.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/liberacao_fonte/LiberacaoFonteUnidade.class.php";

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
            
            $pas = new Pas();
                        
            $pas->setNmPas(trim($get['nome']));
            $pas->setIdPes((int)$get['pes']);
            $pas->setIdLotacao((int)$get['lotacao']);
            $pas->setIdPessoaResp((int)$get['pessoa_resp']);
            $pas->setIdPessoaExec((int)$get['pessoa_exec']);
            $pas->setDtInicio($get['dt_inicio']);
            $pas->setDtFim($get['dt_fim']);
            $pas->setDsObservacao(trim($get['obs']));
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
            
            $pas = new Pas();
                        
            $pas->setNmPas(trim($get['nome']));
            $pas->setIdPes((int)$get['pes']);
            $pas->setIdLotacao((int)$get['lotacao']);
            $pas->setIdPessoaResp((int)$get['pessoa_resp']);
            $pas->setIdPessoaExec((int)$get['pessoa_exec']);
            $pas->setDtInicio($get['dt_inicio']);
            $pas->setDtFim($get['dt_fim']);
            $pas->setDsObservacao(trim($get['obs']));
            $pas->setIdPas((int)$get['id']);
            
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
            
            $pas = new Pas();            
            $pas->setIdPas((int)$get['id']);
            echo $pas->remover($perfil);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'pesquisaLotacaoAno':
        try {
                                
            $pas = new Pas();            
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            
            $idLotacao = (int)$get['lotacao'];
            $ano = (int)$get['ano'];
                                                           
            echo $pas->retornaTrPasLotacaoAnoPerfil($idLotacao, $ano, $perfil);                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'pesquisaLotacao':
        try {
            
            $pas = new Pas();            
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            
            $idLotacao = (int)$get['lotacao'];   
                                                                        
            echo $pas->retornaTrPasLotacaoPerfil($idLotacao, $perfil);                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
    
    case 'carregaFormularioPas':
        try {
            
            $pas = new Pas();            
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            
            $idPas = (int)$get['pas'];   
            $idLotacao = (int)$get['lotacao'];
            
            $pas->setIdPas($idPas);    
            $pas->setIdLotacao($idLotacao);
                        
            echo $pas->retornaDadosParaEdicao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'retornaPTAs':
        try {
            
            $pta = new Pta();            
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            
            $idPas = (int)$get['pas'];               
            
            $pta->setIdPas($idPas);            
                        
            echo $pta->retornaTrPorPasTelaPAS();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'enviarPlanejamento':
        try {
                         
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); 
            
            
            $pas = new Pas();
            $pas->setIdPas((int)$get['pas']);
            
            
            echo $pas->enviarPlanejamento($session->getIdUser(), trim($get['mensagem']), $perfil);                        
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'retornaValoresLiberado':
        try {
                         
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); 
            
            
            $pta = new PtaItem();                     
            
            echo $pta->retornaValoresLimitesPelaPAS((int)$get['pas']);                        
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    
        
}







?>
