<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaTitulo.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto_categoria/TipoGastoCategoria.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaAcaoDet.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/unidade_medida/UnidadeMedida.class.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Fonte.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/liberacao_fonte/LiberacaoFonteUnidade.class.php";


$session = new Session();

//Token referente ao id da Lotação, caso não tenha irá direto para o index
$token = filter_input(INPUT_GET, 'token');

//Verifica se foi passado um token
if(!isset($_GET['token'])){
    header("location: /index.php");
}else{
    $idPtaTitulo = (int)($token); 
    if($idPtaTitulo == 0){
        header("location: /index.php");
    }
}

$conexao = new Conexao();
$pdo = $conexao->connect();

$ptaTitulo = new PtaTitulo();
$ptaTitulo->setIdPtaTitulo($idPtaTitulo);
$ptaTitulo->carregaDados($pdo);

if($ptaTitulo->getIdPas() == "" || $ptaTitulo == null){
    header("location: /index.php");
}

//Verifica se o Usuário tem perfil para visualizar o Pas ou se tem perfil master
if(!$session->vPPlanejamento()){      
    //Verifica se tem permissão para esse PAS
    if(!$ptaTitulo->verificaPermissaoPas($ptaTitulo->getIdPas(), $pdo)){
        header("location: /index.php");
    }    
}

//Token referente ao Id do Tipo de Gasto
$tokenT = filter_input(INPUT_GET, 'tokenT');

$idTipoGasto = 0;

if($tokenT != ""){
    $idTipoGasto = (int)$tokenT;
    if($idTipoGasto == 0){
        header("location: mem_calculo.php?token=".$ptaTitulo->getIdPtaTitulo());    
    }          
}


$tg = new TipoGasto();
$tg->setIdTipoGasto($idTipoGasto);
$tg->carregaDados();
if($tg->getNmTipoGasto() == ""){
    header("location: mem_calculo.php?token=".$idPta);
}

$nomeTipoGasto = $tg->getNmTipoGasto();

$optionTipoGasto = $tg->retornaOption($tg->getIdTipoGasto(), $pdo);

$ptaAcaoDet = new PtaAcaoDet();

$opDetalhamentoAcao = $ptaAcaoDet->retornaOPPorPtaPpaProjAti($ptaTitulo->getIdPta(), $ptaTitulo->getIdPpaProjAti(), $pdo);


$unid = new UnidadeMedida();
$selectUnidMed = $unid->retornaOptionSelect();
//
//
$anoPta = new DateTime($ptaTitulo->getDtInicio());

//$fonte = new Fonte();
//$selectFonte = $fonte->retornaOptionLiberUnidadeValor($ptaTitulo->getIdLotacao(), (int)$anoPta->format("Y"), $pdo);

$fonteLiberada = new LiberacaoFonteUnidade();
$fonteLiberada->setIdLotacao($ptaTitulo->getIdLotacao());
$fonteLiberada->setIdProgramaTrabalho($ptaTitulo->getIdProgramaTrabalho());
$selectFonte = $fonteLiberada->retornaOptionAnoLotacaoProgTrab((int)$anoPta->format("Y"), $pdo);



$selectTipoGastoCategoria = "";

$tipoGastoCategoria = new TipoGastoCategoria();
$selectTipoGastoCategoria = $tipoGastoCategoria->retornaOptionComLotacao($tg->getIdTipoGasto(), $pdo);

//$boxes = $tg->retornaBox();


//$pta = new Pta();
//
//$conexao = new Conexao();
//$pdo = $conexao->connect();
//
////Verifica se o Usuário tem perfil para visualizar o Pas ou se tem perfil master
//if(!$session->verifPermisPlanejamento()){
//        
//    //Verifica se tem permissão para esse PAS
//    if(!$pta->verificaPermissaoPta($idPas, $pdo)){
//        header("location: /index.php");
//    }    
//}
//


//$pas = new Pas();
//$pas->setIdPas($idPas);
//
////Retorna os dados das informações do PAS para serem utilizados no tab da página
//$lista = $pas->retornaList();
//
//$pas->carregaDados($pas->getIdPas());
//
//$nomePas = $pas->getNmPas();







?>
