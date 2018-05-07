<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/administracao/tipo_gasto/AdminTipoGasto.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    $session = new Session();
    
switch ($_REQUEST['acao']) {
    case 'cadastrar_tipo_gasto':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            
            $tipoGasto = new AdminTipoGasto();
            $tipoGasto->setNmTipoGasto($dados);
            
            echo $tipoGasto->cadastrarTipoGasto();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
        
    case 'listar_tipo_gasto':
        try {
            $tipoGasto = new AdminTipoGasto();
            
            echo $tipoGasto->listarTipoGasto();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
        
    case 'editar_tipo_gasto':
        try {
            $idTipoGasto = filter_input(INPUT_GET, 'idTipoGasto', FILTER_DEFAULT);
            $nmTipoGasto = filter_input(INPUT_GET, 'nmTipoGastoNovo', FILTER_DEFAULT);
            
            $tipoGasto = new AdminTipoGasto();
            $tipoGasto->setIdTipoGasto($idTipoGasto);
            $tipoGasto->setNmTipoGasto($nmTipoGasto);
            
            echo $tipoGasto->editarTipoGasto();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
        
    case 'desativar_tipo_gasto':
        try {
            $idTipoGasto = filter_input(INPUT_GET, 'idTipoGasto', FILTER_DEFAULT);
            
            $tipoGasto = new AdminTipoGasto();
            $tipoGasto->setIdTipoGasto($idTipoGasto);
            
            echo $tipoGasto->desativarTipoGasto();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
}       