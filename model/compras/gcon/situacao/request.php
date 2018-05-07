<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/situacao/Situacao.class.php";

$sessao = new Session('ajax');

if (!$sessao->vPCompras()){
    echo 'SessaoExpirada';
    return;
}

switch ($_REQUEST['acao']) {
               
    case 'cadastrar_Situacao':
        try {
            
            $filtro = filter_input(INPUT_GET, 'cadSituacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $NovaSit = new Situacao();
            $NovaSit->setNova_Situacao($filtro['situacao']);
            
             echo $NovaSit->cadastrarSituacao();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }    
        
    case 'listar_Situacao':
        try {
            
            $Filtro = filter_input(INPUT_GET, 'PesqSituacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $pesq_situacao = new Situacao();
            $pesq_situacao->setPesq_Situacao($Filtro['situacao_pes']);
            
            echo $pesq_situacao->listarSituacao($sessao);
            return;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
        }
        
    case 'listar_Todas_Situacoes':
        try {
            
            $Filtro = filter_input(INPUT_GET, 'PesqSituacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $todasSit = new Situacao();
            
            echo $todasSit->retornarTodasSituacoes($sessao);
            return;
        } catch (Error $e) {
            echo Metodos::retornoAjax("Erro", "console", ErrorExcept::getError($e));
            return;
        }    
        
    case 'editar_Situacao':
        try {
            
            $Filtro = filter_input(INPUT_GET, 'EditSituacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
 
            $situ_edt = new Situacao();
            $situ_edt->setNova_Situacao($Filtro['situacao_pes']);
            $situ_edt->setIdSituacao($Filtro['id_situacao']);  
            echo $situ_edt->editarSituacao();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }  
    
    
    case 'excluir_Situacao':
        try {
            
            $Filtro = filter_input(INPUT_GET, 'ExcSituacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $situacaoDel = new Situacao();             
            $situacaoDel->setIdSituacao((int)$Filtro['id_situacao']);
            echo $situacaoDel->desativarSituacao();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'listar_situacao_desativadas':
        try {
            $situacao = new Situacao();
            
            echo $situacao->situacoesDesativadas();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case 'ativar_situacao':
        try {
            $id_situacao = filter_input(INPUT_GET, 'ativa_situacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            
            $situacao = new Situacao();
            $situacao->setIdSituacao($id_situacao['sit']);
            
            echo $situacao->ativarSituacao();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}

