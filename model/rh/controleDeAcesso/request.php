<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/PerfilRh.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
$session = new Session('ajax');

if (!$session->vPRh()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    case 'inserirUsuario':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $usuario = new PerfilRH();
            $usuario->setIdPerfil($dados['idPerfil']);
            $usuario->setIdPessoa($dados['idPessoa']);
            
            echo $usuario->inserirPerfilPessoaRH();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'listarPessoasPerfis':
        try {
            $usuario = New PerfilRH();
            
            echo $usuario->listarPessoaPerfilRH();
            return;
            break;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'removerPerfilPessoaRH':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $usuario = new PerfilRH();
            $usuario->setIdPerfil($dados['idPerfil']);
            $usuario->setIdPessoa($dados['idPessoa']);
            
            echo $usuario->deletarPerfilPessoaRH();
            return;
            break;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'listarPerfil':
        try {
            $usuario = new PerfilRH();
            echo "<option value='0' selected>Selecione um Perfil</option>";
            echo $usuario->retornarSelectOptionPerfisRH();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'listarPessoa':
        try {
            $prog = new Pessoa();
            echo "<option value='0' selected>Selecione uma Pessoa</option>";
            echo $prog->retornaOptionPessoa();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
