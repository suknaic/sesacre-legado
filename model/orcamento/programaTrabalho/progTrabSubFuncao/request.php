<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/ProgTrabSubFuncao.class.php";

$sessao = new Session('ajax');
//obs: alterar verificação
if (!$sessao->vPPlanejamento()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    //ações de prog_trab_programa
    case 'cadastrarSubFuncao':
        try {
            $cod = filter_input(INPUT_GET, 'subFuncao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgTrabSubFuncao();
            $classe->setCodSubFuncao($cod['cd']);
            
            echo $classe->cadastrarTrabSubFuncao();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listarSubFuncao':
        try{
            $cod = filter_input(INPUT_GET, 'subFuncao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new ProgTrabSubFuncao();
            $classe->setCodSubFuncao($cod['cd']);
            
            echo $classe->listarTrabSubFuncao();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'editarSubFuncao':
        try{
            $cod = filter_input(INPUT_GET, 'subFuncao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgTrabSubFuncao();
            $classe->setCodSubFuncao($cod['cd']);
            $classe->setIdCodSubFuncao($cod['id']);
            
            echo $classe->editarTrabSubFuncao();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'removerSubFuncao':
        try{
            $cod = filter_input(INPUT_GET, 'subFuncao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgTrabSubFuncao();
            $classe->setIdCodSubFuncao($cod['id']);
            $classe->setCodSubFuncao($cod['cd']);
            
            echo $classe->removerTrabSubFuncao();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    //==========================================================================================//
}
