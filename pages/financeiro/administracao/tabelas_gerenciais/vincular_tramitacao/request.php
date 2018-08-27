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
            
            if ($filtro['tpParmTramitacao'] == 1) {
                $prog->setIdDocTipoDestinatario((int)$filtro['idDocTpDestinatario']);
                $prog->setIdDocTipoRemetente((int)$filtro['idDocTpRemetente']);
            } else {
                //Se for receber, o destinatário é o ponto de partida, ou seja, a origem.
                //Por esse motivo será feito a troca quando for 'Receber'
                $prog->setIdDocTipoDestinatario((int)$filtro['idDocTpRemetente']);
                $prog->setIdDocTipoRemetente((int)$filtro['idDocTpDestinatario']);
            }
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

