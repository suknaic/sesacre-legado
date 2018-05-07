<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/ProgTrabFuncao.class.php";

$sessao = new Session('ajax');
//obs: alterar verificação
if (!$sessao->vPPlanejamento()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    //ações de prog_trab_funcao
    case 'cadastrarFuncao':
        try {
            $cod = filter_input(INPUT_GET, 'cdFuncao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgTrabFuncao();
            $classe->setCodFuncao($cod['codFunc']);
            
            echo $classe->cadastrarTrabFuncao();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listarFuncao':
        try{
            $cod = filter_input(INPUT_GET, 'funcao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new ProgTrabFuncao();
            $classe->setCodFuncao($cod['cd']);

            echo $classe->listarTrabFuncao();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'editarFuncao':
        try{
            $cod = filter_input(INPUT_GET, 'funcao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgTrabFuncao();
            $classe->setCodFuncao($cod['cd']);
            $classe->setIdCodFuncao($cod['id']);
            
            echo $classe->editarTrabFuncao();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    case 'removerFuncao':
        try{
            $cod = filter_input(INPUT_GET, 'funcao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgTrabFuncao();
            $classe->setIdCodFuncao($cod['id']);
            $classe->setCodFuncao($cod['cd']);
            
            echo $classe->removerTrabFuncao();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    //==========================================================================================//
}
