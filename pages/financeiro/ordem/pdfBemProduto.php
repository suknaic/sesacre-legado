<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/class/lib/mpdf/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";


$corpo = pdf($_GET['id']);
$html = "<html>
        <head>
         <style>
                    page toc { sheet-size: A4; }
                    body{
                    font-family: arial;
                    font-style: normal;
                    font-variant: normal;
                    }
                    
                    table {
                        margin-top: 2%;
                        margin-left: -6%;
                        margin-right: -6%;
                        width: 100%;
                        padding: 0;
                        border-spacing: 0;
                        
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
                        font-size: 10pt;
                    }

                    #cabecalho{
                      display:block;

                    }

                    .cabecalho2{
                      position: relative;
                      text-align: center;
                      margin-top: 1%;
                      font-weight: bold;
                      font-size: 12pt;

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
                    margin-left: -6%;
                    }
                    .fontMaior{
                    font-size: 12pt;
                    
                    }
                    .nomeExtenso{
                    margin-left: 49%;
                    }
            </style>
            </head>
            <body>
        " . $corpo . "
            </body>
           </html>";
//echo $html;
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();
exit();

//função para gerar a tabela
function pdf($ordem = null) {
    $conexao = new Conexao();
    $pdo = $conexao->connect();
    $dados = "";

    $sql = ("select p.id_pedido, concat(concat(concat(p.id_lotacao, '-'),concat(p.nr_pedido, '/')),
             to_char(p.dt_pedido, 'yyyy')) as pedido, ordem.nr_ordem, ordem.aa_ordem, ordem.nr_prazo_ordem, 
             cont.nr_contrato, cont.tp_contrato, gprocesso.cd_pregao, modalidade.nm_modalidade, objeto.nm_objeto, 
             cont.dt_ini_vigencia_contrato, cont.dt_fim_vigencia_contrato, pe.nm_pessoa, pe.nm_email, pj.nr_cnpj, 
             pe.ds_logradouro, pe.ds_bairro, pe.nr_telefone_celular as telefoneCredor, contItens.nr_item, mat.nm_material, 
             mat.nm_desc_material, contItens.nm_marca, contItens.nm_modelo, ordemItens.qt_itens_ordem, 
             ordemItens.vl_itens_ordem, unid.nm_unidade_medida, emp.nr_empenho, desp.cd_despesa_elemento, 
             desp.ds_despesa_elemento, font.nr_fonte, local.nm_lotacao as localEntrega, local.ds_logradouro as localLogradouro,
             local.ds_bairro as localBairro, local.nr_cep as localCep, pEmissor.nm_pessoa as emissor, setorEmissor.nm_lotacao as setor, 
             pEmissor.nr_telefone_celular, pEmissor.nm_email, ordem.dh_ordem, pj.nr_safira, pe.nm_email as emailFornecedor
             from fin_ordem as ordem
             inner join fin_ordem_itens as ordemItens
             on ordemItens.id_ordem = ordem .id_ordem
             inner join fin_pre_ordem as preOrdem
             on preOrdem.id_pre_ordem = ordemItens.id_pre_ordem
             inner join fin_cont_itens as contItens
             on contItens.id_cont_itens = preOrdem.id_cont_itens
             inner join pla_unidade_medida as unid
             on unid.id_unidade_medida = contItens.id_unidade_medida
             inner join pla_material as mat
             on mat.id_material = contItens.id_material
             inner join fin_fornecedor as f
             on f.id_fornecedor = contItens.id_fornecedor
             inner join fin_contrato as cont
             on cont.id_contrato = f.id_contrato
             inner join ses_pessoa as pEmissor
             on pEmissor.id_pessoa = ordem.id_pessoa
             inner join ses_pessoa as pe
             on pe.id_pessoa = f.id_pessoa
             inner join ses_pessoa_juridica as pj
             on pj.id_pessoa = pe.id_pessoa
             inner join fin_pedido as p            
             on p.id_pedido = ordem.id_pedido
             inner join ses_lotacao as setorEmissor
             on setorEmissor.id_lotacao = p.id_lotacao
             inner join fin_empenho as emp
             on emp.id_pedido = p.id_pedido
             inner join  view_despesa_elemento as desp 
             on desp.id_despesa_elemento  = p.id_despesa_elemento
             inner join fin_fonte as font
             on font.id_fonte = p.id_fonte 
             inner join ses_lotacao as local
             on local.id_lotacao = ordem.id_lotacao
             left join gco_processo as gprocesso
             on gprocesso.id_processo = cont.id_processo
             left join gco_modalidade as modalidade
             on modalidade.id_modalidade = gprocesso.id_modalidade
             left join gco_objeto as objeto
             on objeto.id_objeto = gprocesso.id_objeto
             where ordem.id_ordem = " . $ordem);
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $dados = FALSE;
    }
    $tabela = '';
    if ($dados != false) {
        $tabela = '
            <div id="cabecalho">
              <div id="brasao"><img src="http://localhost/assets/img/acrebrasao.jpg"></div>
              <p class="cabecalho2">
                ESTADO DO ACRE
                <br/>
                SECRETARIA DE ESTADO DE SAÚDE - SESACRE
                <br/>
                CNPJ Nº 04.034.526/0001-43
              </p>
            </div>
            <div class="centro"><b>ORDEM DE ENTREGA Nº ' . $dados[0]["nr_ordem"] . '/' . $dados[0]["aa_ordem"] . '</b></div>
            <br/>
             <table>
            <tr>
                <td style="text-align: center"><b>Dados de Contato:</b> <br/> 
                <b>(Contratante)</b> 
                </td>
                <td><b>Emissor:</b>'.$dados[0]["emissor"].'<br/>
                    <b>Setor:</b>'.$dados[0]["setor"].'<br/>
                    <b>Telefone/Fax:</b>'.$dados[0]["nr_telefone_celular"].'<br/>
                    <b>E-mail:</b> '.$dados[0]["nm_email"].'<br/>
                    <b>Data de Emissão:</b> '. Metodos::obterDataBRTimestamp($dados[0]["dh_ordem"]).' As '. Metodos::obterHoraTimestamp($dados[0]["dh_ordem"]).'<br/>
                    <b>Sol. de Necessidade nº:</b> '.$dados[0]["id_pedido"].' 
                </td>
            </tr>
                <tr>
                <td colspan="2">
                    <b>Licitação nº:</b> ' . $dados[0]["nm_modalidade"] . '.:' . $dados[0]["cd_pregao"] . '<br/>
                    <b>Objeto Licitado/Contratado:</b> ' . $dados[0]["nm_objeto"] . '<br/>
                    <b>Contrato nº:</b> ' . $dados[0]["nr_contrato"] . '  <br/>
                    <b>Vigência:</b> ' . Metodos::ConverteDataBR($dados[0]["dt_ini_vigencia_contrato"]) . ' a ' . Metodos::ConverteDataBR($dados[0]["dt_fim_vigencia_contrato"]) . '
                </td>
            </tr>
        </table>
        <br/>
        <table style="margin-top: 0%">
            <caption style="background-color:#c9c9c9 "><strong>DADOS DA CONTRATADA</strong></caption>
                <tr>
                    <td >
                        <b>Razão Social.:</b> ' . $dados[0]["nm_pessoa"] . '<br/>
                        <b>CNPJ:</b> ' . $dados[0]["nr_cnpj"] . '&nbsp;&nbsp;<b>Contato.:</b> ' . $dados[0]["telefoneCredor"] . '<br/>
                        <b>Credor Safira nº: </b>'.$dados[0]["nr_safira"].'<br/>        
                        <b>Endereço:</b> ' . $dados[0]["ds_logradouro"] . '<br/>
                        <b>Bairro:</b> ' . $dados[0]["ds_bairro"] . '<br/>
                        <b>E-Mail:</b> ' . $dados[0]["emailFornecedor"] . '<br/>      
                    </td>
                </tr>
        </table>
            <table>
            <caption style="background-color:#c9c9c9"><strong>DETALHAMENTO DO OBJETO</strong></caption>
                <tr>
                    <td style="background-color:#e5e5e5; text-align: center">Item</td>
                    <td style="background-color:#e5e5e5; text-align: center">Quant.<br/>Total</td>
                    <td style="background-color:#e5e5e5; text-align: center">Unid.</td> 
                   <td style="background-color:#e5e5e5; text-align: center">Discriminação</td>
                    <td style="background-color:#e5e5e5; text-align: center">Marca</th>
                    <td style="background-color:#e5e5e5; text-align: center">Preço Unit.<br/>(R$)</td>
                    <td style="background-color:#e5e5e5; text-align: center">Preço Total<br/>(R$)</td>
                </tr>';
        $total = 0;
        foreach ($dados as $linha) {
            $totalItens = 0;
            $totalItens = $linha["qt_itens_ordem"] * $linha["vl_itens_ordem"];
            $totalItens = round($totalItens, 2);
            $tabela .= '<tr>
                    <td>' . $linha["nr_item"] . '</td>
                    <td>' . Metodos::ConverteValorBr(round($linha["qt_itens_ordem"], 2), 2) . '</td>
                    <td>' . $linha["nm_unidade_medida"] . '</td>
                    <td>' . $linha["nm_desc_material"] . '</td>
                    <td>' . $linha["nm_marca"] . '</td>
                    <td>' . Metodos::ConverteValorBr(round($linha["vl_itens_ordem"], 2), 2) . '</td>
                    <td>' . Metodos::ConverteValorBr($totalItens, 2) . '</td>
                </tr>';
            $total += $totalItens;
            $total = round($total, 2);
        }
        $tabela .= '<tr>
                    <td colspan="6" style="text-align:right;"><b>Valor Total</b></td>
                    <td style="background-color:#e5e5e5;text-align: center;">' . Metodos::ConverteValorBr($total, 2) . '</td>
                </tr>
                <tr>
                    <td colspan="7"><b>Valor total por extenso:</b>' . Metodos::valorPorExtenso($total, '$') . '</td>
                </tr>
                </table>';

        $tabela .= '
            <table>
             <caption style="background-color:#c9c9c9"><strong>DADOS PARA ENTREGA</strong></caption>
                <tr>
                    <td><b>Prazo de Entrega:</b></td>
                    <td>Até ' . $dados[0]["nr_prazo_ordem"] . '(' . Metodos::valorPorExtenso($dados[0]["nr_prazo_ordem"], '-') . ') dias, contados a partir do recebimento da Ordem de Entrega.</td>
                </tr>
                
                <tr>
                    <td><b>Local de Entrega:</b></td>
                    <td>' . $dados[0]["localentrega"] . ',   localizado   no ' . $dados[0]["localbairro"] . ',' . $dados[0]["locallogradouro"] . ' CEP: ' . $dados[0]["localcep"] . '</td>
                </tr>
            </table>';
        $tabela .= '
                <table>
                <caption style="background-color:#c9c9c9"><strong>DADOS PARA EMISSÃO DO DOCUMENTO FISCAL</strong></caption>
                
                <tr>
                    <td><b>Destinatário/Remetente:</b></td>
                    <td>Secretaria De Saúde Do Estado Do Acre</td>
                </tr>

                <tr>
                    <td><b>Nota de Empenho nº:</b></td>
                    <td>' . $dados[0]["nr_empenho"] . ' Fonte :' . $dados[0]["nr_fonte"] . '</td>
                </tr>
                <tr>
                    <td><b>Elemento da Despesa:</b></td>
                    <td>' . $dados[0]["cd_despesa_elemento"] . '-' . $dados[0]["ds_despesa_elemento"] . '</td>
                </tr>
                <tr>
                    <td><b>Informações Adicionais:</b></td>
                    <td></td>
                </tr>
                
              
            </table>
            <table style="margin-top: 0%">
            <tr>
                <td>
                    <b>OBS:</b><br/>
                    1) Ao emitir Documento Fiscal, a Contratada deverá descrever o objeto conforme discriminado
                       nesta Ordem registrado no campo informações adicionais o número da Ordem, da Nota de Empenho,
                       da Ata de Registro de Preços e do Contrato Administrativo, anexando à mesma as certidões de
                       regularidade fiscal exigidas no ato da licitação, sendo seu não cumprimento passivo de 
                       devolução do Documento Fiscal;<br/>
                    2) Esta Ordem será emitida em 02 vias, sendo 1 via do Emissor (Contratante) e 1 via do 
                       represenatente legal da Contratada;<br/>
                    3) Para fins de informação confirma-se que ha disponibilidade contratual para os itens contidos 
                       nesta Ordem.
                </td>
            </tr>
            </table>
            <table style="margin-top: 0%">
                <tr>
                    <td><b>Autorizado em ____/____/_____</b></td>
                    <td style="padding-bottom: 5%;">
                        <b>Chefe do setor emitente(Carimbo e Assinatura):</b>
                        <br/> <br/> <br/> <br/>
                    </td>
                </tr>
            </table>
            <table style="margin-top: 0%; padding-bottom: 10%" >
                <tr>
                    <td style="border: 0px; ">
                        <br/>
                        <b>Nome completo do representante da Contratada:_________________________________________________________________</b>
                        
                    </td>
                </tr>
            </table>
                
                <div style="margin-left: -5%; margin-top: -10%; font-size: 10pt;  "> 
                        <b>RG/CPF nº_______________________________________</b>
                        <br/><br/>
                        <b>Recebida em (Data):____/____/_____ hs:____:____</b>
                        <br/><br/>
                </div>
                <div style="margin-left: 45%; margin-top:-5%; margin-right: -5%; font-size: 10pt;"> 
                        <b>Assinatura:</b>____________________________________________________
                </div>';
    }
    return $tabela;
}
