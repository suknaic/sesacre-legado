<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pta/PtaItem.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/tipo_gasto/TipoGasto.class.php";

$session = new Session();

if(!$session->vPPlanejamento()){
    header("Location: /pages/index.php?permi=1");        
} 


$lotacao = new Lotacao();

$selectUnidades = $lotacao->retornaOptionLotacaoPasExiste();

$tg = new TipoGasto();
$selectTipoGasto = $tg->retornaOption();


?>
