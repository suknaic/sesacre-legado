<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/modalidade/Modalidade.class.php";

$session = new Session('ajax');

if(!$session->vPCompras()){
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
               
    case 'cadastrar_Modalidade':
        try {
            
            $Filtro = filter_input(INPUT_GET, 'cadModalidade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $cadMod = new Modalidade();
            $cadMod->setModalidade($Filtro['modalidade']);
            
            echo $cadMod->cadastrarModalidade();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }    
        
    case 'listar_Modalidade':
        try {
            
            $mod = filter_input(INPUT_GET, 'PesqModalidade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
         
            $modalidade = new Modalidade();
            $modalidade->setModalidade($mod['modalidade_pes']);
            
            echo $modalidade->listarModalidade($session);
            return;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
        }
    case 'listar_Todas_Modalidades':
        try {
            $modalidade = new Modalidade();
            
            echo $modalidade->retornarTodasModalidades($session);
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }    
        
    case 'editar_Modalidade':
        try {
            
            $mod = filter_input(INPUT_GET, 'editModalidade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
 
            $modalidade = new Modalidade();
            $modalidade->setModalidade($mod['modalidade_pes']);
            $modalidade->setIdModalidade($mod['id_modalidade']); 
            
            echo $modalidade->editarModalidade();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }  
    
    
    case 'excluir_Modalidade':
        try {
            
            $Filtro = filter_input(INPUT_GET, 'DelModalidade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $ModDel = new Modalidade();             
            $ModDel->setIdModalidade((int)$Filtro['id_modalidade']);
            
            echo $ModDel->removerModalidade();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'listar_modalidades_desativadas':
        try {
            $modalidade = new Modalidade();
            
            echo $modalidade->modalidadesDesativadas();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'ativar_modalidade':
        try {
            $id_modalidade = filter_input(INPUT_GET, 'ativa_modalidade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $ativa = new Modalidade();
            $ativa->setIdModalidade($id_modalidade['mod']);
            
            echo $ativa->ativarModalidade();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}

