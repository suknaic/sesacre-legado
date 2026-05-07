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
    <link href="/assets/lib/template/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css"
          rel="stylesheet">
    <!-- Estilo Default das Páginas [ REQUIRED ] -->
    <link rel="stylesheet" href="/assets/css/estilo.css">
    <!--Datapicker-->
    <link href="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- Checkbox -->
    <link href="/assets/lib/template/plugins/magic-check/css/magic-check.min.css" rel="stylesheet">
</head>
<!--TIPS-->

<body>
<div id="container" class="effect aside-float aside-bright mainnav-lg">

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
            <div id="page-title">
                <h1 class="page-header text-overflow">Log</h1>
            </div>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--End page title-->

            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">
                
                <!-- menu de navegação -->
                <!--Nav Tabs-->
                <div id="menu_log">

                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-heading ">
                                <h3 class="panel-title">Pesquisar Por Usuário</h3>
                            </div>

                            <!--Horizontal Form-->
                            <!--===================================================-->
                            <form class="form-horizontal formVinculo">
                                <div class="panel-body">
                                    <div class="form-group">

                                        <div class="col-md-4">
                                            <div class="panel-body">
                                                Usuário: <span class="text-danger">*</span>
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                    <select id="idPessoa" class="form-control">
                                                        <option value="0">Selecione um Usuário</option>
                                                        <option value="2">Marcel Menezes de Melo</option>
                                                        <?php

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="panel-body">
                                                Data Início:
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-calendar inputPFa"></p>
                                                            </span>
                                                    <input type="text" class="form-control" name="dt_inicio"
                                                           id="dt_inicio" placeholder="__/__/____" required="true">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="panel-body">
                                                Data Fim:
                                                <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-calendar inputPFa"></p>
                                                            </span>
                                                    <input type="text" class="form-control" name="dt_fim" id="dt_fim"
                                                           placeholder="__/__/____" required="true">
                                                </div>
                                            </div>
                                        </div>
                                                
                                        <div class="col-md-2">
                                            <div class="panel-body">
                                                Registros: <span class="text-danger">(Máx 50)</span>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                    </span>
                                                    <input type="number" class="form-control" name="limite" id="limite" placeholder="20" value="20">
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <!-- End <div class="form-group"> -->
                                    <div class="form-group">
                                        
                                        
                                        <div class="col-md-6">
                                            <div class="panel-body">
                                                <div class="checkbox">
                                                    <!-- Inline Checkboxes -->
                                                    <input id="chk-login" class="magic-checkbox chkAcoes" value="L" type="checkbox" checked="">
                                                    <label for="chk-login">Login</label>

                                                    <input id="chk-inseriu" class="magic-checkbox chkAcoes" value="I" type="checkbox" checked="">
                                                    <label for="chk-inseriu">Inseriu</label>

                                                    <input id="chk-alterou" class="magic-checkbox chkAcoes" value="U" type="checkbox" checked="">
                                                    <label for="chk-alterou">Alterou</label>
                                                    
                                                    <input id="chk-removeu" class="magic-checkbox chkAcoes" value="D" type="checkbox" checked="">
                                                    <label for="chk-removeu">Removeu</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                                                        
                                </div>
                                <!-- <div class="panel-body"> -->


                                <!-- Footer Form -->
                                <div class="panel-footer text-right">
                                    <button type="button" class="btn btn-default btn-default btn-rounded btn-limpar">
                                        Limpar
                                    </button>                                  
                                    <button class="btn btn-primary btn-rounded btn-pesquisar" type="button">
                                        Pesquisar
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                                <!-- End Form -->
                            </form>
                            <!--===================================================-->
                            <!--End Horizontal Form-->

                        </div>
                    </div>
                </div>


                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Logs</h3>
                    </div>
                    <div class="panel-body">
                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="tabela" class="table table-striped table-bordered" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Ação</th>
                                            <th class="text-center">Tabela</th>
                                            <th class="text-center">IP</th>
                                            <th class="text-center">Quando</th>
                                            <th class="text-center">Atual</th>
                                            <th class="text-center">Anterior</th>
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
<script src="/assets/lib/template/plugins/datatables/media/js/jquery.dataTables-nifty.js"></script>
<script src="/assets/lib/template/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
<script src="/assets/lib/template/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
<!-- DIALOG CONFIRM [OPT] -->
<script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>
<!--JAVASCRIP da pagina-->
<script src="/assets/lib/loadingover/loadingoverlay.js"></script>
<script src="/assets/lib/sesacre/funcoes.js"></script>
<!--Datapicker-->
<script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!--MaskedInput-->
<script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
<script src="/assets/js/sistema/log/index.js"></script>

<!-- END JAVASCRIPT -->

</body>
</html>
