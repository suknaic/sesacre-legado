<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/anexo/Anexo.class.php";

$session = new Session();
if (!$session->vPComprasTecAdmin()) {
    echo 'SessãoExpirada';
    return;
}
switch ($_POST['acao']) {
    case 'inserir_anexo':
        try {
            $idProcesso = $_POST['id_processo'];
            $arquivo = $_FILES['file']['name'];
            $arquivoTmp = $_FILES['file']['tmp_name'];
            $tipo = $_FILES['file']['type'];
            $tamanho = $_FILES['file']['size'];
            $erro = $_FILES['file']['error'];
            $tiposPermitidos = array('application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            $tamanhoPermitido = 1024 * 1024 * 7; // 7Mb
            $link = $arquivoTmp;



            if ($erro == 0) {
                //************************** Verifica se o arquivo é válido ************************
                if (array_search($tipo, $tiposPermitidos) === false) {
                    echo Metodos::retornoAjax("Erro", "alert", "O tipo de arquivo é inválido.");
                    return;
                }
                //**********************************************************************************
                //**************************** Verifica o tamanho do arquivo ************************
                if ($tamanho > $tamanhoPermitido) {
                    echo Metodos::retornoAjax("Erro", "alert", "O tamanho do arquivo é muito grande.");
                    return;
                }
                //***********************************************************************************
                
                $resultado = move_uploaded_file($arquivoTmp, $link);
                $binAnexo = fopen($arquivoTmp, 'rb');
                
                $upload = new Anexo();

                $upload->setIdProcesso((int) $idProcesso);
                $upload->setBinAnexo($binAnexo);
                $upload->setNomeAnexo($arquivo);
                $upload->setTipoAnexo($tipo);

                echo $upload->inserirAnexo($link);
                return;
            }
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case "carrega_anexos":
        try {
            //**** Carrega os anexos de um processo ****
            $id_processo = $_REQUEST['id_processo'];

            $anexo = new Anexo();
            $anexo->setIdProcesso((int) $id_processo);

            echo $anexo->carregarAnexos();
            return;
            //******************************************
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "excluir_anexos":
        try {
            //** Exclui o anexo de um processo **
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $class = new Anexo();
            $class->setIdAnexo($dados['id_anexo']);
            $class->setIdProcesso($dados['id_processo']);
            $class->setNomeAnexo($dados['anexo']);

            echo $class->excluirAnexo();
            return;
            //***********************************
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
