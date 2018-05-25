<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/compras/gcon/gconPermi.load.php";
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
                        <h1 class="page-header text-overflow">Gestão de Compras</h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <div id="page-content">
                        <div class="panel">
                            <div class="row">
                                <ul class="nav nav-tabs nav-justified botaoDocumentoAcoes" id="restoMenu">
                                    <li class="dropdown" id="menu_gcon">
                                        <a href="#" data-toggle="dropdown" id="butao" class="dropdown-toggle">Menu <b class="caret"></b></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="panel-heading">
                                <h3 class="panel-title">Unidades Contempladas Desativadas</h3>
                            </div>
                            <input type="hidden" name="id_unidade" id="id_unidade">
                            <div class="panel-body">
                                <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tabela_unidade" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="text-capitalize text-center">Unidade</th>
                                                        <th class="text-capitalize text-center">Ação</th>
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

                <!--===================================================
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
            <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
            <!-- DIALOG CONFIRM [OPT] -->
            <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>     
            <!--JAVASCRIP da pagina-->
            <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
            <script src="/assets/lib/sesacre/funcoes.js"></script>
            <script src="/assets/js/compras/gcon/Unidade/unidadeDesativada.js"</script>
            <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
            <!-- END JAVASCRIPT -->

    </body>
</html>
