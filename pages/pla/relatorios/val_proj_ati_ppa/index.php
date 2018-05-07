<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/pla/relatorios/val_proj_ati_ppa/index.load.php";
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
                        <h1 class="page-header text-overflow">Relatório de Valores dos Projeto/Atividade do PPA </h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    
                    <ol class="breadcrumb">                        
                        <li><a href="../../index.php">Planejamento</a></li>
                        <li><a href="../index.php">Relatórios</a></li>
                        <li class="active">Projeto/Atividade do PPA</li>
                    </ol>
                    
                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        
                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel">                                    
                                    
                                    <!--Horizontal Form-->
                                    <!--===================================================-->
                                    <form class="form-horizontal formDados">
                                        <div class="panel-body">                                            
                                            <div class="form-group">
                                              
                                              <div class="col-md-12">
                                                    <div class="panel-body">
                                                        <span class="text-main text-semibold">
                                                            Esse Relatório somente irá considerar as PAS Autorizadas pelo Planejamento e os Itens Que foram Validados pela Central de Demanda.
                                                        </span>                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="panel-body">
                                                        <label for="ano">
                                                            Ano:
                                                        </label>                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="ano" class="form-control">
                                                                <option value="0">Selecione um Ano</option>                                                                
                                                                <?php
                                                                    echo Metodos::retornaAnosSelect(date(Y));
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="col-md-4">
                                                    <div class="panel-body">
                                                        <label for="lotacao">
                                                            Unidade/Departamento/Setor:
                                                        </label>                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="lotacao" class="form-control">
                                                                <option value="0">Selecione uma Unidade/Departamento/Setor</option>                                                                
                                                                <?php
                                                                    echo $selectUnidades;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <!-- Pensando em colocar aqui o Projeto e atividade do ppa, dai
                                                listaria os valores por cada unidade desse projeto/atividade do ppa
                                                <div class="col-md-4">
                                                    <div class="panel-body">
                                                        <label for="ano">
                                                            Ano:
                                                        </label>                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="ano" class="form-control">
                                                                <option value="0">Selecione um Ano</option>                                                                
                                                                <?php
                                                                    echo Metodos::retornaAnosSelect(date(Y));
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div> 
                                                -->                                                                                
                                                
                                            </div>
                                            
                                            <!-- End <div class="form-group"> -->                                       
                                        </div>
                                        <!-- <div class="panel-body"> -->
                                        <div class="form-group">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4 text-center">
                                                <button class="btn btn-primary btn-pesquisar btn-rounded" type="button" title="Pesquisar">
                                                    <i class="fa fa-search" aria-hidden="true"></i> Pesquisar
                                                </button>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                    </form>
                                    <!--===================================================-->
                                    <!--End Horizontal Form-->

                                </div>
                            </div>
                        </div>
                        <!-- Fim Form -->                                                                                                                                         
                                           
                         <div class="panel">                           
                            <div class="panel-body">
                                <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="tabela" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Programa do PPA</th>
                                                        <th>Projeto/Atividade do PPA</th>
                                                        <th>Tipo</th>                                                        
                                                        <th class="text-right">Valor</th>                                                           
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                                                                                                                                                                                                                    
                                                </tbody>
                                                <tfoot>
                                                    
                                                </tfoot>                                                
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
        <script src="/assets/js/pla/relatorios/val_proj_ati_ppa/index.js"></script>
           
        <!-- END JAVASCRIPT -->

    </body>
</html>
