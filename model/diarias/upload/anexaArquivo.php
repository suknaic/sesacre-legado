<?php

require_once $_SERVER['DOCUMENT_ROOT']."/class/util/Session.class.php";

$session = new Session();

try {
    
    $arquivo = $_FILES['arquivo']['name'];
    $arquivoTmp = $_FILES['arquivo']['tmp_name'];
    $tipo = $_FILES['arquivo']['type'];
//    $extensao = pathinfo($arquivo,PATHINFO_EXTENSION);
    $tamanho = $_FILES['arquivo']['size'];
    $erro = $_FILES['arquivo']['error'];
    $tiposPermitidos = array('image/jpeg', 'image/pjpeg', 'image/png','application/pdf','application/msword','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.openxmlformats-officedocument.presentationml.presentation');
    $tamanhoPermitido = 1024*1024*7; // 7Mb
//    $endereco = $_SERVER["DOCUMENT_ROOT"] .'/files/diarias/';

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
        } else{
            $nome = $arquivo;
            $link = $arquivoTmp;
            $resultado = move_uploaded_file($arquivoTmp, $link);
        }

        if($resultado){
            $array_anexo = array('id_anexo' => 0,'path_anexo' => $link, 'nm_anexo' => $nome , 'nm_mime_type' => $tipo);
            $linha_anexo = "<div class='form-group' data-anexo='". json_encode($array_anexo) ."'><div class='col-sm-5'><input type='text' value='". $nome ."' class='form-control' disabled></div><div class='col-sm-3'><a href='#' class='remove-anexo btn btn-danger'>X</a></div><br/><br/></div>";

            echo Metodos::retornoAjax("ok", "html", $linha_anexo);
            return ;
        }
    }
} catch (Exception $ex) {
    echo Metodos::retornoAjax("Erro", "console", $ex->getMessage());
    return;
}