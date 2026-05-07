<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/unidade/Unidade.class.php";

    $sessão = new Session('ajax');

if (!$sessão->vPCompras()){
    echo 'SessaoExpirada';
    return;
}

switch ($_REQUEST['acao']){
    
    case 'cadastrar_Unidade':
        try {
        
            $filtro = filter_input(INPUT_GET, 'unidade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); 
           
            $novaUnidade = new Unidade();
            $novaUnidade->setUnidade($filtro['novaUnidade']);
            
            echo ($novaUnidade->cadastrarUnidade());
            return;
        
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listar_Unidade':
        try {
        
            $filtro = filter_input(INPUT_GET, 'pesquisaUnidade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $pesquisaUnidade = new Unidade();
            $pesquisaUnidade->setUnidade($filtro['unidade']);
            
            echo ($pesquisaUnidade->pesquisarUnidade($sessão));
            return;
            
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listar_Todas_Unidades':
        try {
            $unidade = new Unidade();
            
            echo $unidade->retornarTodasUnidades($sessão);
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'editar_Unidade':
        try {
            
            $filtro = filter_input(INPUT_GET,'editaUnidade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $editarUnidade = new Unidade();
            $editarUnidade->setUnidade($filtro['unidadeEdit']);
            $editarUnidade->setIdUnidade((int)$filtro['idUnidade']);
            
            echo ($editarUnidade->editarUnidade());
            return;
            
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'excluir_Unidade':
        try {
            
            $filtro = filter_input(INPUT_GET, 'excluirUnidade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $excluUnidade = new Unidade();
            $excluUnidade->setIdUnidade((int)$filtro['idUnidade']);
            
            echo ($excluUnidade->desativarUnidade());
            return;
            
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'listar_unidades_desativadas':
        try {
            $unidade = new Unidade();
            
            echo $unidade->UnidadesDesativadas();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'ativar_unidade':
        try {
            $id_unidade = filter_input(INPUT_GET, 'ativa_unidade', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $ativa = new Unidade();
            $ativa->setIdUnidade($id_unidade['uni']);
            
            echo $ativa->ativarUnidade();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}