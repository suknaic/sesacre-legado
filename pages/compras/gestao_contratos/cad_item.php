<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/compras/itens/index.load.php";
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
        <!-- themify icons [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/lib/template/plugins/themify-icons/themify-icons.min.css" rel="stylesheet">
        <!--Select2-->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
        <!--Datapicker-->
        <link href="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
        <!--DataTables [ OPT ]-->
        <link href="/assets/lib/template/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
        <!-- <link href="/assets/lib/template/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet"> -->
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.bootstrap.min.css" rel="stylesheet">
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
//Modal Alert
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/modalAlert.html";
            ?>
            <div class="boxed">
                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">
                    <!--Page content-->
                    <!--===================================================-->
                    <!--Modal itens content-->
                    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalItem" data-keyboard="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Busca de Itens</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mar-btm">
                                        <input type="text" id="codItemPesquisa" placeholder="Codigo do Item" class="form-control">
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
                                                            <th>Descrição Item</th>
                                                            <th>Item</th>
                                                            <th>Grupo</th>
                                                            <th>Sub Grupo</th>
                                                            <th>Elem Despesa</th>
                                                            <th>Tipo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--===================================================-->
                    <div id="page-content">
                        <form data-toggle="validator" class="form-horizontal" id="form-documento" role="form" action="#" method="post">
                            <input type="hidden" name="id_alt" id="id_alt" value="<?php echo $id_alt; ?>"/>
                            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Itens</h3>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <div class="panel-body">
                                            Pesquisa itens:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="text" name="itemGrp" id="itemGrp" disabled />
                                                <span class="input-group-btn pesquisaItem" data-target="#modalItem" data-toggle="modal">
                                                    <button type="button" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-bordered-success">
                                    <div class="panel-body">
                                        <input type="hidden" id="codigo" value="" />
                                        <p><strong>Descrição do Item:</strong> <span id="desc-item"> </span></p>
                                        <p><strong>Item:</strong> <span id="item"> </span></p>
                                        <p><strong>Grupo:</strong> <span id="grupo"> </span></p>
                                        <p><strong>Sub Grupo:</strong> <span id="sub-grupo"> </span></p>
                                        <p><strong>Elemento de Despesa:</strong> <span id="despesa"> </span></p>
                                        <p><strong>Tipo de Material:</strong> <span id="tipo"> </span></p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-2">
                                        <div class="panel-body">
                                            Numero:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-file-text-o" style="margin-bottom: -4px"></i></span>
                                                <input class="form-control" type="text" name="itemNumero" id="itemNumero"  required="true" >
                                            </div>
                                        </div>
                                    </div> 

                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Unidade de medida:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                <select class="form-control select" name="unidadeMedida" id="unidadeMedida" required="true">
                                                    <option value="">Selecione uma unidade de medida</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-2">
                                        <div class="panel-body">
                                            Marca:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-file-text-o" style="margin-bottom: -4px"></i></span>
                                                <input class="form-control" type="text" name="marca" id="marca" required="true" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="panel-body">
                                            Modelo:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-file-text-o" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="text" name="modelo" id="modelo" value="NÃO TEM" required="true" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="panel-body">
                                            Lote:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="number" name="lote" id="lote" min="0"  required="true" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="panel-body">
                                            Quantidade:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="text" name="qtd" id="qtd" required="true">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="panel-body">
                                            Valor Unitario:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="text" name="valor_unitario" id="valor_unitario" required="true" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="panel-body">
                                            % de Desconto:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="number" min="0" max="100" name="pc_desconto" id="pc_desconto" value="0" required="true">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-4">
                                        <div class="panel-body">
                                            Descrição do item:<span class="text-danger">*</span>
                                            <textarea class="form-control" rows="4" id="desc_item"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-8"></div>
                                </div>

                                <!-- Footer Form -->
                                <div class="panel-footer text-right">
                                    <button type="button" class="btn btn-default btn-default btn-rounded btn-limpar">
                                        Limpar
                                    </button>
                                    <button type="button" class="btn btn-default btn-info btn-rounded btn-editar" style="display: none;">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar Edição
                                    </button>
                                    <button class="btn btn-success btn-rounded btn-salvar" type="button">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                    </button>
                                </div>
                            </div>
                            <!-- End Form -->
                        </form>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Itens Cadastrados</h3>
                            </div>
                            <div class="panel-body">
                                <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-striped table-bordered" id="tabela">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Nº</th>
                                                        <th class="text-center">Item</th>
                                                        <th class="text-center">Descrição</th>
                                                        <th class="text-center">Grupo</th>
                                                        <th class="text-center">Sub Grupo</th>
                                                        <th class="text-center">Unid</th>
                                                        <th class="text-center">Elemento de Despesa</th>
                                                        <th class="text-center">Tipo</th>
                                                        <th class="text-center">Lote</th>
                                                        <th class="text-center">QTD</th>
                                                        <th class="text-center">Valor unit.</th>
                                                        <th class="text-center">%Desconto</th>
                                                        <th class="text-center">Total</th>
                                                        <th class="text-center" colspan="2">Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-rounded btn-finaliza" type="button">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Finaliza
                                </button>
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
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>
        <!--Datapicker-->
        <script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!--MaskedInput-->
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!--Input valor priceformat-->
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
        <!--Select2-->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!--DataTables [OPT]-->
        <script src="/assets/lib/template/plugins/datatables/media/js/jquery.dataTables.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
        <!-- <script src="/assets/lib/template/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script> -->
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/js/compras/gestao_contratos/cad_item.js"></script>
    </body>
</html>
