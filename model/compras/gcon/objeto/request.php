<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/objeto/Objeto.class.php";

    $session = new Session('ajax');
    
if (!$session->vPCompras()){
    echo 'SessaoExpirada';
    return;
}
switch ($_REQUEST['acao']) {
               
    case 'cadastrar_objeto':
        try {
        
            $filtro = filter_input(INPUT_GET, 'cadObjeto', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $cadastrar = new Objeto();
            $cadastrar->setObjeto($filtro['objeto']);
            
            echo $cadastrar->cadastrarObjeto();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }    
        
    case 'listar_Objeto':
        try {

            $filtro = filter_input(INPUT_GET, 'objeto', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $pesquisar = new Objeto();
            $pesquisar->setObjeto($filtro['objeto_pes']);

            echo $pesquisar->pesquisarObjeto($session);
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'editar_Objeto':
        try {
            
            $filtro = filter_input(INPUT_GET, 'objeto', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $editar = new Objeto();
            $editar->setObjeto($filtro['objeto_pes']);
            $editar->setIdObjeto((int) $filtro['id_objeto']);
            
            echo $editar->editarObjeto();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }  
    
    case 'excluir_Objeto':
        try {
            
            $filtro = filter_input(INPUT_GET, 'objeto', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $desativar = new Objeto();             
            $desativar->setIdObjeto((int)$filtro['id_objeto']);
            $desativar->setObjeto($filtro['objeto']);
            
            echo $desativar->removerObjeto();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listar_objetos_desativados':
        try {
            
            $objeto = new Objeto();
            
            echo $objeto->objetosDesativados();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'ativar_objeto':
        try {
            $id_objeto = filter_input(INPUT_GET, 'ativa_objeto', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $ativar = new Objeto();
            $ativar->setIdObjeto($id_objeto['obj']);
            
            echo $ativar->ativarOjeto();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    
    case 'listar_Todos_Objetos':
        try {
            $listar = new Objeto();

            echo $listar->listarTodosObjetos($session);
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
