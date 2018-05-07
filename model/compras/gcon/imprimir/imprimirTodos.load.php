<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/processo/Processo.class.php";

$session = new Session();

if (!$session->vPCompras()) {
    header("Location: /pages/index.php");
} else {
    $ada = filter_input(INPUT_GET, 'ada', FILTER_DEFAULT);
    $pregao = filter_input(INPUT_GET, 'pregao', FILTER_DEFAULT);
    $ano = filter_input(INPUT_GET, 'ano', FILTER_DEFAULT);
    $situacao = filter_input(INPUT_GET, 'situacao', FILTER_DEFAULT);
    $modalidade = filter_input(INPUT_GET, 'modalidade', FILTER_DEFAULT);
    $tecnico = filter_input(INPUT_GET, 'tecnico', FILTER_DEFAULT);
    $tipoGasto = filter_input(INPUT_GET, 'categoria', FILTER_DEFAULT);
    $area = filter_input(INPUT_GET, 'area', FILTER_DEFAULT);
    $centrais = filter_input(INPUT_GET, 'centrais', FILTER_DEFAULT);
    
    $processo = new Processo();
    $processo->setAda($ada === 'null' || $ada === '' ? null : $ada);
    $processo->setNumePregao($pregao === 'null' || $ada === '' ? null : $pregao);
    $processo->setAno($ano === 'null' || $ano === '' ? null : $ano);
    $processo->setSituacao($situacao === 'null' || $situacao === '' ? null : $situacao);
    $processo->setModalidade($modalidade === 'null' || $situacao === '' ? null : $modalidade);
    $processo->setTecnico($tecnico === 'null' || $situacao === '' ? null : $tecnico);
    $processo->setTipoGasto($tipoGasto === 'null' || $tipoGasto === '' ? null : $tipoGasto);
    $processo->setArea($area === 'null' || $area === '' ? null : $area);
    $processo->setCentraisAtendimento($centrais === 'null' || $centrais === '' ? null : $centrais);
    $processo->setTabelaAnexo('nao');
    
    $todos = $processo->retornaProcesso($session);
    $html = "
        <html>
        <head>
            <style type='text/css' media='print'>
                    #brasao{width: 9%;margin: 0 auto;}
                    #landscape {page: land;}
                    #cabecalho{display:block;}
                    .cabecalho2{position: relative;text-align: center;margin-top: 1%;font-weight: bold;font-size: 9pt;}
                    .centro{text-align: center;}
                    .justificar{text-align: justify;}
                    .lateralDireita{text-align: right;}
                    .esquerda{float: left; width:30%; text-align: left;}
                    .direita{float:left; width:70%; text-align: left;}
                    .matricula{float:right; width:30%; text-align: right;}
                    .nome{float: left; width:50%;}
                    td{padding: 1%;ont-size: 9pt;text-align: center;border: 1px solid black;}
                    .table {margin-top: 2%;border-collapse: collapse;width: 100%;}
                    @page land {size: landscape;}
                    #landscape {page: land;}       
                    page toc { sheet-size: A4; }
                    body{font-family: arial;font-style: normal;font-variant: normal;font-size: 9pt;}
            </style>
        </head>
        <body>
            <div id='landscape'>
                <div id='cabecalho'>
                  <div id='brasao'><img src='http://localhost/assets/img/acrebrasao.jpg'></div>
                  <p class='cabecalho2'>
                    ESTADO DO ACRE
                  </p>
                </div>
                <br/>
                
                <table class='table'>
                <tr><td colspan='13'><b>LISTA DE PROCESSOS</b></td></tr>
                    <tr class='tudo'>
                        <td class='tudo'><b>Item</b></td>
                        <td class='tudo'><b>ADA / CPR</b></td>
                        <td class='tudo'><b>Categoria</b></td>
                        <td class='tudo'><b>Situação</b></td>
                        <td class='tudo'><b>Data Entrada</b></td>
                        <td class='tudo'><b>Modalidade</b></td>
                        <td class='tudo'><b>Pregão</b></td>
                        <td class='tudo'><b>Objeto</b></td>
                        <td class='tudo'><b>Central de Atendimento</b></td>
                        <td class='tudo'><b>Área de Abrangência</b></td>
                        <td class='tudo'><b>Valor Estimado</b></td>
                        <td class='tudo'><b>Valor Homologado</b></td>
                        <td class='tudo'><b>Técnico Responsável</b></td>
                    </tr>
                    ";
    $i = 1;
    foreach ($todos as $linhas) {
        $html .= "<tr>
                        <td>" . $i . "</td>
                        <td>" . $linhas['cd_ada_cpr'] . "</td>
                        <td>" . $linhas['nm_tipo_gasto'] . "</td>
                        <td>" . $linhas['nm_situacao'] . "</td>
                        <td>" . Metodos::ConverteDataBR($linhas['dt_processo']) . "</td>
                        <td class='justificar'>" . $linhas['nm_modalidade'] . "</td>
                        <td>" . $linhas['cd_pregao'] . "</td>
                        <td class='justificar'>" . $linhas['nm_objeto'] . "</td>
                        <td class='justificar'>" . $linhas['nm_centrais'] . "</td>
                        <td>" . $linhas['nm_cidade'] . "</td>
                        <td>" . Metodos::ConverteValorBr($linhas['vl_total_est'], 2) . "</td>
                        <td>" . Metodos::ConverteValorBr($linhas['vl_total_hom'], 2) . "</td>
                        <td>" . $linhas['nm_pessoa'] . "</td>
                    </tr>";
        $i++;
    }
    $html .= "
                </table>
            </div>
        </body>
    </html>";
}