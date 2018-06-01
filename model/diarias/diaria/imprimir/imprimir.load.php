<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/diarias/Diaria.class.php";
$session = new Session();

//if(!$session->vPDiarias()){
//    header("Location: /pages/index.php");
//}else{
    $idDiaria  = $_REQUEST['id'];
    $diaria = new Diaria();
    $diaria->setIdDiaria($idDiaria);
    
    $dados = $diaria->retornaDadosRelatorio();
    $destinos = $diaria->retornaTrsRelatorio();
    $resumo = $diaria->retornaInfoResumidaRelatorio();
    
    $tpInicial = ' ';
    $tpProrrogacao = ' ';
    $tpComplemento = ' ';
    
    $data = explode('/', $dados['dt_criacao']);
    $dia = $data[0];
    $mes = $data[1];
    $ano = $data[2];
    
    $meses = Metodos::getMeses();
            
    switch ($dados['id_tipo']) {
        case 1:
            $tpInicial = 'X';
            break;
        case 2:
            $tpProrrogacao = 'X';
            break;
        case 3:
            $tpComplemento = 'X';
            break;
}
    
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
                        //margin-left: -6%;
                        }

                        .lateralDireita{
                        text-align: right;
                        }
                        .esquerda{
                            float: left; width:50%; text-align: center;
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
                <body>
                    <div id='cabecalho'>
                        <div id='brasao'><img src='http://localhost/assets/img/acrebrasao.jpg'></div>
                        <p class='cabecalho2'>
                          ESTADO DO ACRE
                          <br/>
                          DECRETO Nº 6.854 DE 30 DE DEZEMBRO DE 2002
                        </p>
                    </div>
                    <div class='centro'><b>ANEXO II</b></div>
                    <div class='centro'><b>PROPOSTA E CONCESSÃO DE DIÁRIAS</b></div>
                    <div class='nome'>
                        <b>ADA: </b>".$dados['nr_protocolo']." 
                    </div>
                    <div class='lateralDireita'>
                        Inicial (".$tpInicial.")
                        <br/>
                        Prorrogação (".$tpProrrogacao.")
                        <br/>
                        Complementação (".$tpComplemento.")
                    </div>
                    <br/>
                    <div class='centro'>
                        <b>PROPOSTA</b>
                    </div>
                    <div class='lateral'>
                        <b>Proponente</b><br/>
                        <b>Nome:</b> ".$dados['nm_proponente']."<br/>
                        <b>Cargo, função ou emprego</b>: ".$dados['fn_proponente']."<br/>
                        <b>Órgao/Setor de lotação:</b> ".$dados['lt_proponente']."
                    </div>
                    <br/>
                    <div class='lateral '>
                        <b>Proposto</b><br/>
                        <b>Nome:</b> ".$dados['nm_proposto'].",  <b>CPF:</b> ".Metodos::formataCpf($dados['proposto_cpf']).", <b>Matrícula:</b> ".$dados['proposto_matricula']." <br/>
                        <b>Cargo, função ou emprego:</b> ".$dados['fn_proposto']." <br/>
                        <b>Órgao/Setor de lotação:</b> ".$dados['lt_proposto']."
                    </div>
                    <div class='lateral'>
                        <p align='justify'>
                            <b>Descrição dos serviços a serem executados:</b><br/>
                            ".$dados['ds_servico_executado']."
                        </p>
                    </div>
                    <div class='lateral'>
                        <p align='justify'>
                            <b>Local(is) de realização do(s) serviço(s):</b><br/>   
                            ".$dados['ds_locais_executado']."
                        </p>
                    </div>
                    <br/>
                    <div class='lateral'>
                       <b> Período provável do afastamento:</b><br/>
                       De: ".$resumo['dt_ini'].", às ".$resumo['hr_ini']." até ".$resumo['dt_fim'].", às ".$resumo['hr_fim']."
                    </div>
                    <table>
                        <tr>
                            <td width=34%><b>Quantidades de Diárias</b></td>
                            <td width=33%><b>Valor Unitário</b></td>
                            <td width=33%><b>Valor Total</b></td>
                        </tr>
                        ".$destinos."
                        <tr>
                            <td colspan=2><b>Soma Total</b></td>
                            <td>".number_format($resumo['soma_total'],2,",",".")."</td>
                        </tr>
                    </table>
                    <div class='lateral'>
                        <b>Observação:</b> <br/>
                        ".$dados['ds_obs']."
                        <p align='justify'></p>
                        <br/><br/>
                        <div class='centro'>
                             Rio Branco - AC , ".$dia." de ".$meses[$mes]." de ".$ano."
                        </div>
                    </div>
                    <br/><br/>
                    <div class='esquerda'>
                        ..................................................................................<br/>
                        Proponente
                    </div>
                    <div class='direita'>
                        ..................................................................................<br/>
                        Proposto
                    </div>
                    <br/>
                    <div class='lateral'>
                        <b>CONCESSÃO</b><br/>
                        Concedo e autorizo o pagamento da(s) diária(s) acima proposta(s).
                    </div>
                    <br/><br/>
                    <div class='esquerda'>
                        ..................................................................................<br/>
                        Ordenador de Despesa
                    </div>
                    <div class='direita'>
                        ..................................................................................<br/>
                        Chefe do Setor Financeiro
                    </div>
                    <br/>
                    <div class='centro'>
                        (Alterado pelo Decreto 6.124/2013)
                    </div>
                </body>
            </html>";
//}

