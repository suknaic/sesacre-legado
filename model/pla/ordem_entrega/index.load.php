<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas_resp/PasPesLot.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pas/Pas.class.php";

$session = new Session();

if(!$session->vPPlanejamentoUsuario()){
    header("Location: /pages/index.php"); 
}


$idLotacao = (int)filter_input(INPUT_GET, 'token', FILTER_DEFAULT);

if(empty($idLotacao)){
    $idLotacao = 0;
}

$lotacoes = "";

//Verifica se o Usuário tem perfil para mostrar todos as lotações ou somente as que estão autorizadas a ele.
if(!$session->vPPlanejamento()){ 
    if($session->vPPlanejamentoUsuario()){    
        $pas = new PasPesLot();
        $lotacoes = $pas->retornaSelectLotacoes($session->getIdUser());
    }else{
        header("Location: /pages/index.php?permi=1");
    }

}else{
    $conexao = new Conexao();
    $pdo = $conexao->connect();

    $pas = new Pas();
    $lotacoes = $pas->retornaOptionLotacaoExistePAS();    

}




?>
