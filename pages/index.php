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

        <style type="text/css">
            .modal {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                overflow: hidden;
            }

            .modal-dialog {
                top: 0;
                width: 100%;
                height: 100%;
                padding: 0;
                max-width: 100%;
            }
            /*.modal-dialog {
              width: 100%;
              height: 100%;
              padding: 0;
            }*/

            /*.modal-content {
              height: 100%;
              border-radius: 0;
            }*/
        </style>


    </head>
    <!--TIPS-->

    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-lg">

            <?php
            //Cabeçalho do Sistema
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php";
            ?>

            <div class="boxed">
                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">
                    <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <div id="page-title">
                        <!-- <h1 class="page-header text-overflow">Início - Título da Tela</h1> -->
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                            <!-- Dasboard chamados -->
                            <div class="row">
                                <div class="col-sm-4 col-lg-4">

                                    <!--Sparkline bar chart -->
                                    <div class="panel panel-success panel-colorful">
                                        <div class="pad-all media">
                                            <div class="media-left">
                                                <i class="glyphicon glyphicon-user icon-3x icon-fw"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="h3 text-light mar-no media-heading"><span id="totalUsuarios"></span></p>
                                                <span>Total de Usuários</span>
                                            </div>
                                        </div>

                                        <div class="pad-all text-sm">
                                            <button data-target="#modalTotalUsuarios" data-toggle="modal" class="btn btn-default btn-block">Visualizar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-lg-4">

                                    <!--Sparkline bar chart -->
                                    <div class="panel panel-warning panel-colorful">
                                        <div class="pad-all media">
                                            <div class="media-left">
                                                <i class="glyphicon glyphicon-calendar icon-3x icon-fw"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="h3 text-light mar-no media-heading"><span id="totalProgramasTrabalho"></span></p>
                                                <span>Total Recurso liberado</span>
                                            </div>
                                        </div>

                                        <div class="pad-all text-sm">
                                            <button data-target="#modalTotalProgramas" data-toggle="modal" class="btn btn-default btn-block">Visualizar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-lg-4">

                                    <!--Sparkline bar chart -->
                                    <div class="panel panel-info panel-colorful">
                                        <div class="pad-all media">
                                            <div class="media-left">
                                                <i class="glyphicon glyphicon-folder-open icon-3x icon-fw"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="h3 text-light mar-no media-heading"><span id="totalContratos"></span></p>
                                                <span>Total Contratos</span>
                                            </div>
                                        </div>

                                        <div class="pad-all text-sm">
                                            <button data-target="#modalTotalContratos" data-toggle="modal" class="btn btn-default btn-block">Visualizar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-4 col-lg-4">

                                    <!--Sparkline bar chart -->
                                    <div class="panel panel-primary panel-colorful">
                                        <div class="pad-all media">
                                            <div class="media-left">
                                                <i class="glyphicon glyphicon-duplicate icon-3x icon-fw"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="h3 text-light mar-no media-heading"><span id="totalPedidos"></span></p>
                                                <span>Total de Pedidos Necessidades</span>
                                            </div>
                                        </div>

                                        <div class="pad-all text-sm">
                                            <button data-target="#modalTotalPedidos" data-toggle="modal" class="btn btn-default btn-block">Visualizar</button>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-4 col-lg-4">

                                    <!--Sparkline bar chart -->
                                    <div class="panel panel-mint panel-colorful">
                                        <div class="pad-all media">
                                            <div class="media-left">
                                                <i class="glyphicon glyphicon-usd icon-3x icon-fw"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="h3 text-light mar-no media-heading"><span id="totalEmpenhos"></span></p>
                                                <span>Total de Empenhos</span>
                                            </div>
                                        </div>

                                        <div class="pad-all text-sm">
                                            <button data-target="#modalTotalEmpenhos" data-toggle="modal" class="btn btn-default btn-block">Visualizar</button>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-4 col-lg-4">

                                    <!--Sparkline bar chart -->
                                    <div class="panel panel-danger panel-colorful">
                                        <div class="pad-all media">
                                            <div class="media-left">
                                                <i class="glyphicon glyphicon-list-alt icon-3x icon-fw"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="h3 text-light mar-no media-heading"><span id="totalLicitacoes"></span></p>
                                                <span>Total de Licitações</span>
                                            </div>
                                        </div>

                                        <div class="pad-all text-sm">
                                            <button data-target="#modalTotalLicitacoes" data-toggle="modal" class="btn btn-default btn-block">Visualizar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">                
                                <div class="col-md-4 col-sm-4 col-xs-12" style="cursor: pointer;" id="grafico_pedido">
                                    <div style="width: 100%; padding: 10px 17px; display: inline-block; background: #fff; border: 1px solid #E6E9ED; -webkit-column-break-inside:avoid;-moz-column-break-inside:avoid;column-break-inside:avoid;opacity:1;transition:all .2s ease;">
                                        <div>
                                            <h3>Pedidos de Necessidade</h3>
                                        </div>
                                        <div style="display: block;">
                                            <table id="table_pedido_info" style="width:100%">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:37%;">
                                                            <p>Solicitação</p>
                                                        </th>
                                                        <th>
                                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                                <p class="">Autorizador</p>
                                                            </div>
                                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                                <p class="">Quantidade</p>
                                                            </div>
                                                        </th>
                                                    </tr>                                        
                                                    <tr>
                                                        <td style="width:37%;">                                            
                                                            <canvas id="donutChartPedidoSituacao" height="140" width="140"></canvas>
                                                        </td>
                                                        <td class="info_resultado">                                      
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div style="width: 100%; padding: 10px 17px; display: inline-block; background: #fff; border: 1px solid #E6E9ED; -webkit-column-break-inside:avoid;-moz-column-break-inside:avoid;column-break-inside:avoid;opacity:1;transition:all .2s ease;">
                                        <div>
                                            <h3>Ordens Emitidas</h3>
                                        </div>
                                        <div style="display: block;">
                                            <table id="table_tipo_ordem_info" style="width:100%">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:37%;">
                                                            <p>Solicitação</p>
                                                        </th>
                                                        <th>
                                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                                <p class="">Tipo de Ordem</p>
                                                            </div>
                                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                                <p class="">Quantidade</p>
                                                            </div>
                                                        </th>
                                                    </tr>   
                                                    <tr>
                                                        <td style="width:37%;">                                            
                                                            <canvas id="donutChartTipoOrdem" height="140" width="140"></canvas>
                                                        </td>
                                                        <td class="info_resultado_tipo_ordem">                                      
                                                        </td>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">       
                                    <div style="width: 100%; padding: 10px 17px; display: inline-block; background: #fff; border: 1px solid #E6E9ED; -webkit-column-break-inside:avoid;-moz-column-break-inside:avoid;column-break-inside:avoid;opacity:1;transition:all .2s ease;">
                                        <div>
                                            <h3>Funcionários</h3>
                                        </div>
                                        <div style="display: block;">
                                            <table id="table_tipo_vinculo_info" style="width:100%">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:37%;">
                                                            <p>Vínculos</p>
                                                        </th>
                                                        <th>
                                                            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                                                <p class="">Tipo de Vínculo</p>
                                                            </div>
                                                            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                                <p class="">Quantidade</p>
                                                            </div>
                                                        </th>
                                                    </tr>                                        
                                                    <tr>
                                                        <td style="width:37%;">                                            
                                                            <canvas id="donutChartVinculo" height="140" width="140"></canvas>
                                                        </td>
                                                        <td class="info_resultado_vinculo">                                      
                                                        </td>
                                                    </tr>
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

        <!-- /.login-box -->

        <!--jQuery [ REQUIRED ]-->
        <script src="/assets/lib/template/js/jquery-2.2.4.min.js"></script>
        <!--BootstrapJS [ REQUIRED ]-->
        <script src="/assets/lib/template/js/bootstrap.min.js"></script>
        <!--NiftyJS [ REQUIRED ]-->
        <script src="/assets/lib/template/js/nifty.min.js"></script>        
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <!-- END JAVASCRIPT -->        
        <script src="/assets/js/index.js"></script>

        <!--DataTables [OPT]-->
        <script src="/assets/lib/template/plugins/datatables/media/js/jquery.dataTables.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
        <script src="/assets/lib/template/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>                        
        <!-- Chart JS [OPT]  -->
        <script src="/assets/lib/chartjs/Chart.min.js"></script>



        <div class="modal fade" id="modalTotalUsuarios" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!--Modal header-->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                        <h4 class="modal-title">Informações</h4>
                    </div>

                    <!--Modal body-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <!-- <div class="panel-heading">
                                        <h3 class="panel-title">Hover rows</h3>
                                    </div> -->

                                    <!--Hover Rows-->
                                    <!--===================================================-->
                                    <div class="panel-body">

                                        <table id="tabela" class="table table-striped table-bordered display" width="100%"></table>

                                    </div>
                                    <!--===================================================-->
                                    <!--End Hover Rows-->

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Modal footer-->
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Fechar</button>
                        <!-- <button class="btn btn-primary"><span class="glyphicon glyphicon-print"></span>  Imprimir</button> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTotalProgramas" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!--Modal header-->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                        <h4 class="modal-title">Informações</h4>
                    </div>

                    <!--Modal body-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <!-- <div class="panel-heading">
                                        <h3 class="panel-title">Hover rows</h3>
                                    </div> -->

                                    <!--Hover Rows-->
                                    <!--===================================================-->
                                    <div class="panel-body">

                                        <table id="tabelaProgramaTrabalho" class="table table-striped table-bordered display" width="100%"></table>

                                    </div>
                                    <!--===================================================-->
                                    <!--End Hover Rows-->

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Modal footer-->
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Fechar</button>
                        <!-- <button class="btn btn-primary"><span class="glyphicon glyphicon-print"></span>  Imprimir</button> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTotalContratos" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!--Modal header-->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                        <h4 class="modal-title">Informações</h4>
                    </div>

                    <!--Modal body-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <!-- <div class="panel-heading">
                                        <h3 class="panel-title">Hover rows</h3>
                                    </div> -->

                                    <!--Hover Rows-->
                                    <!--===================================================-->
                                    <div class="panel-body">

                                        <table id="tabelaContratos" class="table table-striped table-bordered display" width="100%"></table>

                                    </div>
                                    <!--===================================================-->
                                    <!--End Hover Rows-->

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Modal footer-->
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Fechar</button>
                        <!-- <button class="btn btn-primary"><span class="glyphicon glyphicon-print"></span>  Imprimir</button> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTotalLicitacoes" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!--Modal header-->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                        <h4 class="modal-title">Informações</h4>
                    </div>

                    <!--Modal body-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <!-- <div class="panel-heading">
                                        <h3 class="panel-title">Hover rows</h3>
                                    </div> -->

                                    <!--Hover Rows-->
                                    <!--===================================================-->
                                    <div class="panel-body">

                                        <table id="tabelaLicitacoes" class="table table-striped table-bordered display" width="100%"></table>

                                    </div>
                                    <!--===================================================-->
                                    <!--End Hover Rows-->

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Modal footer-->
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Fechar</button>
                        <!-- <button class="btn btn-primary"><span class="glyphicon glyphicon-print"></span>  Imprimir</button> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTotalEmpenhos" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!--Modal header-->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                        <h4 class="modal-title">Informações</h4>
                    </div>

                    <!--Modal body-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <!-- <div class="panel-heading">
                                        <h3 class="panel-title">Hover rows</h3>
                                    </div> -->

                                    <!--Hover Rows-->
                                    <!--===================================================-->
                                    <div class="panel-body">

                                        <table id="tabelaEmpenhos" class="table table-striped table-bordered display" width="100%"></table>

                                    </div>
                                    <!--===================================================-->
                                    <!--End Hover Rows-->

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Modal footer-->
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Fechar</button>
                        <!-- <button class="btn btn-primary"><span class="glyphicon glyphicon-print"></span>  Imprimir</button> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTotalPedidos" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!--Modal header-->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                        <h4 class="modal-title">Informações</h4>
                    </div>

                    <!--Modal body-->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <!-- <div class="panel-heading">
                                        <h3 class="panel-title">Hover rows</h3>
                                    </div> -->

                                    <!--Hover Rows-->
                                    <!--===================================================-->
                                    <div class="panel-body">

                                        <table id="tabelaPedidos" class="table table-striped table-bordered display" width="100%"></table>

                                    </div>
                                    <!--===================================================-->
                                    <!--End Hover Rows-->

                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Modal footer-->
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Fechar</button>
                        <!-- <button class="btn btn-primary"><span class="glyphicon glyphicon-print"></span>  Imprimir</button> -->
                    </div>
                </div>
            </div>
        </div>



    </body>
</html>
