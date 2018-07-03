<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/central/CentralResponsavel.class.php";

$session = new Session('ajax');

if(!$session->vPDiariasPermissoes()){
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {
    case 'cadCentralRespDiaria':
        try {
            
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

}