<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/processo/Processo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/objeto/Objeto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/situacao/Situacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/modalidade/Modalidade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/unidade/Unidade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/anotacao/Anotacao.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Metodos.class.php";

$session = new Session();

if (!$session->vPCompras()) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {

    case 'cadastra_processo':
        try {
            $filtro = filter_input(INPUT_POST, 'cadProcesso', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $cadastra = new Processo();

            $cadastra->setAda(trim($filtro['ada_process']));
            $cadastra->setUnidade((int) $filtro['uni_cont_process']);
            $cadastra->setValorEstimado($filtro['valor_estim_process']);
            $cadastra->setData($filtro['data_process']);
            $cadastra->setNumePregao(trim($filtro['nume_pregao_process']));
            $cadastra->setValorHomologado($filtro['val_homo_process']);
            $cadastra->setObjeto((int) $filtro['id_objeto']);
            $cadastra->setArea($filtro['id_area']);
            $cadastra->setSituacao((int) $filtro['id_situacao']);
            $cadastra->setModalidade((int) $filtro['id_modalidade']);
            $cadastra->setAnotacoes($filtro['anotacoes_process']);
            $cadastra->setUser($_SESSION['idUser']);
            $cadastra->setTecnico((int) $filtro['id_tecnico']);
            $cadastra->setCentraisAtendimento($filtro['centrais_atendimento']);
            $cadastra->setTipoGasto($filtro['id_tipo_gasto']);

            echo $cadastra->cadastraProcesso();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'edita_processo':
        try {
            $dados = filter_input(INPUT_POST, 'atualizaProcesso', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $edita = new Processo();
            $edita->setIdProcesso((int) $dados['id_processo']);
            $edita->setAda(trim($dados['ada_process']));
            $edita->setAdaTemp($dados['ada_temp']);
            $edita->setUnidade((int) $dados['id_unidade']);
            $edita->setValorEstimado($dados['valor_estim_process']);
            $edita->setData($dados['data_process']);
            $edita->setNumePregao(trim($dados['nume_pregao_process']));
            $edita->setValorHomologado($dados['val_homo_process']);
            $edita->setTipoGasto($dados['tipo_gasto']);
            $edita->setCentraisAtendimento($dados['centrais_atendimento']);
            $edita->setObjeto((int) $dados['id_objeto']);
            $edita->setArea($dados['id_area']);
            $edita->setSituacao((int) $dados['id_situacao']);
            $edita->setModalidade((int) $dados['id_modalidade']);
            $edita->setUser((int) $_SESSION['idUser']);
            $edita->setTecnico((int) $dados['id_tecnico']);

            echo $edita->editarProcesso();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'pesquisa_processo':
        try {
            $pesquisa = new Processo();

            $ada = filter_input(INPUT_POST, 'ada', FILTER_DEFAULT);
            $pregao = filter_input(INPUT_POST, 'pregao', FILTER_DEFAULT);
            $ano = filter_input(INPUT_POST, 'ano', FILTER_DEFAULT);
            $idSituacao = filter_input(INPUT_POST, 'situacao', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $idModalidade = filter_input(INPUT_POST, 'modalidade', FILTER_DEFAULT);
            $idTecnico = filter_input(INPUT_POST, 'tecnico', FILTER_DEFAULT);
            $tiposGasto = filter_input(INPUT_POST, 'tipoDeGasto', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $centrais = filter_input(INPUT_POST, 'centrais', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $idArea = filter_input(INPUT_POST, 'area', FILTER_DEFAULT);
            print_r($tiposGasto);
            $pesquisa->setAda($ada);
            $pesquisa->setNumePregao($pregao);
            $pesquisa->setAno($ano);
            $pesquisa->setSituacao($idSituacao);
            $pesquisa->setModalidade($idModalidade);
            $pesquisa->setTecnico($idTecnico);
            $pesquisa->setTipoGasto($tiposGasto);
            $pesquisa->setCentraisAtendimento($centrais);
            $pesquisa->setArea($idArea);
            $pesquisa->setTabelaAnexo('sim');

            echo $pesquisa->retornaProcesso($session);
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case 'exclui_processo':
        try {
            $filtro = filter_input(INPUT_POST, 'excluiProcesso', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $desativa = new Processo();
            $desativa->setIdProcesso((int) ($filtro['id']));
            $desativa->setAda($filtro['ada']);

            echo $desativa->desativarProcesso();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "retorna_tipo_de_gasto":
        try {
            $busCat = new TipoGasto();

            echo $busCat->retornaOption();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "retorna_objeto":
        try {
            $id_objeto = filter_input(INPUT_POST, 'id_objeto', FILTER_DEFAULT);

            $busObj = new Objeto();
            $busObj->setIdObjeto($id_objeto);

            echo $busObj->retornarSelectOption();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "retorna_todos_tecnicos":
        try {
            $id_tecnico = filter_input(INPUT_POST, 'id_tecnico', FILTER_DEFAULT);

            $reTec = new Processo();
            $reTec->setTecnico($id_tecnico);
            
            echo $reTec->retornarTodosTecnicosProcesso();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case "retorna_tecnicos_processo":
        try {
            $reTec = new Processo();

            echo $reTec->retornarTecnicosProcesso();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "retorna_area":
        try {

            $id_area = filter_input(INPUT_POST, 'id_area', FILTER_DEFAULT);

            $busArea = new Processo();
            $busArea->setArea($id_area);

            echo $busArea->retornarAreas();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "retorna_situacao":
        try {
            $id_situacao =  filter_input(INPUT_POST, 'id_situacao', FILTER_DEFAULT);

            $situacao = new Situacao;
            $situacao->setIdSituacao($id_situacao);

            echo $situacao->retornaSelectOption();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "retorna_modalidade":
        try {
            $id_modalidade = filter_input(INPUT_POST, 'id_modalidade', FILTER_DEFAULT);

            $modalidade = new Modalidade();
            $modalidade->setIdModalidade($id_modalidade);

            echo $modalidade->retornarSelectOption();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "retorna_ano":
        try {

            $busAno = new Metodos();
            echo '<option value="Todos">Todos</option>';
            echo $busAno->retornaAnosSelect();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }


    case "retorna_unidade":
        try {
            $idUnidade = filter_input(INPUT_POST, 'id_unidade', FILTER_DEFAULT);
            $unidade = new Unidade();
            $unidade->setIdUnidade($idUnidade);

            echo $unidade->retornarSelectOption();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "listar_processos_desativados":
        try {

            $processo = new Processo();

            echo $processo->processosDesativados();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "ativar_processo":
        try {

            $dados = filter_input(INPUT_POST, 'ativa_processo', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $processo = new Processo();
            $processo->setAda($dados['ada']);
            $processo->setIdProcesso($dados['idProcesso']);

            echo $processo->ativarProcesso();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "listar_anotacoes":
        try {
            $dados = filter_input(INPUT_POST, 'idProcesso', FILTER_DEFAULT);
            
            $anotacao = new Anotacao();
            $anotacao->setIdProcesso((int)$dados);
            
            echo $anotacao->retornarAnotacoes();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "adicionar_anotacao":
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $anotacao = new Anotacao();
            $anotacao->setIdProcesso($dados['id_processo']);
            $anotacao->setAnotacao($dados['anotacao']);

            echo $anotacao->cadastrarAnotacao();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "listar_centrais":
        try {

            $central = new Lotacao();

            echo $central->retornaOptionLotacao();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case "carrega_tipo_gasto_processo":
        try {
            $idProcesso = filter_input(INPUT_POST, 'id_processo', FILTER_DEFAULT);
            
            $processo = new Processo();
            $processo->setIdProcesso($idProcesso);
            
            echo $processo->carregarTipoGastoProcesso();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
        
    case "carrega_central_processo":
        try {
            $idProcesso = filter_input(INPUT_POST, 'id_processo', FILTER_DEFAULT);
            
            $processo = new Processo();
            $processo->setIdProcesso($idProcesso);
            
            echo $processo->carregarCentraisProcesso();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }    
}   


