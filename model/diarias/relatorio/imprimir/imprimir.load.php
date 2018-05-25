<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Relatorio.class.php";
$session = new Session();

$idRelatorio  = $_REQUEST['id'];
$relatorio = new Relatorio();
$relatorio->setIdRelatorio($idRelatorio);

$dados = $relatorio->infoProposto();
$destino = $relatorio->infoDestinosResumo();
$anexos = $relatorio->infoAnexos();
$locomocao = $relatorio->infoDestinosLocomocao();
$locomocao_padrao = $relatorio->destinosLocomocaoPadrao();

$html = "
        <html>
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
                        margin-top: 2%;
                        border-collapse: collapse;
                        margin-left: -6%;
                        margin-right: -6%;
                        width: 100%;
                    }
                    
                    th{
                    padding: 1%;
                    border: 1px solid black;
                    background-color:#9e9e9e';
                    }
                    
                    caption{
                    border: 1px solid black;
                    position: absolute;
                    width: 100%;
                    margin-right: 5%;
                    
                     left:2%;
                    }
                    

                    table, td, tr{
                        border: 1px solid black;
                    }

                    tr, td{
                        padding: 1%;
                        font-size: 9pt;
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

                    #brasao{
                      width: 9%;
                      margin: 0 auto;

                    }
                    
                    #erro{
                    text-align: center;
                    
                    }
                   
                    .centro{
                     text-align: center;
                    }
                    
                    .lateral{
                    margin-left: 20%;
                    }
                    
                    .esquerda{
                        float: left;
                        width: 100%;
                    }
                    
                    .direita{
                        float: right;
                        width: 50%;
                    }
                    
                    .matri{
                        float: right;
                        width: 23%;
                    }
                    
                    .ass_esquerda{
                        float: left;
                        width: 50%;
                        text-align: center;
                    }
                    
                    .ass_direita{
                        float: right;
                        width: 50%;
                        text-align: center;
                    }
                    
                    .lista{
                        float: left;
                        width: 20%;
                    }
                    
                    .sub_lista{
                        float: right;
                        width: 60%;
                    }
                    
                    .nome_ser{
                        float: left;
                        width: 70%;
                    }
                    
                     .nome{
                        float: left; width:50%;
                    }
                    
            </style>
            </head>
            <body>
            <div id='cabecalho'>
              <div id='brasao'><img src='http://localhost/assets/img/acrebrasao.jpg'></div>
              <p class='cabecalho2'>
                ESTADO DO ACRE
                <br/>
                DECRETO Nº 6.854 DE 30 DE DEZEMBRO DE 2002
                <br/>
                <br/>
                ANEXO III
                <br/>
                RELATÓRIO DE VIAGEM
              </p>
            </div>
            <div class='nome'>
                <b>ADA: </b> 
            </div>
            <br/><br/>
            
            <div class='nome_ser'><b>Nome do Servidor:</b> ".$dados['nm_proposto']."</div>
            ";
              if($dados['mt_proposto'] != null && $dados['mt_proposto'] !=""){
           $html .="<div class='matri'><b>Matrícula: </b>".$dados['mt_proposto']."</div>";
                  }
$html .="
            
            <div class='esquerda'><b>Cargo, emprego ou função:</b> ".$dados['fn_proposto']."</div>
           
            <div class='esquerda'><b>Órgão/Setor de lotação:</b> ".$dados['lt_proposto']."</div>
          
            <div class='esquerda'><p align='justify'><b>Descrição detalhada do(s) serviço(s) executado(s):</b><br/>
                ".$dados['ds_servico_executado']."</p>
            </div>
     
            <div class='esquerda'><p align='justify'><b>Local(is) de realização do(s) serviço(s):</b><br/>
                ".$dados['ds_locais_executado']."</p>
            </div>
            
            <div class='esquerda'><b>Período do afastamento:</b></div>
            De  ".$destino['dt_ini'].",  às  ".$destino['hr_ini']. " hs.  a  ".$destino['dt_fim'].",  às  ".$destino['hr_fim']."
            <br/><br/>";

    if ($locomocao) {
        $cont = 0;
        foreach ($locomocao as $i => $linha) {
            $cont += 1;
            $trpAux = null;
            $html   .=      "<div class='esquerda'><b>Meio de Locomoção ". $cont .":</b></div>";
            foreach ($locomocao_padrao as $z => $padrao) {
                if ($trpAux != $padrao['id_transporte']) {    
                    $marcado = ($linha['id_transporte'] == $padrao['id_transporte']) ? 'X' : ' ';
                    
                    $html .= "<div class='lista'>(".$marcado .")". $padrao['nm_transporte'].":<br/></div><br/>";
                }
                
                
                if (($linha['id_transporte_tipo'] == $padrao['id_transporte_tipo'] && $linha['id_transporte'] == $padrao['id_transporte'])) {
                    $check = '&#9745;';
                    $ds_transporte = $linha['ds_transporte_tipo'];
                } else {
                    $check = '&#9744;';
                    $ds_transporte = '';
                }
//                $check = ($linha['id_transporte_tipo'] == $padrao['id_transporte_tipo'] && $linha['id_transporte'] == $padrao['id_transporte']) ? '&#9745; ' : '&#9744; ' ;
                
                if ($padrao['id_transporte'] == 1) {
                    $html   .=    "<div class='sub_lista'>".$ds_transporte."<br/></div><br/>";
                } else {
                    $html   .=    "<div class='sub_lista'><b>" . $check . $padrao['nm_transporte_tipo'].": </b>".$ds_transporte."<br/></div><br/>";
                }
                $trpAux = $padrao['id_transporte'];
            }
        }
    }
