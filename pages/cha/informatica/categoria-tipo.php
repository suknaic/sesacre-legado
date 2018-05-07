<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/index.load.php";
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
        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css">
    </head>
    <!--TIPS-->

    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-lg">

            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

            <div class="boxed">

                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">

                    <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Tipo de Chamado</h1>
                        <h4 class="text-main pad-btm bord-btm">Selecione para que você deseja atendimento:</h4>
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <div class="row">

                            <div class="col-sm-3">
                              <div class="panel-body text-center">
                                <div class="mar-top">
                                  <a href="" class="btn btn-lg btn-default btn-hover-primary panel-bordered-primary" style="width: 100%">
                                    <i class="fa fa-cogs fa-1x" style="margin-right: 20px"></i>
                                    <span class="text-lg mar-no">Equipamentos</span>
                                  </a>
                                </div>
                              </div>
                            </div>

                            <div class="col-sm-3">
                              <div class="panel-body text-center">
                                <div class="mar-top">
                                  <a href="" class="btn btn-lg btn-default btn-hover-primary panel-bordered-primary" style="width: 100%">
                                    <i class="fa fa-sitemap fa-1x" style="margin-right: 20px"></i>
                                    <span class="text-lg mar-no">Infraestrutura</span>
                                  </a>
                                </div>
                              </div>
                            </div>

                            <div class="col-sm-3">
                              <div class="panel-body text-center">
                                <div class="mar-top">
                                  <a href="sistemas/cat-prim.php" class="btn btn-lg btn-default btn-hover-primary panel-bordered-primary" style="width: 100%">
                                    <i class="fa fa-terminal fa-1x" style="margin-right: 20px"></i>
                                    <span class="text-lg mar-no">Sistemas</span>
                                  </a>
                                </div>
                              </div>
                            </div>

                            <div class="col-sm-3">
                              <div class="panel-body text-center">
                                <div class="mar-top">
                                  <a href="" class="btn btn-lg btn-default btn-hover-primary panel-bordered-primary" style="width: 100%">
                                    <i class="fa fa-volume-control-phone fa-1x" style="margin-right: 20px"></i>
                                    <span class="text-lg mar-no">Telefonia</span>
                                  </a>
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
        <!--DataTables [OPT]-->
        <script src="/assets/lib/template/plugins/datatables/media/js/jquery.dataTables.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
        <script src="/assets/lib/template/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>

        <!-- END JAVASCRIPT -->

    </body>
</html>
