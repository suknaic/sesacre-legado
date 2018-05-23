<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/compras/gcon/gcon.load.php";
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
                        <!--Modal upload-->
                        <div class=" modal fade modal-upload" id="upload" 
                             tabindex="-1" role="dialog" 
                             aria-labelledby="mySmallModalLabel"
                             data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Fechar"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Anexo</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="form-upload" name="form-upload">
                                            <input type="hidden" name="id_processo" id="id_processo">
                                            <input type="hidden" name="acao" id="acao" value="inserir_anexo">
                                            <input type="file" name="file" id="file">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default fechar" data-dismiss="modal">Fechar</button>
                                        <input type="submit" class="btn btn-primary btn-enviarUpload" value="Enviar">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Fim Modal Upload-->

                        <!-- Inicio do Formulário de Pesquisa de Processos-->
                        <form data-toggle="validator" class="form-horizontal formPesquisa" id="form_pesquisa" role="form" action="#"method="post">

                            <div class="panel">
                                <div class="panel-footer text-left" id="menu_gcon">
                                    <div class="btn-group dropdown" id="butao">
                                        <button class="btn btn-dark btn-hover add-tooltip dropdown-toggle dropdown-toggle-icon btn-rounded" style="display: block" aria-expanded="false" data-toggle="dropdown" type="button">
                                            <i class="ion-chevron-right" style="margin-bottom: 6px; margin-left: 7px; margin-right: 7px; margin-top: 6px" id="icone" aria-hidden="true"></i> Menu
                                        </button>
                                    </div>
                                </div>
                                <div class="panel-heading">
                                    <h3 class="panel-title">Pesquisar Processo</h3>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="panel-body">
                                            <p class= "form-control-static">Processo ADA/CPR:</p>
                                            <input type="text" class="form-control" name="ADA_pesquisa" id="ADA_pesquisa" required="true">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="panel-body">
                                            <label for="text">
                                                <p class= "form-control-static">N° do Pregão:</p>
                                            </label>
                                            <input type="text" class="form-control" name="num_pregao_pesquisa" id="num_pregao_pesquisa" required="true">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="panel-body">   
                                            <p class= "form-control-static">Ano:</p>
                                            <select class="form-control form-control-md" type="text" name="ano_pesquisa" id="ano_pesquisa" required="true">
                                                <option value="">Selecione um ano</option>
                                            </select>
                                        </div>    
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static">Área de Abrangência:</p>
                                        <select class="form-control" name="abrang_pesquisa" id="abrang_pesquisa" required="true">
                                            <option value="">Selecione uma área</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static">Modalidade:</p>
                                        <select class="form-control" name="modalidade_pesquisa" id="modalidade_pesquisa" required="true">
                                            <option value="">Selecione uma modalidade</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static">Técnico Responsável:</p>
                                        <select class="form-control" name="tec_pesquisa" id="tec_pesquisa" required="true">
                                            <option value="">Selecione um técnico</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static">Tipos de Gasto:</p>
                                        <select class="form-control select" name="tiposDeGasto" id="tiposDeGasto" multiple required="true">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static">Centrais de Atendimento: </p>
                                        <select class="form-control" name="centrais" id="centrais" multiple required="true">

                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static">Situação de Acompanhamento:</p>
                                        <select class="form-control" name="sit_acom_pesquisa" id="sit_acom_pesquisa" title="Selecione uma situação" multiple required="true">

                                        </select>
                                    </div>
                                </div>
                                <div class="panel-body"></div>
                                <div class="form-group">
                                    <div class="col-md-5"></div>
                                    <div class="col-md-2 text-center">
                                        <button class="btn btn-primary btn-pesquisar btn-block btn-rounded" type="button" title="Pesquisar">
                                            <i class="ion-search fa-lg" aria-hidden="true"></i> Pesquisar
                                        </button>
                                    </div>
                                    <div class="col-md-5"></div>

                                </div>
                            </div>
                        </form>
                        <div id="tabela">
                            <div id="page-content">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Lista de Processos</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id="tabela_pesquisa" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-capitalize text-center">ADA/CPR</th>
                                                                <th class="text-capitalize text-center">Tipos De Gastos</th>
                                                                <th class="text-capitalize text-center">Situação</th>
                                                                <th class="text-capitalize text-center">Data Entrega</th>
                                                                <th class="text-capitalize text-center">Modalidade</th>
                                                                <th class="text-capitalize text-center">N° Pregão</th>
                                                                <th class="text-capitalize text-center">Objeto</th>
                                                                <th class="text-capitalize text-center">Centrais de Atendimento</th>
                                                                <th class="text-capitalize text-center">Área de Abrangência</th>
                                                                <th class="text-capitalize text-center">Valor T. Estimado</th>
                                                                <th class="text-capitalize text-center">Valor Homologado</th>
                                                                <th class="text-capitalize text-center">Anexo</th>  
                                                                <th class="text-capitalize text-center">Técnico Responsável</th>
                                                                <th class="text-capitalize text-center">Ação</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body"></div>    
                                        <div class="form-group">
                                            <div class="col-md-5"></div>
                                            <div class="col-md-2 text-center">
                                                <button class="btn btn-info btn-imprimirTodos btn-block btn-rounded" type="button">
                                                    <i class="ion-printer fa-lg" aria-hidden="true"></i> Imprimir
                                                </button>
                                            </div>
                                            <div class="col-md-5"></div>    
                                        </div>
                                    </div>                                           
                                </div>
                                <!--<div id="retorno_pesq"></div>-->
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
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/js/compras/gcon/index.js"></script>
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!-- END JAVASCRIPT -->
    </body>
</html> 