<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/financeiro/gdof/documentoFiscal/ver_documento/index.load.php";
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
                        <h1 class="page-header text-overflow">Detalhes do Documento Fiscal</h1> 
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    <ol class="breadcrumb">
                        <li><a href="#">Voltar</a></li>                        
                    </ol>

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <form data-toggle="valisenha123
                              dator" class="form-horizontal" id="form-documento" role="form" action="#" method="post">
                            <div class="panel">
                                <!--Form dos dados do contrato-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body contratos">
                                            <?php echo $finDocumentoFiscal->retornaDadosContrato(null); ?>
                                        </div>
                                    </div>
                                </div>
                                <!--Form dos dados do pedido de necessidade-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body pedido">
                                            <?php echo $finDocumentoFiscal->retornaDadosPedidoNecessidade(null); ?>
                                        </div>
                                    </div>
                                </div>
                                <!--Form dos dados do empenho-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body empenho">
                                            <?php echo $finDocumentoFiscal->retornaDadosEmpenho(null); ?>
                                        </div>
                                    </div>
                                </div>
                                <!--Form das ordens-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body ordem">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                        <h4 class="panel-title">Dados da Ordem</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <!--
                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Tipo de Ordem:</b> <span id="tipoOrdem"></span> </div>
                                                            <div class="col-sm-10"></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Valor da Ordem:</b> <span id="valorOrdem"></span> </div>
                                                            <div class="col-sm-10"></div>
                                                        </div>
                                                        -->

                                                        <div class="form-group">
                                                            <div class="col-sm-5 infoOrdem">
                                                                <table id="tabelaOrdem" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Nº da Ordem</th>
                                                                            <th>Tipo Ordem</th>
                                                                            <th>Valor da Ordem</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php echo $finDocumentoFiscal->retornaTabelaOrdemGdof(null, false); ?>
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
                                <!--Form das entrega-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body ordem">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                        <h4 class="panel-title">Dados da Entrega</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <table id="tabelaEntrega" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center">Nº da Entrega</th>
                                                                            <th class="text-center">Nº da Ordem</th>
                                                                            <th class="text-center">Data do Aviso</th>
                                                                            <th class="text-center">Data Limite para Entrega</th>
                                                                            <th class="text-center">Prazo para Entrega</th>
                                                                            <th class="text-center">Entregue Dia</th>
                                                                            <th class="text-center">Valor Total</th>
                                                                            <th class="text-center">Situação</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php echo $finDocumentoFiscal->retornaTabelaEntregaGdof(null, false); ?>
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
                                        <div class="panel-body ordem">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                        <h4 class="panel-title">Nº do Processo Administrativo da Despesa Pública</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Protocolo Nº:</b></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                                    <input class="form-control" type="text" name="processoAdm" id="processoAdm" 
                                                                           value="<?php echo $documento["nr_processo_administrativo"]; ?>" disabled="true"/>
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
                                <!--form processo administratio da despesa publica-->
                                <div class="form-group">
                                    <div  class="col-sm-12" style="margin-bottom: -4%;">
                                        <div class="panel-body ordem">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                        <h4 class="panel-title">Dados do Documento Fiscal</h4>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Documento Nº:</b></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                                    <input class="form-control" type="text" name="nr_documento" id="nr_documento" 
                                                                           value="<?php echo $documento["nr_documento_fiscal"]; ?>" disabled="true"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-7"></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Tipo de Documento Fiscal:</b></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                                    <select class="form-control select" name="tpDocumento" id="tpDocumento" disabled="true">
                                                                        <?php echo FinTipoDocumento::retornaOptionsTipoDocumento($documento["id_tipo_documento"]); ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-7"></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Competência:</b></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                                    <input class="form-control" type="text" name="competencia" id="competencia" 
                                                                           value="<?php echo $documento["mm_competencia"] . '/' . $documento["aa_competencia"]; ?>" disabled="true"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-7"></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Data de Emissão:</b></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                                                    <input class="form-control" type="text" name="emissao" id="emissao" 
                                                                           value="<?php echo Metodos::ConverteDataBR($documento["dt_emissao"]); ?>" disabled="true"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-7"></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Data de Atesto:</b></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                                                    <input class="form-control" type="text" name="atesto" id="atesto" 
                                                                           value="<?php echo Metodos::ConverteDataBR($documento["dt_atesto"]); ?>" disabled="true"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-7"></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-2"><b>Valor:</b></div>
                                                            <div class="col-sm-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-usd" style="margin-bottom: -4px"></p></span>
                                                                    <input type="text" class="form-control" name="valorDocumentoFiscal" id="valorDocumentoFiscal" 
                                                                           value="<?php echo Metodos::ConverteValorBr($documento["vl_documento"], 4); ?>" disabled="true"/>
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
                                <!--form lançado no grp-->
                                <div class="form-group">
                                    <div  class="col-sm-12" >
                                        <div class="panel-body">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab">
                                                        <h4 class="panel-title">Lançado no GRP</h4>
                                                    </div>

                                                    <?php if ($documento["fl_grp"] == " ") { ?>

                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <div class="col-sm-2">
                                                                    <label><input type="radio" id="grp_sim" value="1" name="grp_cod" disabled="true">Sim</label>
                                                                    <label><input type="radio" id="grp_nao" value="0" name="grp_cod" checked="checked" disabled="true">Não</label>
                                                                </div>

                                                                <div class="col-sm-3 divNumeroGrp hidden">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                                        <input class="form-control" type="text" name="nr_grp" id="nr_grp" 
                                                                               value="<?php echo $documento["nr_grp_numero"]; ?>" disabled="true"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-7"></div>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="panel-body">
                                                            <div class="form-group">
                                                                <div class="col-sm-2">
                                                                    <label><input type="radio" id="grp_sim" value="1" name="grp_cod" checked="checked" disabled="true">Sim</label>
                                                                    <label><input type="radio" id="grp_nao" value="0" name="grp_cod" disabled="true">Não</label>
                                                                </div>

                                                                <div class="col-sm-3 divNumeroGrp">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                                        <input class="form-control" type="text" name="nr_grp" id="nr_grp" 
                                                                               value="<?php echo $documento["nr_grp_numero"]; ?>" disabled="true"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-7"></div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                                                       
                                </div>
                                <!--                                Historico tramitacao-->

                                <div class="form-group">
                                    <div  class="col-sm-12" >
                                        <div class="panel-body">
                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab">
                                                        <h4 class="panel-title">Tramitação</h4>
                                                    </div>

                                                    <div class="panel-body">
                                                        <textarea class="form-control" rows="10"><?php echo $historico; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
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
        <!-- <script src="/pages/financeiro/gdof/unidade/cad_gdof/index.js"></script> -->
    </body>
</html>
