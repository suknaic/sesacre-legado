<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaAcaoDet.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaTitulo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItem.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/itens/Itens.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/liberacao_fonte/LiberacaoFonteUnidade.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/PasAlteracao.class.php";

$session = new Session('ajax');

//Irá determinar se o usuario pode ou não visualizar todos os PAS cadastrados
$perfil = 1;
if(!$session->vPPlanejamento()){
    $perfil = 0;
}



switch ($_REQUEST['acao']) {

    case 'salvar':
        try {

            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoUsuarioAcao()){
                $perfil = 0;
            }

            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
           
            $pta = new PtaItem();
            $pta->setIdPtaTitulo((int)$get['pta_titulo']);
            $pta->setIdPtaAcaoDet((int)$get['det_acao']);
            $pta->setCdMaterial((int)$get['material']);
            $pta->setIdUnidadeMedida((int)$get['unid_medida']);
            $pta->setQtPtaItem($get['quantidade']);
            $pta->setVlPtaItem($get['valor']);
            $pta->setIdTipoGastoCategoria((int)$get['tipo_gasto_categoria']);
            $pta->setIdFonte((int)$get['fonte']);
            $pta->setDsPtaItem(trim($get['descricao']));
            $pta->setIdTipoGasto((int)$get['tipo_gasto']);
            $pta->setTpFonte((int)$get['tp_fonte']);
            if(array_key_exists("portaria", $get)){
                $pta->setIdPortaria((int)$get['portaria']);            
            }
            if(array_key_exists("convenio", $get)){
                $pta->setIdConvenio((int)$get['convenio']);            
            }           
            echo $pta->salvar($session->getIdUser(), $perfil);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'editar':
        try {

            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoUsuarioAcao()){
                $perfil = 0;
            }

            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $pta = new PtaItem();
            $pta->setIdPtaItem((int)$get['id']);
            $pta->setIdPtaTitulo((int)$get['pta_titulo']);
            $pta->setIdPtaAcaoDet((int)$get['det_acao']);
            $pta->setCdMaterial((int)$get['material']);
            $pta->setIdUnidadeMedida((int)$get['unid_medida']);
            $pta->setQtPtaItem($get['quantidade']);
            $pta->setVlPtaItem($get['valor']);
            $pta->setIdTipoGastoCategoria((int)$get['tipo_gasto_categoria']);
            $pta->setIdFonte((int)$get['fonte']);
            $pta->setDsPtaItem(trim($get['descricao']));
            $pta->setIdTipoGasto((int)$get['tipo_gasto']);
            $pta->setTpFonte((int)$get['tp_fonte']);
            if(array_key_exists("portaria", $get)){
                $pta->setIdPortaria((int)$get['portaria']);            
            }
            if(array_key_exists("convenio", $get)){
                $pta->setIdConvenio((int)$get['convenio']);            
            }
           
            echo $pta->salvar($session->getIdUser(),$perfil);
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }


    case 'rem':
        try {

            //Perfil Zeus não pode cadastrar nada no sistema, somente visualizar
            if(!$session->vPPlanejamentoAcao()){
                $perfil = 0;
            }

            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $pta = new PtaItem();
            $pta->setIdPtaItem((int)$get['id']);            
            echo $pta->remover($session->getIdUser(), $perfil);
            
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }


    case 'listaInfo':
        try {

            $ptaTitulo = new PtaTitulo();

            $get = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

            $idPtaTitulo = (int)$get;
            $ptaTitulo->setIdPtaTitulo($idPtaTitulo);
            $ptaTitulo->carregaDados();
            echo $ptaTitulo->retornaList();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'infoDetAcao':
        try {


            $pad = new PtaAcaoDet();

            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $pad->setIdPtaAcaoDet((int)$get['det_acao']);

            echo $pad->retornaInfoPorDetAcao();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'pesquisaItem':
        try {

            

            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $itens = new Itens();
            $itens->setNmDescMaterial(trim($get['nome']));            
            echo $itens->retornaTrPorNomeDoItem();
            return;
            break;

        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'pesquisaItemPorCodigo':
        try {
            
            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            $itens = new Itens();
            if(is_numeric($get['nome'])){
                $itens->setCdDescMaterial((int)($get['nome']));
                echo $itens->retornaTrPorCodigoDescricao();
            }else{
                $itens->setNmItem(trim($get));
                echo $itens->retornaTrPorNomeDoItem();
            }

            return;
            break;

        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornaItens':
        try {           

            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            $pta = new PtaItem();
            $pta->setIdPtaTitulo((int)$get['pta_titulo']);
            $pta->setIdTipoGasto((int)$get['tipo_gasto']);            
            echo $pta->retornaTbDosItens();
            return;
            break;

        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'retornaDadosEdicao':
        try {           

            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            $pta = new PtaItem();
            $pta->setIdPtaItem((int)$get['id']);            
            echo $pta->retornaDadosParaEdicao();
            return;
            break;

        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    case 'retornaInfoDoItem':
        try {           

            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            $pta = new PtaItem();
            $pta->setIdPtaItem((int)$get['id']);            
            echo $pta->retornaInformacoesDoItem();
            return;
            break;

        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
    
        
        
    case 'retornaSelectPortConv':
        try {

            require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Portaria.class.php";
            require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Convenio.class.php";

            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $pta = new PtaItem();
            $pta->setIdFonte((int)$get['fonte']);

            echo $pta->retornaDivSelectOptionTelaItensPorFonte();
            return;
            break;

        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'retornaLimiteFonte':
        try {           

            $get = filter_input(INPUT_GET, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);            
            $pta = new PtaItem();            
            $pta->setIdPtaTitulo((int)$get['pta_titulo']);
            echo $pta->retornaLimiteValores();
            return;
            break;

        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
        




}







?>
