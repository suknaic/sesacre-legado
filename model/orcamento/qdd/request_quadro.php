<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/Qdd.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/fin/QddValor.class.php";

$session = new Session('ajax');

if(!$session->vPQdd()){
    echo "SessaoExpirada";
    return;
}


switch ($_REQUEST['acao']) {                   
     
    case 'valores':
        try {
            
                        
            $qdd = new QddValor;            
            $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);    
            
            $qdd->setAno((int)$ano);
            echo $qdd->retornaQdd();                      
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }
        
        
    
        
        
        
}







?>
