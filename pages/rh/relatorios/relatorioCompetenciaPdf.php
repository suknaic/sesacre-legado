<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/rh/Contrato.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/class/lib/mpdf/vendor/autoload.php";
//*************************************************************************
$session = new Session('ajax');
if (!$session->vPRh()) {
    echo "SessaoExpirada";
    return;
}
if (!$session->vPRh()) {
    echo Metodos::retornoAjax("Erro", "alert", STR_PERMISSAO_ACAO);
    return;
}
//*****************************************************
$idFormacao = base64_decode($_GET["pesquisa"]);
//**************************************
//print_r($idFormacao);
//return false;
//**************************************
$banco = new Contrato();
$vinc = $banco->pesquisaRelatorioCompetencia($idFormacao);
if (empty($vinc)) {
    echo '<script language="javaScript">
              window.alert("Registros Não Encontrados.");
              window.close();
          </script>';
    return false;
}
//*****************************************************
$cabecalho ="<div class ='lateralLogo'>
                <img src='/assets/img/acrebrasao.jpg'>
            </div>
            <div class='esquerdaCabecalho'>
                <div class='esquerdaEmpresa'>
                    <b> " . "Secretaria Estadual de Saúde - SESACRE" . "</b>
                </div>
                <div class='lateral'>
                    " . "Rua Benjamim Constant, Nº 830 - Centro | 69900-062, Rio Branco - Acre" . " <br>
                    telefone (68) 3215-2631 / (68) 3215-2637 | ganinete.saude@ac.gov.br
                </div>
            </div>";
//*******************************************************************************************************************
$data = explode("-", date('Y-m-d'));
$dia = $data[2];
$mes = $data[1];
$ano = $data[0];
$meses = array(
    '01' => 'Janeiro',
    '02' => 'Fevereiro',
    '03' => 'Março',
    '04' => 'Abril',
    '05' => 'Maio',
    '06' => 'Junho',
    '07' => 'Julho',
    '08' => 'Agosto',
    '09' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembro',
    '12' => 'Dezembro');
//*****************************************************
//$mpdf = new mPDF();
$mpdf = new \Mpdf\Mpdf();
//*****************************************************
$html = "
        <html>
        <title>Relatório de Funcionário<title>
        <head>
        <meta charset='utf-8'>
        <style>
                    page toc { sheet-size: A4; }
                    body{
                        font-family: arial;
                        font-style: normal;
                        font-variant: normal;
                        font-size: 9pt;
                    }
                    
                    table {
                        margin-top: 3%;
                        border-collapse: collapse;
                        width: 100%;
                    }
                    table, td, tr{
                        border: 1px solid black;
                    }
                    tr, td{
                        padding: 1%;
                        font-size: 9pt;
                        text-align: center;
                    }
                    #cabecalho{
                      display:block;
                    }
                    .cabecalho2{
                      position: relative;
                      text-align: center;
                      margin-top: 1%;
                      font-weight: bold;
                      font-size: 9pt;
                    }
                    #logo{
                      width: 9%;
                      margin: 0 auto;
                    }
                    
                    #erro{
                    text-align: center;
                    
                    }
                   
                    .centro{
                     text-align: center;
                    }
                    
                    .lateralLogo{
                        width: 10%;
                        margin-left: 0%;
                        float: left;
                    }
                    
                    .lateralDireita{
                    text-align: right;
                    }
                    .esquerdaEmpresa{
                        font-size: 17pt;
                    }
                    .esquerdaCabecalho{
                        float: left; width:90%; text-align: center;
                    }
                    .esquerdaendereco{
                        float: left; width:90%; text-align: center;
                    }
                    .esquerda{
                        float: left; width:20%; text-align: left;
                    }
                    .direita{
                        float:right; width:50%; text-align: center;
                    }
                    .matricula{
                        float:right; width:30%; text-align: right;
                    }
                    .nome{
                        float: left; width:50%;
                    }
        </style>
        </head>
        <body> ";
$html .= $cabecalho;
//return false;
$html .= "  <br>          
            <hr>
            <div class='centro'>
                    <b>" . "RELATÓRIO DE FUNCIONÁRIOS - COMPETÊNCIA: "  . $vinc[0]['nm_escolaridade_formacao'] . "</b>
            </div><hr>
                <b>" . "VÍNCULO" . ": " . $vinc[0]['nm_vinculo'] . "</b><br> <hr>
               <b>=>". "LOTAÇÃO: " . $vinc[0]['nm_lotacao'] . "</b><br>
               <table>
                        <tr>
                            <td width=><b>" . "Nome" . "</b></td>
                            <td width=><b>Cargo</b></td>
                            <td width=><b>" . "Função" . "</b></td>
                            <td width=><b>C. H.</b></td>
                        </tr>";

