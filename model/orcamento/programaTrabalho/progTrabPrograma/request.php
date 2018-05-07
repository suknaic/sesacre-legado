<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/ProgTrabPrograma.class.php";

$sessao = new Session('ajax');
//obs: alterar verificação
if (!$sessao->vPPlanejamento()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    //ações de prog_trab_programa
    case 'cadastrarPrograma':
        try {
            $cod = filter_input(INPUT_GET, 'cdPrograma', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgTrabPrograma();
            $classe->setCodPrograma($cod['cdProg']);
            
            echo $classe->cadastrarTrabPrograma();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listarPrograma':
        try{
            $cod = filter_input(INPUT_GET, 'programa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new ProgTrabPrograma();
            $classe->setCodPrograma($cod['cd']);
            
            echo $classe->listarTrabPrograma();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'editarPrograma':
        try{
            $cod = filter_input(INPUT_GET, 'programa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgTrabPrograma();
            $classe->setCodPrograma($cod['cd']);
            $classe->setIdCodPrograma($cod['id']);
            
            echo $classe->editarTrabPrograma();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'removerPrograma':
        try{
            $cod = filter_input(INPUT_GET, 'programa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgTrabPrograma();
            $classe->setIdCodPrograma($cod['id']);
            $classe->setCodPrograma($cod['cd']);
            
            echo $classe->removerTrabPrograma();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    //==========================================================================================//
}
