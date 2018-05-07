<!DOCTYPE html>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/model/compras/gcon/usuario/usuario.load.php";
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
                        
                            <!-- Menu GCON -->  
                            <div id="menu_gcon"></div>
                            <!-- Fim_Menu_Gcon -->
                            
                            <form class="form-horizontal" id="form_unidade_pesq"action="#"method="post">
                                <input type="hidden" name="id_perfil_pessoa" id="id_perfil_pessoa">
                                <div id="campo">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Editar Usuário</h3>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3"></div>

                                                <div class="col-sm-3">
                                                    <div class="panel-body">Usuário:<span class="text-danger"> *</span>
                                                        <select class="form-control select" name="usuario" id="usuario">
                                                            <option value="0">Selecione um usuário</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            
                                                <div class="col-sm-3">
                                                    <div class="panel-body">Permissão:<span class="text-danger"> *</span>
                                                        <select class="form-control select" name="permissao" id="permissao">
                                                            <option value="0">Selecione o tipo de permissão</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            
                                            <div class="col-sm-3"></div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-4"></div>
                                                <div class="col-sm-4 text-center">
                                                    <button class="btn btn-success btn-editar btn-rounded" type="button" style="display: none;">
                                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Editar
                                                    </button>
                                                    <button type="button" class="btn btn-default btn-rounded btn-limpar" style="display: none;">
                                                        <i class="fa fa-remove" aria-hidden="true"></i> Cancelar
                                                    </button>
                                                </div>
                                            <div class="col-sm-4"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <div id="retorno"></div>
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
        <!--select2-->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <script src="/assets/js/compras/gcon/usuario/usuario.js"</script>
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        
        <!-- END JAVASCRIPT -->
    </body>
</html>
