<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/itens/Itens.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/ItemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/FinFornecedorModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/unidade_medida/UnidadeMedida.class.php";
$session = new Session('ajax');

if (!$session->vPContratos()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {

    case 'pesquisaItemPorCodigo':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $itens = new Itens();
            if (is_numeric($get)) {
                $itens->setCdDescMaterial(trim($get));
                echo $itens->retornaTrPorCodigoDescricao();
            } else {
                $itens->setNmDescMaterial(trim($get));
                echo $itens->retornaTrPorNomeDoItem();
            }

            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'cadastroItem':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $itemModel = new ItemModel();
            $itemModel->setNrItem($get['itemNumero']);
            $itemModel->setNrLote($get['lote']);
            $itemModel->setNmMarca($get['marca']);
            $itemModel->setNmModelo($get['modelo']);
            $itemModel->setDescItem($get['desc_item']);
            $itemModel->setQtItens($get['qtd']);
            $itemModel->setVlItens($get['valor_unitario']);
            $itemModel->setPcDesconto($get['pc_desconto']);
            $itemModel->setCdDescMaterial($get['codigo']);
            $itemModel->setIdFornecedor($get['id']);
            $itemModel->setIdContItensAlt($get['id_alt']);
            $itemModel->setIdUnidadeMedida($get['unidadeMedida']);
            echo $itemModel->cadastrarItem();

            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornatrItens':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $itemModel = new ItemModel();
            $itemModel->setIdFornecedor($get['id']);
            echo $itemModel->retornaTrAcaoItem();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornaDadosEdicao':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $itemModel = new ItemModel();
            $itemModel->setIdContItens($get['idItem']);
            echo $itemModel->retornaDados();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornaUnidadeDeMedida':
        try {
            $unidadeMedida = new UnidadeMedida();
            echo '<option value="" selected>Selecione uma unidade de medida</option>';
            echo $unidadeMedida->retornaOptionSelect();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'edicaoItem':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $itemModel = new ItemModel();
            $itemModel->setNrItem($get['itemNumero']);
            $itemModel->setIdContItens($get['idItem']);
            $itemModel->setCdDescMaterial($get['codigo']);
            $itemModel->setIdFornecedor($get['id']);
            $itemModel->setNrLote($get['lote']);
            $itemModel->setNmMarca($get['marca']);
            $itemModel->setNmModelo($get['modelo']);
            $itemModel->setQtItens($get['qtd']);
            $itemModel->setVlItens($get['valor_unitario']);
            $itemModel->setPcDesconto($get['pc_desconto']);
            $itemModel->setDescItem($get['desc_item']);
            $itemModel->setIdContItensAlt(is_numeric($get['id_alt']) ? $get['id_alt'] : null);
            $itemModel->setIdUnidadeMedida($get['unidadeMedida']);
            echo $itemModel->editarItem();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'edicaoItemAtaContrato':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $itemModel = new ItemModel();
            $itemModel->setNrItem($get["itemNumero"]);
            $itemModel->setIdContItens($get['idItem']);
            $itemModel->setCdDescMaterial($get['codigo']);
            $itemModel->setIdFornecedor($get['id']);
            $itemModel->setNrLote($get['lote']);
            $itemModel->setNmMarca($get['marca']);
            $itemModel->setNmModelo($get['modelo']);
            $itemModel->setQtItens($get['qtd']);
            $itemModel->setVlItens($get['valor_unitario']);
            $itemModel->setPcDesconto($get['pc_desconto']);
            $itemModel->setIdUnidadeMedida($get['unidadeMedida']);
            echo $itemModel->editarItemAtaContrato();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'excluirItem':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $itemModel = new ItemModel();
            $itemModel->setIdContItens($get['idItem']);
            echo $itemModel->excluirItem();
            return;
            break;
        } catch (Exeception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornatrItensAtaContrato':
        try {
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $itemModel = new ItemModel();
            $itemModel->setIdFornecedor($get['id']);
            echo $itemModel->retornaTrAtaContrato();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'cadastroItemAtaContrato':
        try {
            $get = filter_input(INPUT_POST, 'itens', FILTER_DEFAULT);
            $get = json_decode($get);
            $itemModel = new ItemModel();
            echo $itemModel->cadastraItemAtaContrato($get);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
}
