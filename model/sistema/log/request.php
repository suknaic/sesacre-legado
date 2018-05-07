<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

$session = new Session('ajax');

if(!$session->verificaPermissao(PERFIL_TI)){
    echo "SessaoExpirada";
    return;
}



switch ($_REQUEST['acao']) {

    case 'listaLogTablePessoa':
        try {
        
            $pesquisa = filter_input(INPUT_GET, 'pesquisa', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);                         

            echo Log::retornaTrLogs($pesquisa);

            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

}







?>
