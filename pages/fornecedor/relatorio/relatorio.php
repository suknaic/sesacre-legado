<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/class/lib/mpdf/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/fornecedor/Fornecedor.class.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/util/Session.class.php";

if (empty($_REQUEST['token'])) {
    header("Location: /pages/index.php");
}

$dados  = json_decode(base64_decode($_REQUEST['token']), true);

$fornecedor = new Fornecedor();
$fornecedor->setPessoaFisica(empty($dados['pessoaFisica']) ? null:$dados['pessoaFisica']);
$fornecedor->setPessoaJuridica(empty($dados['pessoaJuridica']) ? null:$dados['pessoaJuridica']);
$fornecedor->setMedicamento(array_unique($dados['materialServico']['medicamento']));
$fornecedor->setServico(array_unique($dados['materialServico']['servico']));
$fornecedor->setMaterialConsumo(array_unique($dados['materialServico']['materialConsumo']));
$fornecedor->setMaterialPermanente(array_unique($dados['materialServico']['materialPermanente']));

$busca = $fornecedor->relatorioFornecedor($dados['tipoFornecedor']);
$html = "<html>
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
                        td{padding: 1%;font-size: 9pt;text-align: center;border: 1px solid black;}
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
                            <br/>
                            SECRETARIA DE ESTADO DE SAÚDE - SESACRE
                            <br/>
                            CNPJ Nº 04.034.526/0001-43
                        </p><br>
                        <h2 class='cabecalho2'>LISTA DE FORNECEDORES</h2>
                        <br/>
                    </div>
                    <table class='table'>
                        <tr class='tudo'>
                            <td class='tudo'><b>Item</b></td>
                            <td class='tudo'><b>Fornecedor</b></td>
                            <td class='tudo'><b>CPF/CNPJ</b></td>
                            <td class='tudo'><b>Telefone Celular/Empresa</b></td>
                            <td class='tudo'><b>Telefone Residêncial</b></td>
                            <td class='tudo'><b>E-mail</b></td>
                            <td class='tudo'><b>Tipo de Fornecedor</b></td>
                            <td class='tudo'><b>Fornecedor Exclusivo</b></td>
                            <td class='tudo'><b>Fornecedor Distribuidora</b></td>
                            <td class='tudo'><b>Distribuidora</b></td>";

    if ($fornecedor->getMedicamento() != null) {
        $html .= "          <td class='tudo'><b>Medicamentos</b></td>";
    }

    if ($fornecedor->getServico() != null) {
        $html .= "          <td class='tudo'><b>Serviços</b></td>";
    }

    if ($fornecedor->getMaterialConsumo() != null) {
        $html .= "          <td class='tudo'><b>Materiais de Consumo</b></td>";
    }

    if ($fornecedor->getMaterialPermanente() != null) {
        $html .= "          <td class='tudo'><b>Materiais Permanentes</b></td>";
    }

$html .= "               </tr>";
$i = 1;
if ($busca != null) {
    foreach ($busca as $linhas) {
        $html .= "       <tr>
                            <td>" . $i . "</td>
                            <td>" . $linhas['nm_pessoa'] . "</td>";
        if ($linhas['tipo_pessoa'] == '1') {
            $html .= "          <td>" . Metodos::formataCpf($linhas['cpf_cnpj']) . "</td>";
        } else {
            $html .= "          <td>" . Metodos::formataCnpj($linhas['cpf_cnpj']) . "</td>";
        }
        $html .= "              <td>" . Metodos::formataCelular($linhas['nr_telefone_celular']) . "</td>";
        if ($linhas['nr_telefone_residencial'] != null) {
            $html .= "          <td>" . Metodos::formataTelefone($linhas['nr_telefone_residencial']) . "</td>";
        } else {
            $html .= "          <td></td>";
        }
        if ($linhas['nm_email'] != null) {
            $html .= "          <td>" . $linhas['nm_email'] . "</td>";
        } else {
            $html .= "          <td></td>";
        }

        if ($linhas['tipo_pessoa'] == '1') {
            $html .= "          <td>Pessoa Física</td>";
        } else {
            $html .= "          <td>Pessoa Jurídica</td>";
        }

        if ($linhas['fornecedor_exclusivo'] == 's') {
            $html .= "          <td>Sim</td>";
        } else {
            $html .= "          <td>Não</td>";
        }

        if ($linhas['fornecedor_distribuidora'] == 's') {
            $html .= "          <td>Sim</td>";
        } else {
            $html .= "          <td>Não</td>";
        }

        if ($linhas['fornecedor_distribuidora'] == 's') {
            $html .= "          <td>" . $linhas['dist_empresa'] . "</td>";
        } else {
            $html .= "          <td></td>";
        }

        if ($fornecedor->getMedicamento() != null) {
            $html .= "           <td class='justificar'>" . $linhas['medicamento'] . "</td>";
        }

        if ($fornecedor->getServico() != null) {
            $html .= "           <td class='justificar'>" . $linhas['servico'] . "</td>";
        }

        if ($fornecedor->getMaterialConsumo() != null) {
            $html .= "           <td class='justificar'>" . $linhas['material_consumo'] . "</td>";
        }

        if ($fornecedor->getMaterialPermanente() != null) {
            $html .= "           <td class='justificar'>" . $linhas['material_permanente'] . "</td>";
        }

        $html .= "           </tr>";
        $i++;
    }
} else {
    $html .= "      <tr>
                        <td colspan='14'>Nenhum Resultado Encontrado.</td>
                    </tr>";
}
$html.="            </table>
                </div>
            </body>
          </html>";

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->SetTitle('Fornecedores');
$mpdf->Output('Fornecedores.pdf', 'I');
exit();