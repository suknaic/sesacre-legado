<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/gdof/DocTipoLotacao.class.php";

$session = new Session('ajax');

switch ($_REQUEST['acao']) {
    
    CASE 'cadastrarTipoLotacao':
        try {
                                
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $prog = new DocTipoLotacao();
            
            $prog->setNmDocTipoLotacao($filtro['nmTpLot']);
            
            
            echo $prog->cadastrar();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }    
    CASE 'alterarTipoLotacao':
        try {
                                
            $filtro = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                        
            
            $prog = new DocTipoLotacao();
            
            $prog->setIdDocTipoLotacao($filtro['idTpLot']);
            $prog->setNmDocTipoLotacao($filtro['nmTpLot']);
            
            
            echo $prog->alterar();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }    
    CASE 'removerTipoLotacao':
        try {
                                
            $filtro = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);                        
            
            $prog = new DocTipoLotacao();
            
            $prog->setIdDocTipoLotacao($filtro);
            
            
            echo $prog->excluir();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
    CASE 'retornaTiposLotacoes':
        try {
            $prog = new DocTipoLotacao();            
            echo $prog->listaTodos();
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }
}