//$cont = 1;           
//                foreach ($dest as $ml) {
//                    $html   .=      "<div class='esquerda'><b>Meio de Locomoção ".$cont.":</b></div>"; 
//
//             if($ml['id_transporte']==1){
//    $html   .=      "<div class='lista'>(x) Áereo: <br/></div><br/>";             
//                }  else {
//    $html   .=      "<div class='lista'>(   ) Áereo: <br/></div><br/>";
//                }" 
// 
//            "; if($ml['id_transporte']==2){
//    $html   .=      "<div class='lista'>(x) Terrestre: <br/></div>";             
//                }  else {
//    $html   .=      "<div class='lista'>(   ) Terrestre: <br/></div>";
//                }" 
//            
//            "; if($ml['id_transporte']==2 && $ml['id_transporte_tipo']==1){
//    $html   .=      "<div class='sub_lista'><b>&#9745; Ônibus: </b>".$ml['descTransporte']."<br/></div><br/>";             
//                }  else {
//    $html   .=      "<div class='sub_lista'><b>&#9744; Ônibus: </b><br/></div><br/>";
//                }"
//            
//            "; if($ml['id_transporte']==2 && $ml['id_transporte_tipo']==2){
//    $html   .=      "<div class='lateral'><b>&#9745; Veículo oficial: </b>".$ml['descTransporte']."<br/></div>";             
//                }  else {
//    $html   .=      "<div class='lateral'><b>&#9744; Veículo oficial: </b><br/></div>";
//                }" 
//            
//            "; if($ml['id_transporte']==2 && $ml['id_transporte_tipo']==3){
//    $html   .=      "<div class='lateral'><b>&#9745; Outro:  </b>".$ml['descTransporte']."<br/></div><br/><br/>";             
//                }  else {
//    $html   .=      "<div class='lateral'><b>&#9744; Outro:  </b><br/></div><br/>";
//                }"
//            
//             "; if($ml['id_transporte']==3){
//    $html   .=      "<div class='lista'>(x) Fluvial: <br/></div>";             
//                }  else {
//    $html   .=      "<div class='lista'>(   ) Fluvial: <br/></div>";
//                }"
//             
//             "; if($ml['id_transporte']==3 && $ml['id_transporte_tipo']==2){
//    $html   .=      "<div class='lateral'><b>&#9745; Veículo oficial: </b>".$ml['descTransporte']."<br/></div>";             
//                }  else {
//    $html   .=      "<div class='lateral'><b>&#9744; Veículo oficial: </b><br/></div>";
//                }" 
//            
//            "; if($ml['id_transporte']==3 && $ml['id_transporte_tipo']==3){
//    $html   .=      "<div class='lateral'><b>&#9745; Outro:  </b>".$ml['descTransporte']."<br/></div><br/>";             
//                }  else {
//    $html   .=      "<div class='lateral'><b>&#9744; Outro:  </b><br/></div>";  
//                }
//                $cont++;
//                }$html.="           
//                        
    $html .=  "<div class='esquerda'><p align='justify'><b>Documento(s) Anexado(s):</b><br/>";
    
    if ($anexos) {
        foreach ($anexos as $linha) {
            $html .= "<p>".$linha['nm_relatorio_anexo']."</p>";
        }
    }
    $html .= "</div> ";
       $html .= "<br/>
            
            <div class='centro'> ___________________________, ________ de ____________________ de ________. </div>
            <br/><br/>
            
            <div class='ass_esquerda'> _________________________________________________________ <br/> Relator</div> 
            <div class='ass_direita'> _________________________________________________________ <br/> Chefe Imediato </div>
            <br/>
            
            <div class='centro'> (Alterado pelo Decreto 6.124/2013)</div>
           
           </body>
           </html>";