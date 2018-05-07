<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/financeiro/autorizacoes/autorCentral.load.php";
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
                        <h1 class="page-header text-overflow">Autorizar Pedido Central</h1>
                    </div>
                    <!--End page title-->
                    <ol class="breadcrumb">
                        <li class="active"><a href="index.php">Voltar</a></li>
                    </ol>
                    <!--Page content-->
                    <div id="page-content">
                        <!--Informaçao do pedido-->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel">
                                    <div class="panel-heading ">
                                        <h3 class="panel-title">Informações do pedido</h3>
                                    </div>

                                    <input type="hidden" name="pedido" id="pedido" value="<?php echo $id; ?>" />

                                    <div class="panel-body">
                                        <div class="row">
                                            <div class='col-sm-2'><b>Nº Pedido:</b></div>
                                            <div class='col-sm-9' id="nPedido"><?php echo $dados[0]["numero"] ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Lotação:</b></div>
                                            <div class='col-sm-9' id="lotacao"><?php echo $dados[0]["nm_lotacao"] ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Tipo de gasto:</b></div>
                                            <div class='col-sm-9' id="tipoGasto"><?php echo $dados[0]["nm_tipo_gasto"] ?></div>
                                        </div>

                                        <?php
                                        if ($dados[0]["tp_contrato"] == 1) {
                                            ?>
                                            <div class="row">
                                                <div class='col-sm-2'><b>Ata:</b></div>
                                                <div class='col-sm-9' id="ata"><?php echo $dados[0]["nr_contrato"] ?></div>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="row">
                                                <div class='col-sm-2'><b>Contrato:</b></div>
                                                <div class='col-sm-9' id="contrato"><?php echo $dados[0]["nr_contrato"] ?></div>
                                            </div>
                                        <?php } ?>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Fonte:</b></div>
                                            <div class='col-sm-9' id="fonte"><?php echo $dados[0]["nr_fonte"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Projeto/Atividade:</b></div>
                                            <div class='col-sm-9' id="projetoAtividade"><?php echo $dados[0]["cd_programa_trabalho"] . "-" . $dados[0]["ds_programa_trabalho"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Despesa:</b></div>
                                            <div class='col-sm-9' id="despesaPedido"><?php echo $dados[0]["cd_despesa"] . "-" . $dados[0]["ds_despesa"]; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class='col-sm-2'><b>Descrição do Pedido:</b></div>
                                            <div class='col-sm-9' id="descPedido"><?php echo $dados[0]["ds_pedido"]; ?></div>
                                        </div>

                                        <?php if (empty($dados[0]["nr_item"])) { ?>
                                            <div class="row">
                                                <div class='col-sm-2'><b>Valor Pedido:</b></div>
                                                <div class='col-sm-9' id="valorPedido"><?php echo Metodos::ConverteValorBr($dados[0]["vl_pedido"], '4'); ?></div>
                                            </div>
                                        <?php } ?>
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
                                        <h3 class="panel-title">Itens da pre-ordem</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                            <table id="tabela" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Nº</th>
                                                        <th class="text-center">Item</th>
                                                        <th class="text-center">Descrição GRP</th>
                                                        <th class="text-center">Descrição Sesacrenet</th>
                                                        <th class="text-center">Unid</th>
                                                        <th class="text-center">Tipo</th>
                                                        <th class="text-center">Elemento de despesa</th>
                                                        <th class="text-center">QTD</th>
                                                        <th class="text-center">Valor unit.</th>
                                                        <th class="text-center">Total</th>
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
                        <!--===================================================-->
                        <form data-toggle="validator" class="form-horizontal" id="form-documento" role="form" action="#" method="post">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Autorização do pedido</h3>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <div class="panel-body">
                                            Observação:<span class="text-danger">*</span>
                                            <textarea class="form-control" rows="4" id="obsAutoriza">De acordo</textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-6"></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <div class="panel-body">
                                            <button class="btn btn-success btn-salvar btn-rounded btn-block" type="button">
                                                <i class="fa fa-floppy-o" aria-hidden="true"></i>Autorizar
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="panel-body">
                                            <button class="btn btn-danger btn-cancelar btn-rounded btn-block" value="<?php echo $id; ?>" type="button">
                                                <i class="fa fa-trash" aria-hidden="true"></i></i> Cancelar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        <script src="/assets/js/financeiro/autorizacoes/central/autorCentral.js"></script>
        <!-- END JAVASCRIPT -->

    </body>
</html>
