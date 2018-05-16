<?php

    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
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
            $novoUsuario->setIdPessoa($usuario['id_usuario']);
            $novoUsuario->setIdPerfil($usuario['id_permissao']);
            
            echo $novoUsuario->inserirPerfilUsuarioGCON();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'listar_Todos_Usuarios':
        try {
        
            $usuario = new Usuario();
            
            echo $usuario->listarUsuariosGCON();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'excluir_Usuario':
        try {
            
            $filtro = filter_input(INPUT_GET, 'excluir', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
           
            $usuario = new Usuario();
            $usuario->setIdPessoa($filtro['idPessoa']);
            $usuario->setIdPerfil($filtro['idPerfil']);
            
            echo $usuario->deletarPerfilUsuarioGCON();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'listar_pessoas':
        try {
            $prog = new Pessoa();
            
            echo "<option value='0' selected>Selecione um usuário</option>";
            echo $prog->retornaOptionPessoa();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'listar_perfis':
        try {
            
            $perfis = new Usuario();
            
            echo "<option value='0' selected>Selecione uma permissão</option>";
            echo $perfis->retornarSelectOptionPerfisGCON();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
