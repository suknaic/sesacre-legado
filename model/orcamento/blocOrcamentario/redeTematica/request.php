<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/RedeTematica.class.php";

$sessao = new Session('ajax');
//obs: alterar verificação
if (!$sessao->vPPlanejamento()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    
    case 'cadastrarRede':
        try {
            $dados = filter_input(INPUT_GET, 'rede', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new RedeTematica();
            $classe->setNmRedeTematica($dados['nmRede']);
            $classe->setIdBlocOrcamentario($dados['idBloco']);
            
            echo $classe->cadastrarRedeTematica();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listarRede':
        try{
            $dados = filter_input(INPUT_GET, 'rede', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new RedeTematica();
            $classe->setNmRedeTematica($dados['nmRede']);
            $classe->setIdBlocOrcamentario($dados['idBloco']);
            
            echo $classe->listarRedeTematica();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'editarRede':
        try{
            $dados = filter_input(INPUT_GET, 'rede', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $verifica = $dados['verifica'];
            
            $classe = new RedeTematica();
            $classe->setIdRedeTematica($dados['idRede']);
            $classe->setNmRedeTematica($dados['nmRede']);
            $classe->setIdBlocOrcamentario($dados['idBloco']);
            
            echo $classe->editarRedeTematica($verifica);
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'removerRede':
        try{
            $dados = filter_input(INPUT_GET, 'rede', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new RedeTematica();
            $classe->setIdRedeTematica($dados['id']);
            $classe->setNmRedeTematica($dados['nm']);
            
            echo $classe->removerRedeTematica();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    
    case 'listarBloco':
        try {
            $bloco = filter_input(INPUT_GET, 'bloco', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new RedeTematica();
            $classe->setIdBlocOrcamentario($bloco['id']);
            
            echo $classe->listarBlocosOrcamentario();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    //==========================================================================================//
}
