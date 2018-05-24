<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/orcamento/empenho/FinEmpenhoModel.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/financeiro/autorizacoes/FinAutorizacao.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";
$session = new Session();

$id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);


$finEmpenhoModel = new FinEmpenhoModel();
$finEmpenhoModel->setIdPedido($id);
$dados = $finEmpenhoModel->retornaDadosPedido();
$destinos = '';
$tabela = '';
$total = 0;
if (!empty($dados[0]["nr_item"])) {
    foreach ($dados as $l) {
        $tabela .= '<tr>
                <td class="text-center">' . $l["nr_item"] . '</td>
                <td class="text-center">' . $l["nm_material"] . '</td>
                <td class="text-center">' . $l["cd_desc_material"] . ' - ' . $l["nm_desc_material"] . '</td>
                <td class="text-center">' . $l["ds_itens"] . '</td>
                <td class="text-center">' . $l["nm_unidade_medida"] . '</td>    
                <td class="text-center">' . $l["tp_material"] . '</td>
                <td class="text-center">' . $l["cd_despesa"] . '-' . $l["ds_despesa"] . '</td>
                <td class="text-center">' . Metodos::ConverteValorBr($l["qt_itens_pre"], 4) . '</td>
                <td class="text-center">' . Metodos::ConverteValorBr($l["vl_itens_pre"], 4) . '</td>
                <td class="text-center">' . Metodos::ConverteValorBr($l["total"], 4) . '</td>
               </tr>';
        $total += $l["total"];
    }
    $total = Metodos::ConverteValorBr($total, 4);
    $tabela .= '<tr>
                <td colspan="9" class="text-right">Total</td>
                <td>' . $total . '</td>
            </tr>';
}

//Dados da diária
if ($dados[0]['id_tipo_gasto'] == 13) {
    $diaria = new Diaria();
    $diaria->setIdDiaria($diaria->verificaDiariaPedido($dados[0]['id_pedido']));
    $diariaObj = $diaria->retornaInfoDiariaPedido();
    foreach ($diariaObj as $linha) {
        $origem = $linha['origem'];
        $destino = $linha['destino'];
        $qtd = number_format ( $linha['qt_diaria_destino'] , 2 , ',' , '.' );
        $valor = number_format ( $linha['vl_diaria_destino'] , 2 , ',' , '.' );
        $hora_partida = $linha['dh_inicio'];
        $hora_chegada = $linha['dh_fim'];
        $destinos .= "<tr><td>$destino</td><td>$destino</td><td>$hora_partida</td><td>$hora_chegada</td><td>$qtd</td><td>$valor</td></tr>";
    }
}

//historico de autorizaçao
$finAutorizacao = new FinAutorizacao();
$finAutorizacao->setIdPedido($id);
