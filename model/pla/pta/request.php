<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/Pta.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaTitulo.class.php";

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
            
            $pta = new Pta();           
            
            $pta->setNmPta(trim($get['nome']));
            $pta->setIdPas((int)$get['pas']);                        
            $pta->setDtInicio($get['dt_inicio']);
            $pta->setDtFim($get['dt_fim']);            
            echo $pta->cadastrar($perfil);
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
            
            $pta = new Pta();
                        
            $pta->setNmPta(trim($get['nome']));
            $pta->setIdPas((int)$get['pas']);                        
            $pta->setDtInicio($get['dt_inicio']);
            $pta->setDtFim($get['dt_fim']);            
            $pta->setIdPta((int)$get['id']);
            
            echo $pta->editar($perfil);
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
            
            $pta = new Pta();            
            $pta->setIdPta((int)$get['id']);
            echo $pta->remover($perfil);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'retornaBox':
        try {
                                
            $pta = new Pta();            
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            
            $pta->setIdPas((int)$get['pas']);            
                                                           
            echo $pta->retornaBoxPorPasComTitulos($perfil);                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
        
    case 'retornaProgramaTrabalho':
        try {
                     
            require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/ProgramaTrabalho.class.php";
            
            $pta = new PtaTitulo();            
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            
            $pta->setIdPta((int)$get['pta']);            
                                                           
            echo $pta->retornaOptionProgramaTrabalho();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'retornaPpaProjAti':
        try {
                     
            require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/PasAcao.class.php";
            
            $pta = new PtaTitulo();            
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            
            $pta->setIdPta((int)$get['pta']);            
                                                           
            echo $pta->retornaOptionPpaProjAti();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
       
    case 'cadTitulo':
        try {     
        
            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoAcao()){
                $perfil = 0;                
            }
            
            $pta = new PtaTitulo();            
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            
            $pta->setIdPta((int)$get['pta']);
            $pta->setNmPtaTitulo(trim($get['titulo']));
            $pta->setIdPpaProjAti((int)$get['ppa_proj_ati']);
            $pta->setIdProgramaTrabalho((int)$get['programa']);
            $pta->setDsJustificativa(trim($get['justificativa']));
            $pta->setDsObjeto(trim($get['objeto']));
            
            echo $pta->cadastrar($perfil);                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'edtTitulo':
        try {     
        
            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoAcao()){
                $perfil = 0;                
            }
            
            $pta = new PtaTitulo();            
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            
            $pta->setIdPtaTitulo((int)$get['id']);
            $pta->setNmPtaTitulo(trim($get['titulo']));
            $pta->setIdPpaProjAti((int)$get['ppa_proj_ati']);
            $pta->setIdProgramaTrabalho((int)$get['programa']);
            $pta->setDsJustificativa(trim($get['justificativa']));
            $pta->setDsObjeto(trim($get['objeto']));
            
            echo $pta->editar($perfil);                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'retornaDadosEdicaoPtaTitutlo':
        try {    
        
            require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/ProgramaTrabalho.class.php";
            require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/PasAcao.class.php";
        
            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoAcao()){
                $perfil = 0;                
            }
            
            $pta = new PtaTitulo();            
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            
            $pta->setIdPtaTitulo((int)$get['id']);                        
            echo $pta->retornaDadosParaEdicao();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'remTitulo':
        try {                        
        
            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoAcao()){
                $perfil = 0;                
            }
            
            $pta = new PtaTitulo();            
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);        
            
            $pta->setIdPtaTitulo((int)$get['id']);                        
            echo $pta->remover($perfil);                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
        
        
                        
}
?>
