<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/DocDestinatario.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/VincDestinatario.class.php";

$session = new Session('ajax');


switch ($_REQUEST['acao']) {
    
    CASE 'retornaVinculoDestinatarios':
        try {
            $prog = new VincDestinatario();            
            echo $prog->listaTodos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
    CASE 'retornaDestinatarios':
        try {
            $filtro = filter_input(INPUT_GET,'dados', FILTER_DEFAULT);
            $prog = new DocDestinatario();
            $prog->setIdDocTipoDestinatario((int)$filtro);
            echo $prog->optionsDestinatario();
            return;
            break;
            
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'salvarVinculoDestinatario':
        try {
            $filtro = filter_input(INPUT_POST,'dados',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY);
            
            $prog = new VincDestinatario();
            $prog->setIdDocTipoDestinatario($filtro['idTipoDest'])
                 ->setIdLotacao($filtro['idLotacao'])
                 ->setIdPessoa($filtro['idPessoa']);
            
            echo $prog->cadastrar();
            return;
            break;
            
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'removerVinculoDestinatario':
        try {
                           
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);             
            
            $prog = new VincDestinatario();
            
            $prog->setIdVincDestinatario((int)$filtro);
            
            echo $prog->excluir();            
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}
