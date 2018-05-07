<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/orcamento/liberacaoCentral/index.load";
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
        <!--Select2-->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
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
                        <h1 class="page-header text-overflow">Liberar recurso para central</h1> 
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    <ol class="breadcrumb">
                        <li><a href="/pages/orcamento/liberacaoCentral/index.php">Voltar</a></li>                        
                    </ol>
                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">

                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel">
                                    <div class="panel-heading ">
                                        <h3 class="panel-title">Formulário</h3>
                                    </div>

                                    <!--Horizontal Form-->
                                    <!--===================================================-->
                                    <form class="form-horizontal formDados">
                                        <div class="panel-body">

                                            <div class="form-group">                                              
                                                <div class="col-sm-4">
                                                    <div class="panel-body">
                                                        Ano:<span class="text-danger">*</span>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                            <select class="form-control select" name="ano" id="ano" required="true">
                                                                <option value="" >Selecione uma ano</option>
                                                                <?php echo Metodos::retornaAnosSelect('0'); ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="panel-body">
                                                        <label for="fonte">
                                                            Projeto/Atividade: <span class="text-danger">*</span>
                                                        </label>                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="projeto" class="form-control select">
                                                                <option value="0">Selecione uma projeto/atividade</option>                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <div class="panel-body">
                                                        <label for="valor">
                                                            Central: <span class="text-danger">*</span>
                                                        </label>                                                                
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><p class="fa fa-usd inputPFa"></p></span>
                                                            <select id="central" class="form-control select">
                                                                <option value="0">Selecione uma central</option>                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="panel-body">
                                                        <label for="ano">
                                                            Tipo de gasto: <span class="text-danger">*</span>
                                                        </label>                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="tipoDeGasto" class="form-control select">
                                                                <option value="0">Selecione um tipo de gasto</option>                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">

                                                <div class="col-md-6">
                                                    <div class="panel-body">
                                                        <label for="ano">
                                                            Elemento: <span class="text-danger">*</span>
                                                        </label>                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="despesa" class="form-control select">
                                                                <option value="0">Selecione um Elemento</option>                                                                
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="panel-body">
                                                        Observação:<span class="text-danger">*</span>
                                                        <textarea class="form-control" rows="4" id="obs_liberacao"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End <div class="form-group"> -->
                                        </div>


                                    </form>
                                    <!--===================================================-->
                                    <!--End Horizontal Form-->

                                </div>
                            </div>
                        </div>
                        <!-- Fim Form -->
                        <div class="panel">
                            <div class="panel-heading">
                                <h4 class="panel-title">Adicione os Registros a Serem <span id="spanSegundo">Liberado</span></h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-3">                                            
                                    <label for="fonte">
                                        Fonte: <span class="text-danger">*</span>
                                    </label>                                                        
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <p class="fa fa-list inputPFa"></p>
                                        </span>
                                        <select id="fonte" class="form-control">                                                                                                                    

                                        </select>
                                    </div>                                            
                                </div>                                        

                                <div class="col-md-3">                                                    
                                    <label for="valorTipo">
                                        Valor: <span class="text-danger">*</span>
                                    </label>                                                                
                                    <div class="input-group">
                                        <span class="input-group-addon"><p class="fa fa-dollar inputPFa"></p></span>
                                        <input class="form-control valor" type="text" name="valor" id="valor" required>
                                    </div>                                                   
                                </div> 
                                <div class="col-md-3">                                                    
                                    <label for="">                                                   
                                    </label>                                                                
                                    <div class="input-group">
                                        <button class="btn btn-primary btn-rounded btn-add" type="button">
                                            <i class="fa fa-plus fa-lg" aria-hidden="true"></i> Adicionar
                                        </button>
                                    </div>                                                   
                                </div> 
                                <div class="col-md-12">
                                    <div class="panel-body" >                                
                                        <div class="form-group">
                                            <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table id="registros" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>                                                        
                                                                    <th class="text-center">Central</th>
                                                                    <th class="text-center">Projeto/Atividade</th>                                                        
                                                                    <th class="text-center">Tipo de gasto</th>
                                                                    <th class="text-center">Elemento</th>
                                                                    <th class="text-center">Fonte</th>
                                                                    <th class="text-center">Valor</th>
                                                                    <th class="text-center">Observação</th>
                                                                    <th class="text-center">Ações</th> 
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
                            <!-- Footer Form -->
                            <div class="panel-footer text-right">
                                <button type="button" class="btn btn-default btn-default btn-rounded btn-limpar">
                                    Limpar
                                </button>                                  
                                <button type="button" class="btn btn-default btn-info btn-rounded btn-editar" style="display: none;">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar Edição
                                </button>
                                <button class="btn btn-success btn-rounded btn-salvar" id="btn-salvar" type="button" value="0">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> <span id="txtBtn">Salvar</span>
                                </button>
                            </div>
                            <!-- End Form -->
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
        <!--Input valor priceformat-->
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
        <!--Select2-->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/js/orcamento/liberacaoCentral/cad_liberacao.js"></script>

        <!-- END JAVASCRIPT -->

    </body>
</html>
