<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/orcamento/qdd/index.load.php";
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

            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; 
                //Modal Alert
                require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/modalAlert.html";
            ?>
            

            <div class="boxed">

                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">

                    <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <div id="page-title">
                        <h1 class="page-header text-overflow">QDD <?php echo ($ano == 0)? "" : $ano; ?></h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <div id="menu_pta">
                            <?php 
                                if($existe){
                                    require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/orcamento/qdd/menuQdd.php";  
                                }
                            ?>
                        </div>
                        <div class="panel"> 
                            <div class="panel-body">                                
                                <div class="form-group">
                                    <input type="hidden" id="ano" value="<?php echo $ano; ?>" />                                    
                                    <!--Horizontal Form-->
                                    <!--===================================================-->
                                    <form class="form-horizontal form">                                                                                                                                                                             
                                            <div class="col-md-3">                                                    
                                                <label for="inputAno">
                                                    Ano: <span class="text-danger">*</span>
                                                </label>                                                                
                                                <div class="input-group">
                                                    <span class="input-group-addon"><p class="fa fa-sort-numeric-asc inputPFa"></p></span>
                                                    <input class="form-control" type="text" name="inputAno" value="<?php echo $ano; ?>"
                                                           id="inputAno" disabled="true" required>
                                                </div>                                                   
                                            </div>                                                                                                                                                                                                                                                                                                                     
                                        <!-- <div class="panel-body"> -->                                                                                
                                    </form>
                                    <!--===================================================-->
                                    <!--End Horizontal Form-->                                                                                
                                </div>
                                <!-- End <div class="form-group"> -->                                       
                            </div>
                            <!-- Footer Form -->
                            <div class="panel-footer text-right"> 
                                <button class="btn btn-danger btn-rounded btn-remover" <?php echo $botaoRemoverDisabled; ?> type="button">
                                    <i class="fa fa-trash fa-lg" aria-hidden="true"></i> Remover
                                </button>
                                <button class="btn btn-success btn-rounded btn-salvar" <?php echo $botaoCriarDisabled; ?> type="button">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Criar
                                </button>
                            </div>
                            <!-- End Form -->
                        </div>
                        
                        <div class="panel-body selecaoAno" style="display: none;">                                
                            <div class="form-group">
                                <div class="panel-body" >                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="anoSelect">
                                                Ano:
                                            </label>                                                        
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-list inputPFa"></p>
                                                </span>
                                                <select id="anoSelect" class="form-control anoSelect">
                                                    <option value="0">Selecione um Ano</option>                                                                
                                                    <?php
                                                        echo Metodos::retornaAnosSelect(date("Y"));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                                                                                                                                                                                                                                                                               
                            </div>
                            <!-- End <div class="form-group"> -->                                       
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
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>     
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/js/orcamento/qdd/index.js"></script>
           
        <!-- END JAVASCRIPT -->

    </body>
</html>
