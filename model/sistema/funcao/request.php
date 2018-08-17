<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/funcao.class.php";
       

$session = new Session('ajax');

if(!$session->verificaPermissao(PERFIL_TI)){
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
               
    case 'cadastrarFuncao':
        try {
                        
            $funcao = filter_input(INPUT_POST, 'funcao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $sesFuncao = new Funcao();
            $sesFuncao->setNm_funcao(trim($funcao['nome']));
            echo $sesFuncao->cadastrarFuncao();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'editarFuncao':
        try {
            
            $funcao = filter_input(INPUT_POST, 'funcao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $sesFuncao = new Funcao();
            $sesFuncao->setNm_funcao(trim($funcao['nome']));
            $sesFuncao->setId_funcao((int)$funcao['id']);
            echo $sesFuncao->editarFuncao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
    
    
    case 'removerFuncao':
        try {
                        
            $funcao = filter_input(INPUT_POST, 'funcao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $sesFuncao = new Funcao();
            $sesFuncao->setId_funcao((int)$funcao['id']);
            echo $sesFuncao->removerFuncao();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
     
    case 'desativarFuncao':
        try {
                        
            $funcao = filter_input(INPUT_POST, 'funcao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $sesFuncao = new Funcao();
            $sesFuncao->setId_funcao((int)$funcao['id']);
            echo $sesFuncao->desativarFuncao();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }    
        
    case 'ativarFuncao':
        try {
                        
            $funcao = filter_input(INPUT_POST, 'funcao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            
            $sesFuncao = new Funcao();
            $sesFuncao->setId_funcao((int)$funcao['id']);
            echo $sesFuncao->ativarFuncao();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }  
        
    case 'listaFuncaoTable':
        try {
        
            $sesFuncao = new Funcao();            
            echo $sesFuncao->retornaTrFuncao();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
}


?>
