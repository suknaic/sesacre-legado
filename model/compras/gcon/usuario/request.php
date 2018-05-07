<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/usuario/Usuario.class.php";

    $sessão = new Session('ajax');

if (!$sessão->vPCompras()){
    echo 'SessaoExpirada';
    return;
}

switch ($_REQUEST['acao']){
    
    case 'cadastrar_Usuario':
        try {
        
            $usuario = filter_input(INPUT_GET, 'cadUsuario', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY); 
            
            $novoUsuario = new Usuario();
            $novoUsuario->setIdUsuario($usuario['id_usuario']);
            $novoUsuario->setIdPermissao($usuario['id_permissao']);
            
            echo $novoUsuario->cadastrarUsuario();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listar_Usuarios':
        try {
        
            $usuario = new Usuario();
            
            echo $usuario->listarUsuarios();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'editar_Usuario':
        try {
            
            $filtro = filter_input(INPUT_GET,'editaUsuario', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $usuario = new Usuario();
            $usuario->setIdUsuario((int)$filtro['idUsuario']);
            $usuario->setIdPermissao((int)$filtro['idPermissao']);
            $usuario->setIdPerfilPessoa((int)$filtro['idPerfilPessoa']);
            
            echo $usuario->editarRegistroUsuario();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'excluir_Usuario':
        try {
            
            $filtro = filter_input(INPUT_GET, 'excluir', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $usuario = new Usuario();
            $usuario->setIdPerfilPessoa((int)$filtro['idPerfilPessoa']);
            
            echo $usuario->excluirRegistroUsuario();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'listar_Tecnicos':
        try {
            
            $usuario = new Usuario();
            
            echo $usuario->listarTecnicos();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'listar_Perfis':
        try {
            
            $perfis = new Usuario();
            
            echo $perfis->listarPerfis();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
