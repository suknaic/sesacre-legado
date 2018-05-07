<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";

$session = new Session();
if(!$session->vPQdd()){
    header("Location: /pages/index.php"); 
}

$ano = (int)filter_input(INPUT_GET, 'token', FILTER_DEFAULT);

if(empty($ano) 
        || strlen($ano) != 4){
    $ano = 0;
}

$botaoRemoverDisabled = "disabled";
$botaoCriarDisabled = "";
$existe = FALSE;

if($ano != 0){
    $qdd = new Qdd();
    $qdd->setAaQdd($ano);
    
    $qdd->verificaExisteCarregaDados();
        
    if(!empty($qdd->getIdQdd())){     
        $existe = TRUE;
        $botaoRemoverDisabled = "";         
        $botaoCriarDisabled = "disabled";        
    }                  
}


?>
