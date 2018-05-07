<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/UsuarioContratos.class.php";

$sessão = new Session('ajax');

if (!$sessão->vPContratos()) {
    echo 'SessaoExpirada';
    return;
}

switch ($_REQUEST['acao']) {

    case 'cadastrar_Usuario':
        try {

            $usuario = filter_input(INPUT_GET, 'cadUsuario', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $usuarioContrato = new UsuarioContrato();
            $usuarioContrato->setIdUsuario($usuario['id_usuario']);
            $usuarioContrato->setIdPermissao($usuario['id_permissao']);

            echo $usuarioContrato->cadastrarUsuario();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listar_Usuarios':
        try {

            $usuario = new UsuarioContrato();
            echo $usuario->listarUsuarios();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'editar_Usuario':
        try {

            $filtro = filter_input(INPUT_POST, 'editaUsuario', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $usuario = new UsuarioContrato();
            $usuario->setIdUsuario((int) $filtro['idUsuario']);
            $usuario->setIdPermissao((int) $filtro['idPermissao']);
            $usuario->setIdPerfilPessoa((int) $filtro['idPerfilPessoa']);

            echo $usuario->editarRegistroUsuario();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'excluir_Usuario':
        try {

            $filtro = filter_input(INPUT_GET, 'excluir', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $usuario = new UsuarioContrato();
            $usuario->setIdPerfilPessoa((int) $filtro['idPerfilPessoa']);

            echo $usuario->excluirRegistroUsuario();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listar_Tecnicos':
        try {
            $filtro = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
            $usuario = new UsuarioContrato();
            echo $usuario->listarTecnicos($filtro);
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listar_Perfis':
        try {
            $filtro = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
            $perfis = new UsuarioContrato();
            echo $perfis->listarPerfis($filtro);
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
