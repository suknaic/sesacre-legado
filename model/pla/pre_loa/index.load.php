<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/pla/pre_loa/PreLoa.class.php";

$session = new Session();
if(!$session->vPPlanejamento()){
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
$botaoEnviarPlanejamentoDisabled = "disabled";
$botaoRetornoPlanejamentoDisabled = "disabled";

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
       
        if($preLoa->stPodeEnviarPlanejamento((int)$preLoa->getStPreLoa())){
            $botaoEnviarPlanejamentoDisabled = "";
        }
        if($preLoa->getStPreLoa() >= $preLoa->stLoaEnviadaPeloPlanejamento()){
            $botaoRetornoPlanejamentoDisabled = "";
        }
       
       
       
    }
            
  
    
    
    
    
}




//if($ano != 0){
//    $mensagens = $loa->retornaMensagens($ano);
//}

?>
