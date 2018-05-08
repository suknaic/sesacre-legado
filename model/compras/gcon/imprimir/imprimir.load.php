<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/compras/gcon/processo/Processo.class.php";

$session = new Session();

if(!$session->vPCompras()){
    header("Location: /pages/index.php");
}else{
    $idProcesso  = $_REQUEST['idProcesso'];
    $processo = new Processo();
    $processo->setIdProcesso($idProcesso);
    $dados = $processo->processoPdf();
    $html = "
            <html>
                <head>
                    <style type='text/css' media='print'>
                       .lado_E{float: left; width:30%; text-align: left;}
                       .lado_D{float:left; width:70%; text-align: left;}
                       .lado_Vazio{float:left; width:75%; text-align: right;}
                       .titulo{text-align: center;}
                       .cabecalho{display:block;}
                       .brasao{width: 9%;margin: 0 auto;}
                       td{padding: 1%;font-size: 9pt;text-align: center;}
                       .lateralDireita{text-align: right;}
                       .cabecalho2{position: relative;text-align: center;margin-top: 1%;font-weight: bold;font-size: 9pt;}
                       .justificar{text-align: justify;}
                       .table {margin-top: 2%;border-collapse: collapse;width: 100%;}
                       .tudo{border: 1px solid black;}
                       body{font-family: arial;font-style: normal;font-variant: normal;font-size: 9pt;}
                       .titulo_2{text-align: center;}
                       #landscape {page: land;}       
                        page toc { sheet-size: A4; }
                        @page land {size: portrait;}
                    </style>
                </head>
                <body>
                    <div id='landscape'>
                        <div class='cabecalho'>
                            <div class='brasao'><img src='http://localhost/assets/img/acrebrasao.jpg'></div>
                                <p class='cabecalho2'>ESTADO DO ACRE</p>
                            </div>
                            <div class='titulo'><b>DETALHAMENTO DO PROCESSO</b></div><br/>
                            <div class='lado_E'><b>Ada / Cpr: </b></div><div class='lado_D'>".$dados['cd_ada_cpr']."</div>
                            <div class='lado_E'><b>Data de Cadastro: </b></div><div class='lado_D'>".Metodos::ConverteDataBR($dados["dt_processo"])."</div>";
                if($dados['tipos_gastos'] != null && $dados['tipos_gastos'] != ""){ 
                    $html.="<div class='lado_E'><b>Tipos De Gastos: </b></div><div class='lado_D'>".$dados['tipos_gastos']."</div>";
                } else {
                    $html.="<div class='lado_E'><b>Tipos De Gastos: </b></div><div class='lado_Vazio'></div>";
                }
                if ($dados['nm_objeto'] != null && $dados['nm_objeto'] != ""){
                    $html.="<div class='lado_E'><b>Objeto: </b></div><div class='lado_D'>".$dados['nm_objeto']."</div>";
                } else {
                    $html.="<div class='lado_E'><b>Objeto: </b></div><div class='lado_Vazio'></div>"; 
                }
                if($dados['centrais'] != null && $dados['centrais'] != ""){ 
                    $html.="<div class='lado_E'><b>Centrais De Atendimento: </b></div><div class='lado_D'>".$dados['centrais']."</div>";
                } else {
                    $html.="<div class='lado_E'><b>Centrais: </b></div><div class='lado_Vazio'></div>";
                }
                    $html.="<div class='lado_E'><b>Valor Total Estimado: </b></div><div class='lado_D'>R$ ".Metodos::ConverteValorBr($dados["vl_total_est"], 2)." </div>";
                if ($dados['nm_cidade'] != null && $dados['nm_cidade'] != ""){
                    $html.="<div class='lado_E'><b>Área de Abrangência: </b></div><div class='lado_D'>".$dados['nm_cidade']."</div>";
                } else {
                    $html.="<div class='lado_E'><b>Área de Abrangência: </b></div><div class='lado_Vazio'></div>";
                }
                if ($dados['nm_unidade_contempladas'] != null && $dados['nm_unidade_contempladas'] != ""){
                    $html.="<div class='lado_E'><b>Unidades Contempladas: </b></div><div class='lado_D'>".$dados['nm_unidade_contempladas']."</div>";
                } else {
                    $html.="<div class='lado_E'><b>Unidades Contempladas: </b></div><div class='lado_Vazio'></div>";
                }   
                if ($dados['nm_situacao'] != null && $dados['nm_situacao'] != "") {
                    $html.="<div class='lado_E'><b>Situação de Acompanhamento: </b></div><div class='lado_D'>".$dados['nm_situacao']."</div>";
                } else {
                    $html.="<div class='lado_E'><b>Situação de Acompanhamento: </b></div><div class='lado_Vazio'></div>";
                }    
                if ($dados['nm_pessoa'] != null && $dados['nm_pessoa'] != "") {    
                    $html.="<div class='lado_E'><b>Técnico Responsável: </b></div><div class='lado_D'>".$dados['nm_pessoa']."</div>";
                } else {
                    $html.="<div class='lado_E'><b>Técnico Responsável: </b></div><div class='lado_Vazio'></div>";
                }
                if($dados['cd_pregao'] != null && $dados['cd_pregao'] !=""){
                    $html.="<div class='lado_E'><b>Pregão: </b></div><div class='lado_D'>".$dados['cd_pregao']."</div>";
                }
                if($dados['nm_modalidade'] != null && $dados['nm_modalidade'] !=""){
                    $html.="<div class='lado_E'><b>Modalidade: </b></div><div class='lado_D'>".$dados['nm_modalidade']."</div>";
                } else {
                    $html.="<div class='lado_E'><b>Modalidade: </b></div><div class='lado_Vazio'></div>";
                }
                if($dados['vl_total_hom'] != null && $dados['vl_total_hom'] !="" && $dados['vl_total_hom'] !=0){
                    $html.="<div class='lado_E'><b>Valor Total Homologado: </b></div><div class='lado_D'>R$ ".Metodos::ConverteValorBr($dados["vl_total_hom"], 2)."</div>";
               }
$html.=                    "<br/><br/>                             
                            <div class='titulo_2'><b>HISTÓRICO DE MOVIMENTAÇÃO DO PROCESSO</b></div></br>
                            <table class='table'>
                                    <tr class='tudo'>
                                        <td class='tudo' width=20%><b>Data e Hora</b></td>
                                        <td class='tudo' width=28%><b>Usário</b></td>
                                        <td class='tudo' width=28%><b>Técnico Responsável</b></td>
                                        <td class='tudo' width=21%><b>Situação</b></td>
                                        <td class='tudo' width=37%><b>Anotação</b></td>
                                    </tr>";
// ========================================== Obtendo Hitórico do Processo ===========================================
    
    $processo->setIdProcesso($idProcesso);
    $historico = $processo->hitoricoProcessoPdf();

// ===================================================================================================================
    foreach ($historico as $linhas){
$html.=                       "<tr>
                                   <td class='tudo'>".date('d/m/Y H:i:s',strtotime($linhas['dh_anotacao']))."</td>
                                   <td class='tudo'>".$linhas['usuario']."</td>
                                   <td class='tudo'>".$linhas['tecnico']."</td>
                                   <td class='tudo'>".$linhas['nm_situacao']."</td>
                                   <td class='tudo'>".$linhas['ds_anotacao']."</td>
                               </tr>";
        }
$html.=       "             </table>
                        </div>
                    </div>
                </body>
            </html>";
}