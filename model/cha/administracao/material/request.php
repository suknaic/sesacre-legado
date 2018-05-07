<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/cha/administracao/material/Material.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/unidade_medida/UnidadeMedida.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
$session = new Session();

if (!$session->vPRh()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    case 'cadastrar_material':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $material = new Material();
            $material->setNmMaterial($dados['nm_material']);
            $material->setIdUnidadeMedida($dados['id_unidade_medida']);
            $material->setDtAquisicao($dados['data_aquisicao']);
            $material->setQtGarantia($dados['ds_garantia']);
            $material->setNmPatrimonio($dados['nm_patrimonio']);
            $material->setVlPreco($dados['valor']);
            $material->setDsModelo($dados['ds_modelo']);
            $material->setDsMarca($dados['ds_marca']);
            $material->setDsProcessador($dados['ds_processador']);
            $material->setQtHd($dados['ds_hd']);
            $material->setQtFonte($dados['ds_fonte']);
            $material->setWireless($dados['ds_wireless']);
            $material->setEstado($dados['tp_estado']);
            $material->setQtMemoriaRam($dados['qt_memoria_ram']);
            $material->setNmSerie($dados['nm_serie']);
            
            echo $material->cadastrarMaterial();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
        
    case 'pesquisar_material':
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $material = new Material();
            $material->setNmMaterial($dados['nm_material'] === '' ? null : $dados['nm_material']);
            $material->setNmSerie($dados['nm_serie'] == 0 ? null : $dados['nm_serie']);
            $material->setNmPatrimonio($dados['nm_patrimonio'] === '' ? null : $dados['nm_patrimonio']);
            
            echo $material->listarMateriais();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
    
    case 'editar_material':
        try {
            $dados = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $material = new Material();
            $material->setIdMaterial($dados['id_material']);
            $material->setNmMaterial($dados['nm_material']);
            $material->setIdUnidadeMedida($dados['id_unidade_medida']);
            $material->setDtAquisicao($dados['data_aquisicao']);
            $material->setQtGarantia($dados['ds_garantia']);
            $material->setNmPatrimonio($dados['nm_patrimonio']);
            $material->setVlPreco($dados['valor']);
            $material->setDsModelo($dados['ds_modelo']);
            $material->setDsMarca($dados['ds_marca']);
            $material->setDsProcessador($dados['ds_processador']);
            $material->setQtHd($dados['ds_hd']);
            $material->setQtFonte($dados['ds_fonte']);
            $material->setWireless($dados['ds_wireless']);
            $material->setEstado($dados['tp_estado']);
            $material->setQtMemoriaRam($dados['qt_memoria_ram']);
            $material->setNmSerie($dados['nm_serie']);
            
            echo $material->editarMaterial();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
        
    case 'deletar_material':
        try {
            $idMaterial = filter_input(INPUT_GET, 'idMaterial', FILTER_DEFAULT);
            
            $material = new Material();
            $material->setIdMaterial($idMaterial);
            
            echo $material->deletarMaterial();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
        
    case 'retornar_Unidades_De_Medida':
        try {
            $idUnidadeMedida = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);
            $unidades = new UnidadeMedida();
            $unidades->setIdUnidadeMedida($idUnidadeMedida);
            
            echo $unidades->retornaOptionSelect();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
}

