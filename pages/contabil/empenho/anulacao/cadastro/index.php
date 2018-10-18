<!DOCTYPE html>
<?php
require_once "index.load.php";
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
        <link rel="stylesheet" href="/assets/lib/template/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!--Select2-->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
        <!-- themify icons [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/lib/template/plugins/themify-icons/themify-icons.min.css" rel="stylesheet">        
        <!--DataTables [ OPT ]-->
        <link href="/assets/lib/template/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.bootstrap.min.css" rel="stylesheet">
        <!--Datapicker-->
        <link href="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css" rel="stylesheet">
    </head>
    <!--TIPS-->
    <!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-sm">
            <?php
            //Cabeçalho do Sistema
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php";
            ?>
            <?php
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
                        <h1 class="page-header text-overflow">Cadastro da Anulação do Empenho</h1> 
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="/pages/contabil/empenho/anulacao/pesquisa/">Voltar</a></li>                        
                    </ol>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--Modal itens content-->
                    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalItem" data-keyboard="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Busca de empenho</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mar-btm">
                                        <input type="text" id="codItemPesquisa" placeholder="Número do empenho" class="form-control">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" id="btn-pesquisa">
                                                <i class="fa fa-search" aria-hidden="true"></i> Pesquisar
                                            </button>
                                        </span>
                                    </div>

                                    <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table id="tabelaItens" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Nº Empenho</th>
                                                            <th>Tipo de Empenho</th>
                                                            <th>Fonte</th>
                                                            <th>Elemento de Despesa</th>                                                            
                                                            <th>Valor Total</th>
                                                            <th>Saldo a Liquidar</th>
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
                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <form class="form-horizontal" id="form-documento" role="form">
                            <input type="hidden" value="<?php echo $empenho; ?>" id="empenho_get" />
                            <div class="panel">                                
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Pesquisa Empenho:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="text" name="item" id="item" disabled />
                                                <span class="input-group-btn pesquisaItem" data-target="#modalItem" data-toggle="modal">
                                                    <button type="button" class="btn btn-primary" ><i class="fa fa-search" aria-hidden="true"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Form dos dados do contrato-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body contratos">

                                        </div>
                                    </div>
                                </div>
                                <!--Form dos dados do pedido de necessidade-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body pedido">

                                        </div>
                                    </div>
                                </div>
                                <!--Form dos dados do empenho-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body empenho">

                                        </div>
                                    </div>
                                </div>

                                <!--Form das entrega-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body">
                                            <div class="panel-group" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                        <h4 class="panel-title">Itens do Pedido Para Anulação</h4>
                                                    </div>
                                                    <div class="panel-body">                                                        
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <table id="tabelaItensPedido" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center">Nº</th>
                                                                            <th class="text-center">Item</th>
                                                                            <th class="text-center">Descrição</th>
                                                                            <th class="text-center">Grupo</th>
                                                                            <th class="text-center">Sub Grupo</th>
                                                                            <th class="text-center">Unid</th>
                                                                            <th class="text-center">Despesa</th>
                                                                            <th class="text-center">Tipo</th>
                                                                            <th class="text-center">Lote</th>
                                                                            <th class="text-center">QTD</th>
                                                                            <th class="text-center">Valor Unit</th>
                                                                            <th class="text-center">Total</th>
                                                                            <th class="text-center">Utilizado</th>
                                                                            <th class="text-center">Saldo</th>
                                                                            <th class="text-center">Valores Para Anulação</th>
                                                                            <th class="text-center">Valor Total</th>
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
                                </div>
                                <!--form processo administratio da despesa publica-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body liquidacao">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                        <h4 class="panel-title">Dados da Anulação</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Nº da Anulação:</b> <span class="text-danger">*</span></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                                    <input class="form-control" type="text" name="nr_anulacao" id="nr_anulacao" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-7"></div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Data da Anulação:</b> <span class="text-danger">*</span></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                                                    <input class="form-control" type="text" name="dt_anulacao" id="dt_anulacao" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-7"></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Valor Total:</b> <span class="text-danger">*</span></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-usd" style="margin-bottom: -4px"></p></span>
                                                                    <input type="text" class="form-control" name="vl_anulacao" id="vl_anulacao" readonly="true" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-7"></div>
                                                        </div>                                                       

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                               
                               
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;" >
                                        <div class="panel-body">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab">
                                                        <h4 class="panel-title">Anotações</h4>
                                                    </div>

                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <textarea class="form-control" rows="7" id="anotacoes"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div  class="col-sm-12">
                                        <div class="panel-body">
                                            <button class="btn btn-success btn-salvar btn-rounded btn-finaliza" type="button">
                                                <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
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
        <!--NiftyJS [ RECOMMENDED ]-->
        <script src="/assets/lib/template/js/nifty.min.js"></script>
        <!--Datapicker-->
        <script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!--MaskedInput-->
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!--Input valor priceformat-->
        <script src="/assets/lib/jquerypriceformat/jquery.priceformat.min.js"></script>       
        
        <!--Select2-->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        
        <!--DataTables [OPT]-->
        <script src="/assets/lib/template/plugins/datatables/media/js/jquery.dataTables.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="index.js"></script>
    </body>
</html>
