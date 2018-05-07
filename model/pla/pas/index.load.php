<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas_resp/PasPesLot.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/lotacao.class.php";

$session = new Session();

$pas = new PasPesLot();
$lotacoes = "";

//Verifica se o Usuário tem perfil para mostrar todos as lotações ou somente as que estão autorizadas a ele.
if(!$session->vPPlanejamento()){ 
    if($session->vPPlanejamentoUsuario()){
        $lotacoes = $pas->retornaSelectLotacoes($session->getIdUser());
    }else{
        header("Location: /pages/index.php?permi=1");
    }
        
}else{
    $conexao = new Conexao();
    $pdo = $conexao->connect();
    
    $lotacao = new Lotacao();
    $lotacoes = $lotacao->retornaOptionLotacao($pdo);
       
}



?>
