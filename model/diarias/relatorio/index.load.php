<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Relatorio.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";

$session = new Session();
if(!$session->vPDiariasSolicitacao()){
    header("Location: /pages/index.php"); 
}


$relatorio = new Relatorio();
$diaria = new Diaria();

$id_diaria = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

$id_relatorio = 0;
$dh_inicio = '';
$dh_fim = '';
$origem = '';
$destino = '';
$ds_servico_executado = '';
$ds_locais_executado = '';
$dt_relatorio_destino = '';
$fl_retorno = '';
$linhasDestinos = '';
$linhasAnexos = '';

if ($id_diaria) {
 
    $diaria->setIdDiaria($id_diaria);   
    $dadosDiaria = json_decode($diaria->retornaDadosDiaria());
    
    //Inibir acesso ao relatório de viagem caso não esteja vinculado a um pedido de necessidade
    if (!$dadosDiaria->id_pedido) {
        header("Location: /pages/diarias/"); 
    }
    
    $id_relatorio = $dadosDiaria->id_relatorio;
    $relatorio->setIdRelatorio($id_relatorio);
    $relatorio->setIdDiaria($id_diaria);
    $dadosProposto = $relatorio->retornaDadosProposto();
    
    //Se encontrou já um relatório gerado
    if ($id_relatorio > 0) {
        $relatorio->setIdRelatorio($id_relatorio);
        $objRel = json_decode($relatorio->retornaDadosRelatorio());
        $ds_servico_executado = $objRel->ds_servico_executado;
        $ds_locais_executado = $objRel->ds_locais_executado; 
        $dt_relatorio_destino = $objRel->dt_relatorio_destino;
        $fl_retorno = $objRel->fl_retorno === 'S' ? 'checked' : '';

        $linhasDestinos = $relatorio->retornaTrsDestinos();
        $linhasAnexos = $relatorio->retornaAnexos();
    }
    
    
} else {
    $id_diaria = "";
}


$selectTransporteOption = $relatorio->retornaTransporteOption();
$selectTransporteTipoOption = $relatorio->retornaTransporteTipoOption();
