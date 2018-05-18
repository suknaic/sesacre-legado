<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";

$session = new Session();

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);


$finEmpenhoModel = new FinEmpenhoModel();
$finEmpenhoModel->setIdPedido($id);
$dados = $finEmpenhoModel->retornaDadosPedido();

$tabela = '';
$total = 0;
if(!empty($dados[0]["nr_item"])){
    
foreach ($dados as $l){
    $tabela .='<tr>
                <td class="text-center">'.$l["nr_item"].'</td>
                <td class="text-center">'.$l["nm_material"].'</td>
                <td class="text-center">'.$l["cd_desc_material"] . ' - ' . $l["nm_desc_material"].'</td>
                <td class="text-center">'.$l["ds_itens"].'</td>
                <td class="text-center">'.$l["nm_unidade_medida"].'</td>    
                <td class="text-center">'.$l["tp_material"].'</td>
                <td class="text-center">'.$l["cd_despesa"].'-'.$l["ds_despesa"].'</td>
                <td class="text-center">'.Metodos::ConverteValorBr($l["qt_itens_pre"],4).'</td>
                <td class="text-center">'.Metodos::ConverteValorBr($l["vl_itens_pre"],4).'</td>
                <td class="text-center">'.Metodos::ConverteValorBr($l["total"],4).'</td>
               </tr>';
    $total +=$l["total"];
} 
$total  = Metodos::ConverteValorBr($total,4);
$tabela .= '<tr>
                <td colspan="9" class="text-right">Total</td>
                <td>'.$total.'</td>
            </tr>';
}