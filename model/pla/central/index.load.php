<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/FinCentralModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/central/CentralPessoa.class.php";

$session = new Session();
$lotacoes = "";

//Verifica se o Usuário tem perfil para mostrar todos as lotações ou somente as que estão autorizadas a ele.
//Se o Usuário Não tem Perfil da Central
if($session->vPPlanejamentoCentral()){
    $conexao = new Conexao();
    $pdo = $conexao->connect();
    if($session->vPPlanejamento()){     
        $lot = new FinCentralModel();        
        $lotacoes = $lot->retornaOptionsCentrais($pdo);
        $idLotacao = 0;              
    }else{
        //Retorna o Id da Lotação         
        $central = new CentralPessoa();
        $central->setIdPessoa($session->getIdUser());
        $central->carregaPorPessoa($pdo);
        if($central->Sucesso()){
            $idLotacao = $central->getIdLotacao();            
        }else{
            header("Location: /pages/index.php?permi=1");
        }
                        
    }
}else{
    header("Location: /pages/index.php?permi=1");
} 

?>
