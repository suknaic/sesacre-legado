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
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.bootstrap.min.css" rel="stylesheet">
        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css">
        <!--selec2-->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
        <!-- Datapicker -->
        <link href="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
    </head>
    <!--TIPS-->

    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-sm">

            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/modalAlert.html"; ?>

            <div class="boxed">

                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">

                    <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Categoria Secundária</h1>
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <form data-toggle="validator" class="form-horizontal" id="form_bloco" role="form" action="#" method="post">
                            <input type="hidden" name="idCategoriaSecundaria" id="idCategoriaSecundaria">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Formulário</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-3">
                                        <div class="panel-body">
                                            <p class= "form-control-static">Categoria Secundária: <span class="text-danger">*</span></p>
                                            <input type="text" class="form-control" name="categoriaSecundaria" id="nmCategoriaSecundaria" required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="panel-body">
                                            <p class= "form-control-static">Valor: <span class="text-danger">*</span></p>
                                            <input type="text" class="form-control" name="vlSecundaria" id="vlCategoriaSecundaria" placeholder="Informe o valor em R$"  required="true">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="panel-body">
                                            <p class= "form-control-static">Categoria Primária: <span class="text-danger">*</span></p>
                                            <select class="form-control" name="categoriaPrimaria" id="idCategoriaPrimaria" title="Selecione uma Categoria Primária" required="true">
                                                <option value="0">Selecione a Categoria Primária</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                                <div class="form-group"><br>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success btn-salvar btn-rounded btn-block" type="button" title="Salvar">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                        </button>
                                        <button class="btn btn-success btn-editar btn-rounded btn-block" type="button" title="Salvar">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Editar
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-default btn-limpar btn-rounded btn-block" type="button" title="Limpar">
                                            <i class="glyphicon glyphicon-erase" aria-hidden="true"></i> Limpar
                                        </button>
                                        <button class="btn btn-default btn-cancelar btn-rounded btn-block" type="button" title="Limpar">
                                            <i class="glyphicon glyphicon-remove" aria-hidden="true"></i> Cancelar
                                        </button>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                        </form>

                        <div id="page-content">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Lista de Categorias Secundárias</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="tabela" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-capitalize text-center">Categoria Secundária</th>
                                                            <th class="text-capitalize text-center">Valor</th>
                                                            <th class="text-capitalize text-center">Categoria Primária</th>
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
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/dataTables.buttons.min.js"></script>
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/jszip.min.js"></script>
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/pdfmake.min.js"></script>
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/vfs_fonts.js"></script>
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/buttons.html5.min.js"></script>
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/buttons.print.min.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script>
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
        <script src="/assets/js/cha/administracao/categoriaSecundaria/index.js"></script>
        <!--Select2-->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!-- END JAVASCRIPT -->

    </body>
</html>
