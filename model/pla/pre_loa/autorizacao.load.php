<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pre_loa/PreLoa.class.php";

$session = new Session();
if(!$session->vPPlanejamentoPreLoa()){
    header("Location: /pages/index.php"); 
}


$ano = (int)filter_input(INPUT_GET, 'token', FILTER_DEFAULT);

if(empty($ano) 
        || strlen($ano) != 4){
    $ano = 0;
}

$estadoPreLoa = "Não Criada";
$situacaoPreLoa = "Aguardando ser Criada Pelo Planejamento.";
$mensagens = "";
$botaoDisabled = "disabled";

if($ano != 0){
    $preLoa = new PreLoa();
    $preLoa->setAaPreLoa($ano);
    $preLoa->verificaExisteCarregaDados();
    //Se for verificado que existe uma Pre-Loa ativa, então iremos carregar algumas informações dela.
    if(!empty($preLoa->getIdPreLoa())){
       $obj = $preLoa->stTextoItem($preLoa->getStPreLoa()); 
       $estadoPreLoa = $obj->msg;
       $situacaoPreLoa = $obj->aguardando;
       
       $mensagens = $preLoa->retornaMensagens();                            
       
       if($preLoa->stPodeAutorizarRetornar((int)$preLoa->getStPreLoa())){
            $botaoDisabled = "";
        }
       
       
       
       
    }
            
  
    
    
    
    
}




//if($ano != 0){
//    $mensagens = $loa->retornaMensagens($ano);
//}

?>
