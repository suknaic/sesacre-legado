<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/rh/relatorios/index.load.php";
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
        <!--        DataTables [ OPT ]
                <link href="/assets/lib/template/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
                <link href="/assets/lib/template/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet">
                <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.dataTables.min.css" rel="stylesheet">
                <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.bootstrap.min.css" rel="stylesheet">
                 Estilo Default das Páginas [ REQUIRED ] -->
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
                <!--===================================================-->
                <div id="content-container">

                    <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">

                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel">
                                    <!--===================================================-->
                                    <div class="panel-heading ">
                                        <h3 class="panel-title">                                                                                       
                                            Relatório de Férias, Licenças e Concessões:
                                        </h3>
                                    </div>
                                    <!--Horizontal Form-->

                                    <!--===================================================-->
                                    <form class="form-horizontal formRelatorio">

                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="col-md-1"> </div>
                                                <div class="col-md-4">
                                                    Quebre de Paginas:<span class="text-danger">*</span>                                                        
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="tipo" class="form-control">
                                                            <option value="0">Selecione Tipo de Relatório</option>                                                                
                                                            <option value="1">Por Lotação</option>
                                                            <option value="2">Por Vínculo</option>

                                                            <?php
                                                            // echo $lotacoes;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-1">
                                                    <div class="input-group">
                                                        <br>
                                                        Data:
                                                    </div>

                                                </div>
                                                <div class="col-md-2">
                                                    Ano:<span class="text-danger">*</span> 
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="ano" class="form-control">
                                                            <option value="0">Selecione o Ano</option>                                                                
                                                            <?php
                                                            // echo $lotacoes;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    Mês:
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="mes" class="form-control">
                                                            <option value="0">Selecione o Mês</option>                                                                
                                                            <option value="01">Janeiro</option>
                                                            <option value="02">Fevereiro</option>
                                                            <option value="03">Março</option>
                                                            <option value="04">Abril</option>
                                                            <option value="05">Maio</option>
                                                            <option value="06">Junho</option>
                                                            <option value="07">Julho</option>
                                                            <option value="08">Agosto</option>
                                                            <option value="09">Setembro</option>
                                                            <option value="10">Outubro</option>
                                                            <option value="11">Novembro</option>
                                                            <option value="12">Dezembro</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <hr>
                                            <div class="quebres">
                                                <div class="form-group">
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                        Situação:
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="id_situacao" class="form-control">
                                                                <option value="0">Selecione Situação</option>                                                                
                                                                <?php
                                                                // echo $lotacoes;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        Lotação:
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="id_lotacao" class="form-control">
                                                                <option value="0">Selecione Lotação</option>                                                                
                                                                <?php
                                                                // echo $lotacoes;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>    
                                                <div class="form-group">    
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-4">
                                                        Vínculo:
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="id_vinculo" class="form-control">
                                                                <option value="0">Selecione Vínculo</option>                                                                
                                                                <?php
                                                                // echo $lotacoes;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>    


                                            </div>
                                            <!-- End <div class="form-group"> -->
                                        </div>
                                        <!-- <div class="panel-body"> -->
                                        <!-- Footer Form -->
                                        <div class="panel-footer text-center">
                                            <button type="button" class="btn btn-default btn-default btn-rounded btn-limpar">
                                                Limpar
                                            </button>     
                                            <button class="btn btn-primary btn-rounded btn-gerar" type="button">
                                                <i class="fa fa-print" aria-hidden="true"></i> Gerar
                                            </button>
                                        </div>
                                        <!-- End Form -->

                                    </form>
                                    <!--End Horizontal Form-->
                                </div>
                            </div>
                        </div>
                        <!-- Fim Form -->

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
<!--        <script src="/assets/lib/template/plugins/datatables/media/js/jquery.dataTables.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
        <script src="/assets/lib/template/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>        
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/dataTables.buttons.min.js"></script>           
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/jszip.min.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/pdfmake.min.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/vfs_fonts.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/buttons.html5.min.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/buttons.print.min.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script>  Search sem Acento -->
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>     
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/js/rh/relatorios/indexSituacao.js"></script> 
        <!--        Datapicker-->
        <script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!--MaskedInput-->
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!-- select2 -->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!-- END JAVASCRIPT -->

    </body>
</html>
