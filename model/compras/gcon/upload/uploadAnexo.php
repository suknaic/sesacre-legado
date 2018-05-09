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
            $tiposPermitidos = array('image/jpeg', 'image/pjpeg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation');
            $tamanhoPermitido = 1024 * 1024 * 7; // 7Mb
            $endereco = $_SERVER["DOCUMENT_ROOT"] . "/files/gcon/";

            if ($erro == 0) {
                if (array_search($tipo, $tiposPermitidos) === false) {
                    echo Metodos::retornoAjax("Erro", "alert", "O tipo de arquivo é inválido.");
                    return;
                }

                if ($tamanho > $tamanhoPermitido) {
                    echo Metodos::retornoAjax("Erro", "alert", "O tamanho do arquivo é muito grande.");
                    return;
                }
                
                $nome = $arquivo;
                $link = $endereco.md5($nome);
                $verifica = file_exists($link);
//                var_dump($verifica);
//                var_dump($link);
//                return;
                if ($verifica){
                    echo Metodos::retornoAjax("Erro", "alert", "Arquivo já Existe no Sistema.");
                    return;
                } else {
                    $resultado = move_uploaded_file($arquivoTmp, $endereco . md5($nome));
                }
                
                if (!$resultado) {
                    echo Metodos::retornoAjax("Erro", "alert", "Não Foi Possível Transferir o Arquivo.");
                    return;
                } else {
                    $upload = new Anexo();

                    $upload->setIdProcesso((int) $idProcesso);
                    $upload->setEndereco($link);
                    $upload->setNomeAnexo($nome);

                    echo $upload->inserirAnexo();
                    return;
                }
            }
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
            return;
        }

    case "carrega_anexos":
        try {

            $id_processo = $_REQUEST['id_processo'];

            $anexo = new Anexo();
            $anexo->setIdProcesso((int) $id_processo);

            echo $anexo->carregarAnexos();
            return;
        } catch (Exception $e) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }

    case "excluir_anexos":
        try {
            $dados = filter_input(INPUT_POST, 'dados', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

            $class = new Anexo();
            $class->setIdAnexo($dados['id_anexo']);
            $class->setIdProcesso($dados['id_processo']);
            $class->setNomeAnexo($dados['anexo']);

            echo $class->excluirAnexo();
            return;
        } catch (Exception $ex) {
            echo Metodos::retornoAjax("Erro", "console", $e->getMessage());
            return;
        }
}
