<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/cha/administracao/status/Status.class.php";

$session = new Session('ajax');

if (!$session->verificaPermissao(PERFIL_TI)) {
    echo "SessaoExpirada";
    return;
}

switch ($_REQUEST['acao']) {

    case 'cadStatus':
        try {
            $get = filter_input(INPUT_GET, 'status', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $sta = new Status();
            $sta->setNmStatus(trim($get['nome']));
            
            echo $sta->cadastrarStatus();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'edtStatus':
        try {
            $get = filter_input(INPUT_GET, 'status', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $sta = new Status();
            $sta->setNmStatus(trim($get['nome']));
            $sta->setIdStatus((int) $get['id']);
            
            echo $sta->editarStatus();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }


    case 'remStatus':
        try {
            $get = filter_input(INPUT_GET, 'status', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $sta = new Status();
            $sta->setIdStatus((int) $get['id']);
            
            echo $sta->removerStatus();
            return;
            break;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
            break;
        }

    case 'desStatus':
        try {
            $get = filter_input(INPUT_GET, 'status', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $sta = new Status();
            $sta->setIdStatus((int) $get['id']);
            
            echo $sta->desativarStatus();
            return;
            break;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
            break;
        }

    case 'atiStatus':
        try {
            $get = filter_input(INPUT_GET, 'status', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $sta = new Status();
            $sta->setIdStatus((int) $get['id']);
            
            echo $sta->ativarStatus();
            return;
            break;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
            break;
        }

    case 'listaStatusTable':
        try {
            $sta = new Status();
            $sta->retornaTrStatus();

            echo $sta->getMsgRetorno();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
?>
