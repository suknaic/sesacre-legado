<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/BlocOrcamentario.class.php";

$sessao = new Session('ajax');
//obs: alterar verificação
if (!$sessao->vPPlanejamento()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    
    case 'cadastrarBloco':
        try {
            $nm = filter_input(INPUT_GET, 'bloco', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new BlocOrcametario();
            $classe->setNmBlocOrcamentario($nm['bloco']);
            
            echo $classe->cadastrarBlocOrcamentario();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case 'listarBloco':
        try {
            $nm = filter_input(INPUT_GET, 'bloco', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new BlocOrcametario();
            $classe->setNmBlocOrcamentario($nm['nm']);
            
            echo $classe->listarBlocOrcamentario();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
        
    case 'editarBloco':
        try {
            $dados = filter_input(INPUT_GET, 'bloco', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new BlocOrcametario();
            $classe->setNmBlocOrcamentario($dados['nm']);
            $classe->setIdBlocOrcamentario($dados['id']);
            
            echo $classe->editarBlocOrcamentario();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
        
    case 'removerBloco':
        try {
            $dados = filter_input(INPUT_GET, 'bloco', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new BlocOrcametario();
            $classe->setNmBlocOrcamentario($dados['nm']);
            $classe->setIdBlocOrcamentario($dados['id']);
            
            echo $classe->removerBlocOrcamentario();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
        
    //==========================================================================================//
}
