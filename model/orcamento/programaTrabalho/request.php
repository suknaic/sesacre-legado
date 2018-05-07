<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/ProgramaTrabalho.class.php";

$sessao = new Session('ajax');
//obs: alterar verificação
if (!$sessao->vPPlanejamento()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    //ações de programa_trabalho
    case 'cadastrarProgTrab':
        try {
            $dados = filter_input(INPUT_GET, 'progTrab', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgramaTrabalho();
            $classe->setCdProgramaTrabalho($dados['cd']);
            $classe->setDsProgramaTrabalho($dados['ds']);
            $classe->setAaProgramaTrabalho($dados['aa']);
            $classe->setIdProgtrabFuncao($dados['func']);
            $classe->setIdProgTrabSubFuncao($dados['subFunc']);
            $classe->setIdProgTrabPrograma($dados['programa']);
            
            echo $classe->cadastrarProgramaTrabalho();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'listarProgTrab':
        try{
            $cod = filter_input(INPUT_GET, 'progTrab', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $classe = new ProgramaTrabalho();
            $classe->setCdProgramaTrabalho($cod['cd']);
            $classe->setDsProgramaTrabalho($cod['ds']);
            $classe->setAaProgramaTrabalho($cod['ano']);
            
            echo $classe->listarProgramaTrabalho();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'editarProgTrab':
        try{
            $dados = filter_input(INPUT_GET, 'progTrab', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgramaTrabalho();
            $cdVerifica = $dados['verifica'];
            $classe->setIdProgramaTrabalho($dados['id']);
            $classe->setCdProgramaTrabalho($dados['cd']);
            $classe->setDsProgramaTrabalho($dados['ds']);
            $classe->setAaProgramaTrabalho($dados['aa']);
            $classe->setIdProgtrabFuncao($dados['func']);
            $classe->setIdProgTrabSubFuncao($dados['subFunc']);
            $classe->setIdProgTrabPrograma($dados['programa']);
            
            echo $classe->editarProgramaTrabalho($cdVerifica);
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'removerProgTrab':
        try{
            $cod = filter_input(INPUT_GET, 'progTrab', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgramaTrabalho();
            $classe->setIdProgramaTrabalho($cod['id']);
            $classe->setCdProgramaTrabalho($cod['cd']);
            
            echo $classe->desativarProgramaTrabalho();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    //========================================================================================//
    //Ações de carregamente de comboBox
    case 'listaFuncoes':
        try {
            $cod = filter_input(INPUT_GET, 'progTrab', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        
            $classe = new ProgramaTrabalho();
            $classe->setIdProgtrabFuncao($cod['id']);
            
            echo $classe->carregaFuncoes();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'listaSubFuncoes':
        try {
            $cod = filter_input(INPUT_GET, 'progTrab', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgramaTrabalho();
            $classe->setIdProgTrabSubFuncao($cod['id']);
            
            echo $classe->carregaSubFuncoes();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'listaProgramas':
        try{
            $cod = filter_input(INPUT_GET, 'progTrab', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $classe = new ProgramaTrabalho();
            $classe->setIdProgTrabPrograma($cod['id']);
            
            echo $classe->carregaProgramas();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'retornaAno':
        try {

            $busAno = new Metodos();
            echo $busAno->retornaAnosSelect();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
    //==========================================================================================//
}
