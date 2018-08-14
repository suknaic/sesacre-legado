<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/itens/Itens.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gestao_contratos/ItemModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/contrato/FinContratoModel.class.php";


$session = new Session('ajax');

if (!$session->vPContratos()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {            
        

    CASE 'pesquisaProduto':
        try {
            
            $produto = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);
            $item = new Itens();
            $item->setNmDescMaterial($produto);
            echo $item->retornaTrPesquisaDescricaoItem();
            
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }

    CASE 'retornaContratos':
        try {
            
            $idMaterial = (int)filter_input(INPUT_GET, 'dados', FILTER_DEFAULT);            
            $iteModel = new ItemModel();
            $iteModel->setIdMaterial($idMaterial);
            echo $iteModel->retornaContratosPorMaterial();
            
            return;
            break;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
            break;
        }     
     
}
