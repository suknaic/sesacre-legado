<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/compras/contrato/ver_contrato.load.php";
?>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo TITULO_DO_SISTEMA; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!--Bootstrap Stylesheet [ REQUIRED ]-->
        <link href="/assets/lib/template/css/bootstrap.min.css" rel="stylesheet">
        <!--Nifty Stylesheet [ REQUIRED ]-->
        <link href="/assets/lib/template/css/nifty.min.css" rel="stylesheet">
        <!-- Font Awesome [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/lib/template/plugins/font-awesome/css/font-awesome.min.css">
        <!-- themify icons [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/lib/template/plugins/themify-icons/themify-icons.min.css">
        <!-- ion icons [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/lib/template/plugins/ionicons/css/ionicons.min.css">
        <!--DataTables [ OPT ]-->
        <link href="/assets/lib/template/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.bootstrap.min.css" rel="stylesheet">
        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css">
        <!--Datapicker-->
        <link href="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
    </head>
    <!--TIPS-->

    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-sm">

            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php";
//Modal Alert
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/modalAlert.html";
            ?>

            <div class="boxed">

                <!--CONTENT CONTAINER-->
                <div id="content-container">
                    <!--Page Title-->
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Espelho do contrato</h1>
                    </div>
                    <!--End page title-->
                    <ol class="breadcrumb">
                        <li class="active"><a href="/pages/compras/gestao_contratos/index.php">Voltar</a></li>
                    </ol>
                    <!--Page content-->
                    <div id="page-content">

                        <!--Informaçao do pedido-->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel">

                                    <div class="panel-heading ">
                                        <h3 class="panel-title">Informações da Licitação</h3>
                                    </div>
                                    <input type="hidden" name="id_contrato" id="id_contrato" value="<?php echo $id; ?>" />
                                    <input type="hidden" name="id_contrato" id="tp_contrato" value="<?php echo $array[0]["tp_contrato"]; ?>" />
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class='col-sm-2'><b>ADA/CPR:</b></div>
                                            <div class='col-sm-9' id="ada_cpr"><?php echo $array[0]["cd_ada_cpr"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Licitação:</b></div>
                                            <div class='col-sm-9' id="licitacao"><?php echo $array[0]["cd_pregao"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Tipo de gasto:</b></div>
                                            <div class='col-sm-9' id="tipoGasto"><?php echo $array[0]["nm_tipo_gasto"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Objeto:</b></div>
                                            <div class='col-sm-9' id="obejto"><?php echo $array[0]["nm_objeto"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Modalidade:</b></div>
                                            <div class='col-sm-9' id="modalidade"><?php echo $array[0]["nm_modalidade"]; ?></div>
                                        </div>
                                    </div>

                                    <div class="panel-heading ">
                                        <h3 class="panel-title">Informações da Contratuais</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <?php
                                            if ($array[0]["tp_contrato"] == 1) {
                                                echo "<div class='col-sm-2'><b>Ata:</b></div>";
                                            } else {
                                                echo "<div class='col-sm-2'><b>Contrato:</b></div>";
                                            }
                                            ?>

                                            <div class='col-sm-9' id="nr_contrato"><?php echo $array[0]["nr_contrato"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Data de assinatura:</b></div>
                                            <div class='col-sm-9' id="dt_assinatura"><?php echo Metodos::ConverteDataBR($array[0]["dt_assinatura"]); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Data de publicação:</b></div>
                                            <div class='col-sm-9' id="dt_publicacao"><?php echo Metodos::ConverteDataBR($array[0]["dt_publicacao"]); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Vigência inicial:</b></div>
                                            <div class='col-sm-9' id="dt_ini_vigencia_contrato"><?php echo Metodos::ConverteDataBR($array[0]["dt_ini_vigencia_contrato"]); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Vigência final:</b></div>
                                            <div class='col-sm-9' id="dt_fim_vigencia_contrato"><?php echo Metodos::ConverteDataBR($array[0]["dt_fim_vigencia_contrato"]); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Descrição do objeto:</b></div>
                                            <div class='col-sm-9' id="ds_objeto"><?php echo $array[0]["ds_objeto"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <?php
                                            if ($array[0]["tp_contrato"] == 1) {
                                                echo "<div class='col-sm-2'><b>Observações da ATA:</b></div>";
                                            } else {
                                                echo "<div class='col-sm-2'><b>Observações do Contrato:</b></div>";
                                            }
                                            ?>

                                            <div class='col-sm-9' id="ds_obs_contrato"><?php echo $array[0]["ds_obs_contrato"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Fornecedor:</b></div>
                                            <div class='col-sm-9' id="nm_pessoa"><?php echo $array[0]["nm_pessoa"]; ?></div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="text-left">
                                                    <button class="btn btn-primary btn-rounded btn-editar" type="button"><i class="fa fa-pencil-square fa-lg" aria-hidden="true"></i> Editar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--===================================================-->
                        <!--Informaçao do Itens da pre ordem-->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel">
                                    <div class="panel-heading ">
                                        <h3 class="panel-title">Itens</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                            <div class="table-responsive">
                                                <table id="tabela" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Nº</th>
                                                            <th class="text-center">Item</th>
                                                            <th class="text-center">Descrição GRP</th>
                                                            <th class="text-center">Descrição Sesacrenet</th>
                                                            <th class="text-center">Grupo</th>
                                                            <th class="text-center">Sub grupo</th>
                                                            <th class="text-center">Unid</th>
                                                            <th class="text-center">Tipo</th>
                                                            <th class="text-center">Elemento de despesa</th>
                                                            <th class="text-center">Lote</th>
                                                            <th class="text-center">QTD</th>
                                                            <th class="text-center">Valor unit.</th>
                                                            <th class="text-center">Total</th>
                                                            <th class="text-center">Utilizado</th>
                                                            <th class="text-center">Saldo</th>
                                                            <th class="text-center">Saldo Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php echo $tabela; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel">
                                    <div class="panel-heading ">
                                        <h3 class="panel-title">Pedidos vinculados a este Contrato/Ata</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class='col-sm-2'><b>Ata:</b></div>
                                            <div class='col-sm-9' id="nr_contrato"><?php echo $array[0]["nr_contrato"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Data de assinatura:</b></div>
                                            <div class='col-sm-9' id="dt_assinatura"><?php echo Metodos::ConverteDataBR($array[0]["dt_assinatura"]); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Data de publicação:</b></div>
                                            <div class='col-sm-9' id="dt_publicacao"><?php echo Metodos::ConverteDataBR($array[0]["dt_publicacao"]); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Vigência inicial:</b></div>
                                            <div class='col-sm-9' id="dt_ini_vigencia_contrato"><?php echo Metodos::ConverteDataBR($array[0]["dt_ini_vigencia_contrato"]); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Vigência final:</b></div>
                                            <div class='col-sm-9' id="dt_fim_vigencia_contrato"><?php echo Metodos::ConverteDataBR($array[0]["dt_fim_vigencia_contrato"]); ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Descrição do objeto:</b></div>
                                            <div class='col-sm-9' id="ds_objeto"><?php echo $array[0]["ds_objeto"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Observações da ATA:</b></div>
                                            <div class='col-sm-9' id="ds_obs_contrato"><?php echo $array[0]["ds_obs_contrato"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Fornecedor:</b></div>
                                            <div class='col-sm-9' id="nm_pessoa"><?php echo $array[0]["nm_pessoa"]; ?></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--===================================================-->
                    <!--End page content-->
                </div>
                <!--===================================================-->
                <!--END CONTENT CONTAINER-->
                <!--MENU LATERAL-->
                <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/menuLateral.php"; ?>
                <!--END MENU LATERAL-->
            </div>
            <!-- FOOTER -->
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/rodape.php"; ?>
            <!-- END FOOTER -->
            <!-- SCROLL PAGE BUTTON -->
            <!--===================================================-->
            <button class="scroll-top btn">
                <i class="pci-chevron chevron-up"></i>
            </button>
            <!--===================================================-->
        </div>
        <!--===================================================-->
        <!-- END OF CONTAINER -->
        <!--jQuery [ REQUIRED ]-->
        <script src="/assets/lib/template/js/jquery-2.2.4.min.js"></script>
        <!--BootstrapJS [ REQUIRED ]-->
        <script src="/assets/lib/template/js/bootstrap.min.js"></script>
        <!--NiftyJS [ REQUIRED ]-->
        <script src="/assets/lib/template/js/nifty.min.js"></script>
        <!--Input valor priceformat-->
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>
        <!--MaskedInput-->
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/js/compras/gestao_contratos/ver_contrato.js"></script>
        <!-- END JAVASCRIPT -->

    </body>
</html>
