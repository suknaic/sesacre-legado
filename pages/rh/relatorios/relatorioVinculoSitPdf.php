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
$filtro = base64_decode($_GET["pesquisa"]);
//**************************************
$idVinculo = explode("-", $filtro)[0];
$idSitacao = explode("-", $filtro)[1];
$idSituacao = explode("-", $filtro)[2];
$mes = explode("-", $filtro)[3];
$ano = explode("-", $filtro)[4];
//**************************************
$banco = new Contrato();
$dados = $banco->pesquisaRelatorioSituacao($idVinculo, $idSitacao, $idSituacao, $mes, $ano, 2);

if (empty($dados)) {
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
                    <b>Secretaria Estadual de Saúde - SESACRE</b>
                </div>
                <div class='lateral'>
                    Rua Benjamim Constant, Nº 830 - Centro | 69900-062, Rio Branco - Acre<br>
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
                    <b>RELATÓRIO DE FÉRIAS, LICENÇAS E CONCESSÕES</b>
            </div><hr>
                <b>SITUAÇÃO: " .$dados[0]['nm_contrato_situacao']. "</b><br> <hr>
               <b>=>VÍNCULO: " .$dados[0]['nm_vinculo']. "</b><br>
               <table>
                        <tr>
                            <td width=><b>Matrícula</b></td>
                            <td width=><b>Lotação</b></td>
                            <td width=><b>Cargo</b></td>
                            <td width=><b>Nome</b></td>
                            <td width=><b>Inicio</b></td>
                            <td width=><b>Fim</b></td>
                            <td width=><b>Dias</b></td>
                        </tr>";
$idSit = $dados[0]['id_contrato_situacao'];
$idVinc = $dados[0]['id_vinculo'];
$somaQuantVinculo = 0;
$somaQuantLot = 0;
$totalGeral = 0;
foreach ($dados as $linhas) {
    $totalGeral ++;
    if ($idSit == $linhas['id_contrato_situacao']) {
        if ($idVinc == $linhas['id_vinculo']) {
            $somaQuantVinculo ++;
            $somaQuantLot ++;
            $html .= "
                        <tr> 
                             <td>" .
                                $linhas['nr_matricula']. "
                            </td>
                            <td>" .
                                $linhas['nm_lotacao']. "
                            </td>
                            <td>" .
                                $linhas['nm_cargo']. "                                
                            </td>
                            <td>" .
                                $linhas['nm_pessoa']. "
                            </td>
                            <td>" .
                                $linhas['dt_inicio']. "
                            </td>
                            <td>" .
                                $linhas['dt_fim']. "
                            </td>
                             <td>" .
                                $linhas['dias']. "
                            </td>
                        </tr>";
        } else {

            $html .= "   <tr>
                            <td colspan=6 align='right'><b>Quantidade p/ Vínculo:
                            <td><b>" . $somaQuantVinculo . "</td>
                        </tr>
                    </table>
                    <br>
                    <b>=>VÍNCULO: " .$linhas['nm_vinculo']. "</b><br>
                    <table>
                        <tr>
                           <tr>
                             <td width=><b>Matrícula</b></td>
                            <td width=><b>Lotação</b></td>
                            <td width=><b>Cargo</b></td>
                            <td width=><b>Nome</b></td>
                            <td width=><b>Inicio</b></td>
                            <td width=><b>Fim</b></td>
                            <td width=><b>Dias</b></td>
                        </tr>
                        <tr> 
                            <td>" .
                                $linhas['nr_matricula']. "
                            </td>
                            <td>" .
                                $linhas['nm_lotacao']. "
                            </td>
                            <td>" .
                                $linhas['nm_cargo']. "                                
                            </td>
                            <td>" .
                                $linhas['nm_pessoa']. "
                            </td>
                            <td>" .
                                $linhas['dt_inicio']. "
                            </td>
                            <td>" .
                                $linhas['dt_fim']. "
                            </td>
                             <td>" .
                                $linhas['dias']. "
                            </td>
                        </tr>";
            $somaQuantVinculo = 0;
            $idVinc = $linhas['id_vinculo'];
            $somaQuantLot ++;
            $somaQuantVinculo ++;
        }
    } else {

        $html .= "<tr>
                            <td colspan=6 align='right'><b>Quantidade p/Vínculos:<br></td>
                            <td><b>" . $somaQuantVinculo . "</td>
                 </tr>
            </table>
            <hr>
            <div class='esquerda'><b>Total p/Situações: </b></div><div class='esquerda'><b>" . $somaQuantLot . " Funcionários</b> </div><div class='esquerda'></div>
            <br>
            <hr>";

        $mpdf->AddPage();
        $mpdf->WriteHTML($html);
$html = $cabecalho;
        $html .= "
                <hr>
                <b>SITUAÇÃO: " .$linhas['nm_contrato_situacao']. "</b><br>
                <hr>
                 <b>=>VÍNCULO: " .$linhas['nm_vinculo']. "</b><br>
                     <table>
                        <tr>
                            <td width=><b>Matrícula</b></td>
                            <td width=><b>Lotação</b></td>
                            <td width=><b>Cargo</b></td>
                            <td width=><b>Nome</b></td>
                            <td width=><b>Inicio</b></td>
                            <td width=><b>Fim</b></td>
                            <td width=><b>Dias</b></td>
                        </tr>
                        <tr> 
                             <td>" .
                                $linhas['nr_matricula']. "
                            </td>
                            <td>" .
                                $linhas['nm_lotacao']. "
                            </td>
                            <td>" .
                                $linhas['nm_cargo']. "                                
                            </td>
                            <td>" .
                                $linhas['nm_pessoa']. "
                            </td>
                            <td>" .
                                $linhas['dt_inicio']. "
                            </td>
                            <td>" .
                                $linhas['dt_fim']. "
                            </td>
                             <td>" .
                                $linhas['dias']. "
                            </td>
                        </tr>";
        $somaQuantLot = 0;
        $somaQuantVinculo = 0;
        $idSit = $linhas['id_contrato_situacao'];
        $idVinc = $linhas['id_vinculo'];
        $somaQuantLot ++;
        $somaQuantVinculo ++;
        
        
    }
}

$html .= "      <tr>
                            <td colspan=6 align='right'><b> Quantidade p/ Vínculo</td>
                            <td><b>" . $somaQuantVinculo . "</td>
                </tr>
            </table>
            <hr>
            <div class='esquerda'><b>Total p/ Situações: </b></div><div class='esquerda'><b> . $somaQuantLot .  Funcionários</b> </div><div class='esquerda'></div>
            <br>
            <hr>
            <div class='centro'><b>Total Geral do Relatório: </b> <b>" . $totalGeral . " Funcionários</b> </div>
            <hr>
            <div align='center'><br><br><br>
                    Relatório gerado em " . $dia . " de " .$meses[$mes]. " de " . $ano . " as " . date("H:i:s") . "  
            </div>
           </body>
    </html>";
$mpdf->AddPage();
$mpdf->WriteHTML($html);
$mpdf->debug = false;
$mpdf->SetTitle('Relatório de Férias, Licenças e Concessões');
$output = $mpdf->Output('Relatório de Férias, Licenças e Concessões.pdf', 'I');
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

