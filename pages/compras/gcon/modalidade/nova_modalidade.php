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
        <style>
            .rotate:hover
            {
                -webkit-transform: rotateZ(50deg);
                -ms-transform: rotateZ(50deg);
                transform: rotateZ(50deg);
            }
            .grow:hover
            {
                -webkit-transform: scale(1.3);
                -ms-transform: scale(1.3);
                transform: scale(1.3);
            }
            .hover-btn:hover
            {
                display: block;
            }
        </style>
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
                        <!-- Inicio do Formulário de Cadastro de Modalidade-->
                        <form data-toggle="validator" class="form-horizontal" id="form_nova_modalidade" role="form" action="#" method="post">                                      
                            <div class="panel">
                                <div class="panel-footer text-left" id="menu_gcon">
                                    <div class="btn-group dropdown" id="butao">
                                        <button class="btn btn-dark btn-hover add-tooltip dropdown-toggle dropdown-toggle-icon btn-rounded" style="display: block" aria-expanded="false" data-toggle="dropdown" type="button">
                                            <i class="ion-chevron-right" style="margin-bottom: 6px; margin-left: 7px; margin-right: 7px; margin-top: 6px" id="icone" aria-hidden="true"></i> Menu
                                        </button>
                                    </div>
                                </div>
                                <div class="panel-heading">
                                    <h3 class="panel-title">Cadastro de Modalidade</h3>
                                </div>
                                <div class="input_ordens">
                                    <div class="form-group">
                                        <div class="col-md-3"></div>
                                        
                                        <div class="col-md-6">
                                            <div class="panel-body">
                                                <p class="form-control-static">Modalidade: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                                <input type="text" class="form-control" name="nova_modalidade" id="nova_modalidade" placeholder="" required="true">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3"></div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2 text-center">
                                        <button type="submit" class="btn btn-success btn-salvar btn-block btn-rounded" title="Salvar">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                        </button>
                                    </div>
                                    <div class="col-md-2 text-center">    
                                        <button type="reset" class="btn btn-default btn-rounded btn-block btn-limpar" title="Limpar">
                                            <i class="glyphicon glyphicon-erase"></i> Limpar
                                        </button>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>  
                        </form>     
                        <!-- Fim do Formulário de Cadastro de Modalidade-->
                    </div>
                </div>
                <!--===================================================-->
                <!--END CONTENT CONTAINER-->

                <!--MENU LATERAL-->
                <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/menuLateral.php"; ?>
                <!--END MENU LATERAL-->
            </div>

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
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!--<script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>-->
        <script src="/assets/js/compras/gcon/Modalidade/nova_modalidade.js"></script>
     
        <!-- END JAVASCRIPT -->
    </body>
</html>

