<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/login/Login.class.php";





switch ($_REQUEST['acao']) {

    case 'logar':
        try {
            $session = new Session("ajaxSemAcesso");
            $usuario = trim(filter_input(INPUT_GET, 'login'));
            $senha = trim(filter_input(INPUT_GET, 'senha'));
            $login = new Login();
            $login->setUsuario($usuario);
            $login->setSenha($senha);          
            echo $login->Logar();

            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    
    case 'mudarSenhaLogin':
        try {
            $session = new Session("ajaxSemAcesso");
            $usuario = trim(filter_input(INPUT_GET, 'login'));
            //Nova Senha
            $senhaNova = trim(filter_input(INPUT_GET, 'senha'));
            $senhaR = trim(filter_input(INPUT_GET, 'senhaR'));
            //Senha Atual
            $senhaA = trim(filter_input(INPUT_GET, 'senhaA'));
            if($senhaNova != $senhaR){
                echo Metodos::retornoAjax("Erro", "alert", "Senhas não conferem.");
                return;                 
            }
            
            $login = new Login();
            $login->setUsuario($usuario);
            $login->setSenha($senhaA);
            $login->setSenhaNova($senhaNova);
            echo $login->mudarSenhaLogar();            
            
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
            
    case 'alterarSenha':
        try {
            $session = new Session();
            //Nova Senha
            $senhaNova = trim(filter_input(INPUT_POST, 'novaSenha'));
            $senhaR = trim(filter_input(INPUT_POST, 'repetirSenha'));
            //Senha Atual
            $senhaA = trim(filter_input(INPUT_POST, 'senhaAtual'));
            if($senhaNova != $senhaR){
                echo Metodos::retornoAjax("Erro", "alert", "Senhas não conferem.");
                return;                 
            }
            
            $login = new Login();
            $login->setIdPessoa($_SESSION['idUser']);
            $login->setSenha($senhaA);
            $login->setSenhaNova($senhaNova);
            echo $login->alterarSenha();            
            
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }


}

