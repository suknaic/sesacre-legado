<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Portaria.class.php";

$sessao = new Session('ajax');
//obs: alterar verificação
if (!$sessao->vPPlanejamento()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    
    case 'cadastrarPortaria':
        try {
            $dados = filter_input(INPUT_GET, 'portaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new Portaria();
            $classe->setNmPortaria($dados['nome']);
            $classe->setDtPortaria($dados['data']);
            $classe->setVlTotal($dados['valor']);
            $classe->setIdRedeTematica($dados['rede']);
            
            $classe->cadastrarPortaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listaraPortaria':
        try{
            $dados = filter_input(INPUT_GET, 'portaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new Portaria();
            $classe->setNmPortaria($dados['nm']);
            $classe->setIdRedeTematica($dados['id_rede']);
            
            echo $classe->listarPortaria();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'editarPortaria':
        try{
            $dados = filter_input(INPUT_GET, 'portaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $verifica = $dados['verifica'];
            
            $classe = new Portaria();
            $classe->setIdPortaria($dados['id']);
            $classe->setNmPortaria($dados['nome']);
            $classe->setDtPortaria($dados['data']);
            $classe->setVlTotal($dados['valor']);
            $classe->setIdRedeTematica($dados['rede']);
            
            $classe->editarPortaria($verifica);
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'removerPortaria':
        try{
            $dados = filter_input(INPUT_GET, 'portaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new Portaria();
            $classe->setIdPortaria($dados['id']);
            $classe->setNmPortaria($dados['nome']);
            
            $classe->desativarPortaria();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    
    case 'listarRedeTematica':
        try {
            $dados = filter_input(INPUT_GET, 'portaria', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new Portaria();
            $classe->setIdRedeTematica($dados['id']);
            
            $classe->listarRedeTematica();
            echo $classe->getMsgRetorno();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    //==========================================================================================//
}
