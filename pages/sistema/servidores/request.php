<?php
/**
 * Created by PhpStorm.
 * User: elivelton
 * Date: 27/09/18
 * Time: 14:54
 */
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/servidor/Servidor.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/sistema/pessoa/Pessoa.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {

    case 'cadastrarFornecedor':
        try {

        }catch (Exception $e){
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'editarFornecedor':
        try {

        }catch (Exception $e){
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'listarFornecedor':
        try {
            $dados = filter_input(INPUT_POST, 'servidor', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
//            print_r($dados);
            $servidor = new Servidor();
            $servidor->setNmCivil($dados['nomeServidor']);
            $servidor->setNrCpf($dados['cpfServidor']);

            echo $servidor->listarFornecedor();
            return;
            break;
        }catch (Exception $e){
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'desativaFornecedor':
        try {

        }catch (Exception $e){
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}