<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocParmTramitacao.class.php";


$session = new Session('ajax');


switch ($_REQUEST['acao']) {
    CASE 'retornaParmTramitacoes':
        try {
            $prog = new DocParmTramitacao();            
            echo $prog->listaTodos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
        
    CASE 'cadastrarParmTramitacao':
        try {
                                
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $prog = new DocParmTramitacao();
            
            $prog->setIdDocTipoDestinatario((int)$filtro['idDocTpDestinatario']);
            $prog->setIdDocTipoRemetente((int)$filtro['idDocTpRemetente']);
            $prog->setIdDocumentoSituacao((int)$filtro['idDocSit']);
            $prog->setTpDocParmTramitacao((int)$filtro['tpParmTramitacao']);
            
            
            echo $prog->cadastrar();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }     
        
    CASE 'removerParmTramitacao':
        try {
                           
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);                        
            $prog = new DocParmTramitacao();            
            $prog->setIdDocParmTramitacao((int)$filtro);
            
            echo $prog->excluir();            
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}

