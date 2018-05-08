<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/processo/Processo.class.php";

$session = new Session();
if (!$session->vPComprasTecAdmin()) {
    echo 'SessãoExpirada';
    return;
}
//switch ($_POST['acao']) {
//    case 'inserir_anexo':
        try {
            $idProcesso = $_POST['id_processo'];
            $arquivo = $_FILES['file']['name'];
            $arquivoTmp = $_FILES['file']['tmp_name'];
            $tipo = $_FILES['file']['type'];
            $tamanho = $_FILES['file']['size'];
            $erro = $_FILES['file']['error'];
            $tiposPermitidos = array('image/jpeg', 'image/pjpeg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation');
            $tamanhoPermitido = 1024 * 1024 * 7; // 7Mb
            $endereco = $_SERVER["DOCUMENT_ROOT"] . '/files/gcon/';

            if ($erro == 0) {
                if (array_search($tipo, $tiposPermitidos) === false) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", "O tipo de arquivo é inválido.");
                    echo $retorno;
                    return;
                }

                if ($tamanho > $tamanhoPermitido) {
                    $retorno = Metodos::retornoAjax("Erro", "alert", "O tamanho do arquivo é muito grande.");
                    echo $retorno;
                    return;
                } else {
                    $nome = $arquivo;
                    $link = '/files/gcon/' . md5($nome);
                    $resultado = move_uploaded_file($arquivoTmp, $endereco . md5($nome));
                }
                
                if ($resultado) {
                    $upload = new Processo();

                    $upload->setIdProcesso((int) $idProcesso);
                    $upload->setEndereco($link);
                    $upload->setNomeAnexo($nome);
                    
                    echo Metodos::retornoAjax($upload->upload());
                    return false;
                }
            }
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }
//}
