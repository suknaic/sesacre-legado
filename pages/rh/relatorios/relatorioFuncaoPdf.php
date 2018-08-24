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
$idCargulo = explode("-", $filtro)[0];
$idLotacao = explode("-", $filtro)[1];
$idCargo = explode("-", $filtro)[2];
$idFuncao = explode("-", $filtro)[3];
$dataInicio = explode("-", $filtro)[4];
$dataFim = explode("-", $filtro)[5];
//**************************************
$banco = new Contrato();
$rs = $banco->pesquisaRelatorioVinculo($idCargulo, $idLotacao, $idCargo, $idFuncao, $dataInicio, $dataFim, 3);
//print_r($rs);
//return FALSE;
if (empty($rs)) {
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
                    <b> " . utf8_decode("Secretaria Estadual de Saúde - SESACRE") . "</b>
                </div>
                <div class='lateral'>
                    " . utf8_decode("Rua Benjamim Constant, Nº 830 - Centro | 69900-062, Rio Branco - Acre") . " <br>
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
                    <b>" . utf8_decode("RELATÓRIO DE FUNCIONÁRIOS POR FUNÇÂO") . "</b>
            </div><hr>
                <b>" . utf8_decode("FUNÇÃO") . ": " . utf8_decode($rs[0]['nm_funcao']) . "</b><br> <hr>
               <b>=>". utf8_decode("LOTAÇÃO: ") . utf8_decode($rs[0]['nm_lotacao']) . "</b><br>
               <table>
                        <tr>
                            <td width=><b>" . utf8_decode("Matrícula") . "</b></td>
                            <td width=><b>" . utf8_decode("Nome") . "</b></td>
                            <td width=><b>" . utf8_decode("Vínculo") . "</b></td>
                            <td width=><b>" . utf8_decode("Cargo") . "</b></td>
                            <td width=><b>C. H.</b></td>
                        </tr>";
$idLot = $rs[0]['id_lotacao'];
$idFunc = $rs[0]['id_funcao'];
$somaQuantFuncao = 0;
$somaQuantLot = 0;
$totalGeral = 0;
foreach ($rs as $linhas) {
    $totalGeral ++;
    if ($idFunc == $linhas['id_funcao']) {
        if ($idLot == $linhas['id_lotacao']) {
            $somaQuantLot ++;
            $somaQuantFuncao ++;
            
            $html .= "
                        <tr> 
                            <td>" .
                    utf8_decode($linhas['nr_matricula']) . "
                            </td>
                            <td>" .
                    utf8_decode($linhas['nm_pessoa']) . "
                            </td>
                            <td>" .
                    utf8_decode($linhas['nm_vinculo']) . "                                
                            </td>
                            <td>" .
                    utf8_decode($linhas['nm_cargo']) . "
                            </td>
                             <td>" .
                    utf8_decode($linhas['carga_horaria_lotacao']) . "
                            </td>
                        </tr>";
        } else {

            $html .= "   <tr>
                            <td colspan=4 align='right'><b>".utf8_decode("Quantidade p/Lotação").":
                            <td><b>" . $somaQuantLot . "</td>
                        </tr>
                    </table>
                    <br>
                    <b>=>".utf8_decode("LOTAÇÂO: ") . utf8_decode($linhas['nm_lotacao']) . "</b><br>
                    <table>
                        <tr>
                           <tr>
                            <td width=><b>" . utf8_decode("Matrícula") . "</b></td>
                            <td width=><b>" . utf8_decode("Nome") . "</b></td>
                            <td width=><b>" . utf8_decode("Vínculo") . "</b></td>
                            <td width=><b>" . utf8_decode("Cargo") . "</b></td>
                            <td width=><b>C. H.</b></td>
                        </tr>
                        <tr> 
                            <td>" .
                    utf8_decode($linhas['nr_matricula']) . "
                            </td>
                            <td>" .
                    utf8_decode($linhas['nm_pessoa']) . "
                            </td>
                            <td>" .
                    utf8_decode($linhas['nm_vinculo']) . "                                
                            </td>
                            <td>" .
                    utf8_decode($linhas['nm_cargo']) . "
                            </td>
                             <td>" .
                    utf8_decode($linhas['carga_horaria_lotacao']) . "
                            </td>
                        </tr>";
            $somaQuantLot = 0;
            $idLot = $linhas['id_lotacao'];
            $somaQuantLot ++;
            $somaQuantFuncao ++;
        }
    } else {

        $html .= "<tr>
                            <td colspan=4 align='right'><b>".utf8_decode("Quantidade p/Lotações:")."<br></td>
                            <td><b>" . $somaQuantLot . "</td>
                 </tr>
            </table>
            <hr>
            <div class='esquerda'><b>" . utf8_decode("Total p/Funções: </b></div><div class='esquerda'><b>") . $somaQuantFuncao . utf8_decode(" Funcionários") . "</b> </div><div class='esquerda'></div>
            <br>
            <hr>";

        $mpdf->AddPage();
        $mpdf->WriteHTML(utf8_encode($html));
$html = $cabecalho;
        $html .= "
                <hr>
                <b>" . utf8_decode("FUNÇÃO") . ": " . utf8_decode($linhas['nm_funcao']). "</b><br>
                <hr>
                 <b>=> " . utf8_decode("LOTAÇÂO: ") . utf8_decode($linhas['nm_lotacao']) . "</b><br>
                     <table>
                        <tr>
                            <td width=><b>" . utf8_decode("Matrícula") . "</b></td>
                            <td width=><b>" . utf8_decode("Nome") . "</b></td>
                            <td width=><b>" . utf8_decode("Vínculo") . "</b></td>
                            <td width=><b>" . utf8_decode("Cargo") . "</b></td>
                            <td width=><b>C. H.</b></td>
                        </tr>
                        <tr>
                            <td>" .
                    utf8_decode($linhas['nr_matricula']) . "
                            </td>
                            <td>" .
                    utf8_decode($linhas['nm_pessoa']) . "
                            </td>
                            <td>" .
                    utf8_decode($linhas['nm_vinculo']) . "                                
                            </td>
                            <td>" .
                    utf8_decode($linhas['nm_cargo']) . "
                            </td>
                             <td>" .
                    utf8_decode($linhas['carga_horaria_lotacao']) . "
                            </td>
                        </tr>";
        $somaQuantLot = 0;
        $somaQuantFuncao = 0;
        $idLot = $linhas['id_lotacao'];
        $idFunc = $linhas['id_funcao'];
        $somaQuantLot ++;
        $somaQuantFuncao ++;
        
        
    }
}

$html .= "      <tr>
                            <td colspan=4 align='right'><b>" . utf8_decode(" Quantidade p/Lotação"). "</td>
                            <td><b>" . $somaQuantLot . "</td>
                </tr>
            </table>
            <hr>
            <div class='esquerda'><b>" . utf8_decode("Total p/Função: </b></div><div class='esquerda'><b>") . $somaQuantFuncao . utf8_decode(" Funcionários") . "</b> </div><div class='esquerda'></div>
            <br>
            <hr>
            <div class='centro'><b>" . utf8_decode("Total Geral do Relatório: ")."</b> <b>" . $totalGeral . utf8_decode(" Funcionários") . "</b> </div>
            <hr>
            <div align='center'><br><br><br>
                    " . utf8_decode("Relatório gerado em " ) . $dia . " de " . utf8_decode($meses[$mes]) . " de " . $ano . " as " . date("H:i:s") . "  
            </div>
           </body>
    </html>";
$mpdf->AddPage();
$html = utf8_encode($html);
$mpdf->WriteHTML($html);
$mpdf->debug = false;
$mpdf->SetTitle('Relatório de Funcionários por Função');
$output = $mpdf->Output('Relatório de Funcionários por Função.pdf', 'I');
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

