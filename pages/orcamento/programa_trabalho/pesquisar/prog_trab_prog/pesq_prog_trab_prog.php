<!DOCTYPE html>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/model/orcamento/programaTrabalho/index.load.php";
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
                        <h1 class="page-header text-overflow">Programa Trabalho</h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <div id="page-content"> 
                        <!-- Menu Programa Trabalho -->
                        <div id="menu_prog_trab"></div>
                        <!-- Menu Programa Trabalho -->
                                    
                        <!-- Inicio do Formulário de Pesquisa de Trabalho Programa-->
                        <form data-toggle="validator" class="form-horizontal" id="form_prog_trab_prog" role="form" action="#" method="post">
                            <input type="hidden" name="id_prog_trab_prog" id="id_prog_trab_prog">
                            <div class="panel">                                          
                                <div class="panel-heading">
                                    <h3 class="panel-title">Pesquisar Programa</h3>
                                </div>
                                <div class="input_ordens">
                                    <div class="form-group">
                                        <div class="col-md-4"></div>
                                            <div class="col-md-4">
                                                <div class="panel-body">
                                                    <p class="form-control-static">Programa: <span id="obrigatorio" class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span><span id="informacao" class="text-danger"><i class="glyphicon glyphicon-info-sign"></i> (4 digitos)</span></p>
                                                    <input type="text" class="form-control" rows="7" name="pesq_prog_trab_prog" id="pesq_prog_trab_prog" required="true">
                                                </div>
                                            </div>
                                        <div class="col-md-4"></div>
                                    </div>
                                </div>                                        
                             
                                <div class="form-group">
                                    <div class="col-md-5"></div>
                                    <div class="col-md-2 text-center">
                                        <button type="submit" class="btn btn-success btn-editar btn-rounded">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Atualizar
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-pesquisar btn-rounded btn-block">
                                            <i class="fa fa-search" aria-hidden="true"></i> Pesquisar
                                        </button>
                                        <button type="reset" class="btn btn-default btn-rounded btn-limpar" title="Cancelar">
                                            <i class="glyphicon glyphicon-remove"></i> Cancelar
                                        </button>
                                    </div>
                                    <div class="col-md-5"></div>
                                </div>
                            </div>
                        </form>     
                        <!-- Fim do Formulário de Pesquisa de Trabalho Programa-->
                        <div id="retorno"></div>
                    </div>
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
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>     
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!--<script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>-->
        <script src="/assets/js/orcamento/prog_trab/pesquisar/prog_trab_prog/pesq_prog_trab_prog.js"></script>
     
        <!-- END JAVASCRIPT -->
    </body>
</html>

