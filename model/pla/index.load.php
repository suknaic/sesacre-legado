<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";


$session = new Session();

$msgPerm = "";
$permi = filter_input(INPUT_GET, 'permi');
if($permi == 1){
    $msgPerm = '  <div class="alert alert-warning">
                    <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
                    <strong>Alerta!</strong> Você Não possui Permissão para acessar essa Página.
                </div>';
}



//print_r($session->getPerfis());
//
//
//if($session->verificaPermissao(1)){
//  echo " POSSUI";
//}else{
//    echo " NÂOPOSSUI";
//}

?>
