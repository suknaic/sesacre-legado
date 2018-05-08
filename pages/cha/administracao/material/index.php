<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/cha/index.load.php";
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
        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css">
        <!--selec2-->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
        <!-- Datapicker -->
        <link href="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
        <!--DataTables [ OPT ]-->
        <link href="/assets/lib/template/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.bootstrap.min.css" rel="stylesheet">
    </head>
    <!--TIPS-->

    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-sm">

            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php";
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/modalAlert.html";
            ?>

            <div class="boxed">

                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">

                    <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Busca de Materiais</h1>
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    <div id="page-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-horizontal">
                                    <div class="panel">
                                        <div id="menu_material"></div>
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Dados do Material</h3>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <div class="panel-body">N° Material: <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" name="nm_material" id="nm_material" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="panel-body">N° Série: <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" name="nm_serie" id="nm_serie" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="panel-body">N° Patrimônio: <span class="text-danger">*</span>
                                                    <input type="text" class="form-control" name="nm_patrimonio" id="nm_patrimonio" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5"></div>
                                            <div class="col-md-2 text-center">
                                                <button  type="button" class="btn btn-primary btn-rounded btn-block btn-pesquisar" title="Pesquisar">
                                                    <i class="fa fa-search" aria-hidden="true"></i> Pesquisar
                                                </button>
                                            </div>
                                            <div class="col-md-5"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="page-content" class="esconder">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Lista de Materiais</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="tabela" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-capitalize text-center">Nome</th>
                                                            <th class="text-capitalize text-center">Data de Aquisição</th>
                                                            <th class="text-capitalize text-center">Marca</th>
                                                            <th class="text-capitalize text-center">Modelo</th>
                                                            <th class="text-capitalize text-center">N° Patrimônio</th>
                                                            <th class="text-capitalize text-center">Valor</th>
                                                            <th class="text-capitalize text-center">Grantia</th>
                                                            <th class="text-capitalize text-center">N° Serie</th>
                                                            <th class="text-capitalize text-center">Estado</th>
                                                            <th class="text-capitalize text-center">Unidade de Medida</th>
                                                            <th class="text-capitalize text-center">Memória RAM</th>
                                                            <th class="text-capitalize text-center">Processador</th>
                                                            <th class="text-capitalize text-center">HD</th>
                                                            <th class="text-capitalize text-center">Fonte</th>
                                                            <th class="text-capitalize text-center">Wireless</th>
                                                            <th class="text-capitalize text-center">Ações</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

            <!--MENU LATERAL-->
            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/menuLateral.php";
            ?>
            <!--END MENU LATERAL-->

            <!-- FOOTER -->
            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/rodape.php";
            ?>
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
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>
        <!--DataTables-->
        <script src="/assets/lib/template/plugins/datatables/media/js/jquery.dataTables.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
        <script src="/assets/lib/template/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/dataTables.buttons.min.js"></script>           
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/jszip.min.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/pdfmake.min.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/vfs_fonts.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/buttons.html5.min.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/buttons.print.min.js"></script> 
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <script src="/assets/js/cha/administracao/material/index.js"></script>
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
        <script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!--Select2-->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!-- END JAVASCRIPT -->
    </body>
</html>

