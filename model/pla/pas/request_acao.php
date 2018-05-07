<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/PasAcao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/eixo/Eixo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/diretriz/Diretriz.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/objetivo/Objetivo.class.php";
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
            
            $pas = new PasAcao();                                    
            $pas->setIdPas((int)$get['pas']);
            $pas->setDsParceria(trim($get['parceria']));
            $pas->setDsMetaProgramacao(trim($get['meta']));
            $pas->setDsIndicadorProgramacao(trim($get['indicador']));
            $pas->setIdPpaProjAti((int)$get['ppa_proj_ati']);            
            $pas->setIdAcao((int)$get['acao']);            
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
                        
            $pas = new PasAcao();                                                
            $pas->setIdPasAcao((int)$get['id']);
            $pas->setIdAcao((int)$get['acao']);
            $pas->setIdPpaProjAti((int)$get['ppa_proj_ati']);            
            $pas->setDsParceria(trim($get['parceria']));
            $pas->setDsMetaProgramacao(trim($get['meta']));
            $pas->setDsIndicadorProgramacao(trim($get['indicador']));                                    
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
            
            $pas = new PasAcao();            
            $pas->setIdPasAcao((int)$get['id']);
            echo $pas->remover($perfil);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'retornaPasAcao':
        try {
                                
            $pas = new PasAcao();            
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            
            $idPas = (int)$get['pas'];    
            $pas->setIdPas($idPas);
                                                           
            echo $pas->retornaTrPasAcao();                      
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
        
    case 'retornaSelectEixo':
        try {
        
            $dados = filter_input(INPUT_GET, 'dados');
            $dados = json_decode($dados);                                               
            $eixo = new Eixo();  
            
            echo $eixo->retornaOptionPorPpaProjAti((int)$dados->id);                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
    case 'retornaSelectAcao':
        try {
        
            $dados = filter_input(INPUT_GET, 'dados');
            $dados = json_decode($dados);                               
            $acao = new Acao();            
            echo $acao->retornaOptionAcaoPorEixoPas((int)$dados->id, (int)$dados->pas);                   
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
                        
            $pasAcao = new PasAcao(); 
            $pasAcao->setIdPasAcao((int)$dados['id']);
            
            echo $pasAcao->retornaDadosParaEdicao();                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }    
       
        
        
    case 'retornaSelectDiretrizNovo':
        try {
        
            $dados = filter_input(INPUT_GET, 'dados');
            $dados = json_decode($dados);                            
            $dir = new Diretriz();         
            $dir->setIdEixo($dados->id);
            echo $dir->retornaOptionPorEixo();                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'retornaSelectObjetivoNovo':
        try {
        
            $dados = filter_input(INPUT_GET, 'dados');
            $dados = json_decode($dados);                            
            $obj = new Objetivo();         
            $obj->setIdDiretriz($dados->id);
            echo $obj->retornaOptionPorDiretriz();                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
        
        
    case 'retornaAcoesUnidade':
        try {
                                                             
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            $acao = new Acao();       
            
            $idPas = (int)$get['pas'];    
                                                           
            echo $acao->retornaTrPorPasLotacao($idPas);                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }   
    
    case 'cadNovoAcao':
        try {
            
            if(!$session->vPPlanejamentoUsuarioAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
           
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $acao = new Acao();
            $acao->setIdObjetivo((int)$get['objetivo']);
            $acao->setIdLotacao((int)$get['lotacao']);
            $acao->setNmAcao(trim($get['acao']));
            $acao->setDsIndicador(trim($get['indicador']));
            $acao->setDsMetaPlano(trim($get['meta']));
            $acao->setTpCadastro("U");
            
            echo $acao->cadastrarAcao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtNovoAcao':
        try {
            
            if(!$session->vPPlanejamentoUsuarioAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
           
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $acao = new Acao();
            $acao->setIdObjetivo((int)$get['objetivo']);
            $acao->setIdLotacao((int)$get['lotacao']);
            $acao->setNmAcao(trim($get['acao']));
            $acao->setDsIndicador(trim($get['indicador']));
            $acao->setDsMetaPlano(trim($get['meta']));
            $acao->setTpCadastro("U");
            $acao->setIdAcao((int)$get['id']);
            
            echo $acao->editarAcao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
    case 'remNovoAcao':
        try {
        
            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoUsuarioAcao()){
                echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);                
                return;
            }
                        
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
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
        
    case 'retornaDadosEdicaoNovoAcao':
        try {
        
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);   
                        
            $acao = new Acao(); 
            $acao->setIdAcao((int)$dados['id']);
            
            echo $acao->retornaDadosParaEdicao();                   
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}







?>