$idVinc = $vinc[0]['id_vinculo'];
$idLot = $vinc[0]['id_lotacao'];
$somaQuantVinculo = 0;
$somaQuantLot = 0;
$totalGeral = 0;
foreach ($vinc as $linhas) {
    $totalGeral ++;
    if ($idVinc == $linhas['id_vinculo']) {
        if ($idLot == $linhas['id_lotacao']) {
            $somaQuantVinculo ++;
            $somaQuantLot ++;
            $html .= "
                        <tr> 
                            <td>" .
                                $linhas['nm_pessoa'] . "
                            </td>
                            <td>" .
                                $linhas['nm_cargo'] . "                                
                            </td>
                            <td>" .
                                $linhas['nm_funcao'] . "
                            </td>
                             <td>" .
                                $linhas['carga_horaria_lotacao'] . "
                            </td>
                        </tr>";
        } else {

            $html .= "   <tr>
                            <td colspan=3 align='right'><b>"."Quantidade p/Lotação" .":
                            <td><b>" . $somaQuantLot . "</td>
                        </tr>
                    </table>
                    <br>
                    <b>=>"."LOTAÇÃO: " . $linhas['nm_lotacao'] . "</b><br>
                    <table>
                        <tr>
                           <tr>
                            <td width=><b>" . "Nome" . "</b></td>
                            <td width=><b>Cargo</b></td>
                            <td width=><b>" . "Função" . "</b></td>
                            <td width=><b>C. H.</b></td>
                        </tr>
                        <tr> 
                            <td>" .
                                $linhas['nm_pessoa'] . "
                            </td>
                            <td>" .
                                $linhas['nm_cargo'] . "                                
                            </td>
                            <td>" .
                                $linhas['nm_funcao'] . "
                            </td>
                             <td>" .
                                $linhas['carga_horaria_lotacao'] . "
                            </td>
                        </tr>";
            $somaQuantLot = 0;
            $idLot = $linhas['id_lotacao'];
            $somaQuantLot ++;
            $somaQuantVinculo ++;
        }
    } else {

        $html .= "<tr>
                            <td colspan=3 align='right'><b>"."Quantidade p/Lotação:"."<br></td>
                            <td><b>" . $somaQuantLot . "</td>
                 </tr>
            </table>
            <hr>
            <div class='esquerda'><b>" . "Total p/Vínculo: </b></div><div class='esquerda'><b>" . $somaQuantVinculo . " Funcionários" . "</b> </div><div class='esquerda'></div>
            <br>
            <hr>";

        $mpdf->AddPage();
        $mpdf->WriteHTML($html);
$html = $cabecalho;
        $html .= "
                <hr>
                <b>" . "VÍNCULO: " . $linhas['nm_vinculo']. "</b><br>
                <hr>
                 <b>=> " . "LOTAÇÂO: " . $linhas['nm_lotacao'] . "</b><br>
                     <table>
                        <tr>
                            <td width=><b>" . "Nome" . "</b></td>
                            <td width=><b>Cargo</b></td>
                            <td width=><b>" . "Função" . "</b></td>
                            <td width=><b>C. H.</b></td>
                        </tr>
                        <tr> 
                             <td>" .
                                $linhas['nm_pessoa'] . "
                            </td>
                            <td>" .
                                $linhas['nm_cargo'] . "                                
                            </td>
                            <td>" .
                                $linhas['nm_funcao'] . "
                            </td>
                             <td>" .
                                $linhas['carga_horaria_lotacao'] . "
                            </td>
                        </tr>";
        $somaQuantLot = 0;
        $somaQuantVinculo = 0;
        $idLot = $linhas['id_lotacao'];
        $somaQuantLot ++;
        $somaQuantVinculo ++;
        $idVinc = $linhas['id_vinculo'];
        
    }
}

$html .= "      <tr>
                            <td colspan=3 align='right'><b>" . " Quantidade p/Lotação" . "</td>
                            <td><b>" . $somaQuantLot . "</td>
                </tr>
            </table>
            <hr>
            <div class='esquerda'><b>" . "Total p/ Vínculo: </b></div><div class='esquerda'><b>" . $somaQuantVinculo . " Funcionários" . "</b> </div><div class='esquerda'></div>
            <br>
            <hr>
            <div class='centro'><b>" . "Total Geral do Relatório: " . "</b> <b>" . $totalGeral . " Funcionários" . "</b> </div>
            <hr>
            <div align='center'><br><br><br>
                    " . "Relatório gerado em " . $dia . " de " . $meses[$mes] . " de " . $ano . " as " . date("H:i:s") . "  
            </div>
           </body>
    </html>";
$mpdf->AddPage();
$mpdf->WriteHTML($html);
$mpdf->debug = false;
$mpdf->SetTitle('Relatório de Funcionários - Competência');
$output = $mpdf->Output('Relatório de Funcionários - Competência.pdf', 'I');
exit();

//função para gerar a tabela
function pdf() {
    $pdo = conectar2();
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
