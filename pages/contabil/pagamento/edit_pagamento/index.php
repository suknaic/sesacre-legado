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
                        <h1 class="page-header text-overflow">Edição do Pagamento</h1> 
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="/pages/contabil/pagamento/pesquisa_pagamento/index.php">Voltar</a></li>                        
                    </ol>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <!--Modal addAnotacao-->
                        <div class=" modal fade modal-footer" id="adAnotacao"
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
                                        <h4 class="modal-title">Anotação</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="GET" enctype="multipart/form-data" id="form-anotacao" name="form-anotacao">
                                            <input type="hidden" name="id_pedido_anotacao" id="id_processo_anotacao" value="">
                                            <textarea class="form-control" rows="5" name="anotacao" id="anotacao"></textarea>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default fechar" data-dismiss="modal">Fechar</button>
                                        <input type="submit" class="btn btn-primary btn-enviarAnotacao" value="Adicionar">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Fim Modal AddAnotacao-->
                        <form class="form-horizontal" id="form-documento" role="form">
                            <input type="hidden" name="id_pagamento" id="id_pagamento" value="<?php echo $id; ?>"/>
                            <input type="hidden" name="id_liquidacao" id="id_liquidacao" value="<?php echo $dadosPagamento["id_liquidacao"]; ?>"/>
                            <div class="panel">                                

                                <!--Form dos dados do contrato-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body contratos">
                                            <?php echo $dadosContrato; ?>
                                        </div>
                                    </div>
                                </div>
                                <!--Form dos dados do pedido de necessidade-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body pedido">
                                            <?php echo $dadosPedido; ?>
                                        </div>
                                    </div>
                                </div>
                                <!--Form dos dados do empenho-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body empenho">
                                            <?php echo $dadosEmpenho; ?>
                                        </div>
                                    </div>
                                </div>
                                <!--Form dos dados da liquidacao-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body dadosLiquidacao">
                                            <?php echo $dadosLiquidacao; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($dadosPagamento["id_tipo_solicitacao"] == 2) { ?>
                                    <!--Form das documentos-->
                                    <div class="form-group">
                                        <div  class="col-sm-12" style="margin-bottom: -4%;">
                                            <div class="panel-body docFis">
                                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                    <div class="panel panel-default">
                                                        <div class="panel-heading" role="tab" id="headingTwo">
                                                            <h4 class="panel-title">Dados do Documento Fiscal</h4>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <div class="col-sm-2"><b>Nº do Documento Fiscal:</b><span class="text-danger">*</span></div>
                                                                <div class="col-sm-3">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                                        <select class="form-control select" name="selectDocumentoFiscal" id="selectDocumentoFiscal">
                                                                            <option value="0" selected="true">Selecione um Documento Fiscal</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-1"><a class="addDocumento btn btn-info">+</a></div>
                                                                <div class="col-sm-6"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <table id="tabelaDocumentos" class="table table-striped table-bordered tabelaDocumentos" cellspacing="0" width="100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-center">Nº Documento Fiscal</th>
                                                                                <th class="text-center">Tipo Documento Fiscal</th>
                                                                                <th class="text-center">Competência</th>
                                                                                <th class="text-center">Data Emissão</th>
                                                                                <th class="text-center">Data Atesto</th>
                                                                                <th class="text-center">Valor Total</th>
                                                                                <th class="text-center">Saldo</th>
                                                                                <th class="text-center">Valor do Pagamento</th>
                                                                                <th class="text-center">Situação</th>
                                                                                <th class="text-center">Ação</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php echo $tabelaDocumentosFiscais; ?>
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
                                <?php } ?>
                                <!--form processo administratio da despesa publica-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body liquidacao">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                        <h4 class="panel-title">Dados do Pagamento</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Nº do Pagamento:</b><span class="text-danger">*</span></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                                    <input class="form-control" type="text" name="nr_pagamento" id="nr_pagamento" value="<?php echo $dadosPagamento["nr_pagamento"]; ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-7"></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Data do Pagamento:</b><span class="text-danger">*</span></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                                                    <input class="form-control" type="text" name="dt_pagamento" id="dt_pagamento" value="<?php echo $dadosPagamento["dt_pagamento"]; ?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-7"></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Valor Total:</b><span class="text-danger">*</span></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-usd" style="margin-bottom: -4px"></p></span>
                                                                    <?php if ($dadosPagamento["id_tipo_solicitacao"] == 2) { ?>
                                                                        <input type="text" class="form-control" name="vl_pagamento" id="vl_pagamento" value="<?php echo $dadosPagamento["vl_pagamento"]; ?>" disabled="true"/>
                                                                    <?php } else { ?>
                                                                        <input type="text" class="form-control" name="vl_pagamento" id="vl_pagamento" value="<?php echo $dadosPagamento["vl_pagamento"]; ?>"/>
                                                                    <?php } ?>
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

                                <!-- CAMPO DO REMETENTE -->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body remetente">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                        <h4 class="panel-title">Remetente</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-sm-2"><b>Tipo de Remetente/Remetente:</b><span class="text-danger">*</span></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                                    <select class="form-control select" name="id_remetente" id="id_remetente">
                                                                        <?php echo $selectRemetente; ?>
                                                                    </select>
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
                                <!-- FIM CAMPO REMETENTE-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab">
                                                        <h4 class="panel-title">Anotações
                                                            <button  type="button" class="btn btn-primary btn-rounded btn-addAnotacao" title="Adicionar">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            </button>
                                                        </h4>
                                                    </div>

                                                    <div class="panel-body">
                                                        <textarea class="form-control anotacoes" rows="7" readonly id="anotacoes"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                        <h4 class="panel-title">Histórico</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <textarea class="form-control" rows="7" readonly="true"><?php echo $historico; ?></textarea>
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
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>        

        <!--Select2-->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>

        <!--DataTables [OPT]-->
        <script src="/assets/lib/template/plugins/datatables/media/js/jquery.dataTables.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/pages/contabil/pagamento/edit_pagamento/index.js"></script>
    </body>
</html>
