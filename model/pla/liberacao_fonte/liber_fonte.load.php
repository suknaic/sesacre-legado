<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/liberacao_fonte/LiberacaoFonte.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/ProgramaTrabalho.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Despesa.class.php";

$session = new Session();

if(!$session->vPPlanejamento()){
    header("Location: /pages/index.php?permi=1"); 
}

$idLiberacaoFonte = (int)filter_input(INPUT_GET, 'token', FILTER_DEFAULT);

if(empty($idLiberacaoFonte)){
    header("Location: /pages/index.php"); 
}

$conexao = new Conexao();
$pdo = $conexao->connect();

$lotacao = new Lotacao();
$selectLotacao = $lotacao->retornaOptionLotacao($pdo);

$liberacaoFonte = new LiberacaoFonte();
$liberacaoFonte->setIdLiberacaoFonte($idLiberacaoFonte);
$liberacaoFonte->carregaDados($pdo);
if(!$liberacaoFonte->Sucesso()){
    header("Location: /pages/index.php"); 
}



$programaTrabalho = new ProgramaTrabalho();
$programaTrabalho->setAaProgramaTrabalho($liberacaoFonte->getAaLiberacaoFonte());
$selectProgramaTrabalho = $programaTrabalho->retornaOptionSelectPorAno();


$despesa = new Despesa();
$selectDespesa = $despesa->retornaOptionDespesaElemento($pdo);


?>
