<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/financeiro/ordem/entrega/cadEntrega.load.php";
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
                                        <input type="hidden" name="id_processo_anotacao" id="id_processo_anotacao" value="<?php echo $protocolo["id_protocolo"]; ?>">
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
                    <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Nova Entrega</h1> 
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    <ol class="breadcrumb">
                        <li><a href="/pages/financeiro/ordem/entrega/index.php?id=<?php echo $ordem; ?>">Voltar</a></li>                        
                    </ol>
                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <form data-toggle="validator" class="form-horizontal" id="form-documento" role="form" action="#" method="post">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Informações da ordem</h3>
                                </div>

                                <div class="panel panel-bordered-success">
                                    <div class="panel-body">
                                        <input type="hidden" id="id_protocolo" value="<?php echo $id; ?>" />
                                        <input type="hidden" id="idOrdem" value="<?php echo $ordem; ?>" />
                                        <p><strong>Pedido:</strong> <?php echo $dados["nr_pedido"]; ?></p>
                                        <p><strong>Descrição:</strong> <?php echo $dados["ds_pedido"]; ?></p>
                                        <?php
                                        if ($dados["tp_contrato"] == 1) {
                                            ?>
                                            <p><strong>ATA:</strong> <?php echo $dados["nr_contrato"]; ?></p>
                                        <?php } else { ?>
                                            <p><strong>Contrato:</strong> <?php echo $dados["nr_contrato"]; ?></p>
                                        <?php } ?>
                                        <p><strong>Empenho:</strong> <?php echo $dados["nr_empenho"]; ?></p>
                                        <p><strong>Ordem:</strong> <?php echo $dados["nr_ordem"]; ?></p>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Dados para Entrega</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <table class="table table-striped table-bordered" id="tabela01">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">Nº</th>
                                                                <th class="text-center">Item</th>
                                                                <th class="text-center">Descrição</th>
                                                                <th class="text-center">Elemento de Despesa</th>
                                                                <th class="text-center">Tipo</th>
                                                                <th class="text-center">Lote</th>
                                                                <th class="text-center">QTD</th>
                                                                <th class="text-center">Valor unit</th>
                                                                <th class="text-center">Entregue</th>
                                                                <th class="text-center">Aguardando Entrega</th>
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

                                <?php if ($situacao["sit_ordem"] > '1' && $situacao["sit_ordem"] < '3') { ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Itens para Entrega</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label for="tipoOrdem">
                                                        Tipo da entrega: <span class="text-danger">*</span>
                                                    </label>                                                        
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="tipoEntrega" class="form-control">    
                                                            <option value="0">Selecione um tipo</option>
                                                            <option value="1">Parcial</option>
                                                            <option value="2">Total</option>
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="col-sm-3">
                                                    Data de entrega:<span class="text-danger">*</span>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                                        <input class="form-control data" type="text" name="data_entrega" id="data_entrega" required="true" />
                                                    </div>

                                                </div>

                                            </div>
                                            <br/>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                        <table class="table table-striped table-bordered" id="tabela">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center">Nº</th>
                                                                    <th class="text-center">Item</th>
                                                                    <th class="text-center">Descrição</th>
                                                                    <th class="text-center">Elemento de Despesa</th>
                                                                    <th class="text-center">Tipo</th>
                                                                    <th class="text-center">Lote</th>
                                                                    <th class="text-center">QTD</th>
                                                                    <th class="text-center">Valor unit</th>
                                                                    <th class="text-center">Entregue</th>
                                                                    <th class="text-center">Aguardando Entrega</th>
                                                                    <th class="text-center">Ação</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <br/>
                                            <button class="btn btn-success btn-salvar btn-rounded" type="button">
                                                <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                            </button>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="panel ">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Situação da Entrega</h3>
                                    </div>
                                    <?php echo $finEntregaConfirmacaoModel->retornaSituacaoEntrega(); ?>
                                </div>

                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Anotações
                                            <button  type="button" class="btn btn-primary btn-rounded btn-addAnotacao" title="Adicionar">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </h3>
                                    </div>
                                    <div class="input_ordens">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="panel-body">
                                                    <textarea class="form-control" rows="6" readonly name="anotacoes" id="anotacoes"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($situacao["sit_ordem"] > '1' && $situacao["sit_ordem"] < '3' && $classOrdem->retornaSePodeFinalizarAEntrega()) { ?>
                                    <div class="panel ">
                                        <div class="panel-body">
                                            <div class="row">

                                                <div class="col-md-3" style="display:inline-block;">
                                                    <button class="btn btn-danger btn-rounded btn-finaliza-supresao" type="button">
                                                        <i class="fa fa-ban" aria-hidden="true"></i> Finalizar por Supressão do Ordenado
                                                    </button>
                                                    <button type="button" class="btn btn-info btn-rounded" id="pop-finaliza-supresao" data-container="body" 
                                                            data-toggle="popover" data-placement="top" 
                                                            data-content="Quando o quantitativo requisitado for inferior ao total ordenado para o período, conforme necessidade 
                                                            e interesse da administração.">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                    </button>

                                                </div>


                                                <div class="col-md-4" style="display:inline-block;">
                                                    <button class="btn btn-danger btn-rounded btn-finaliza-descumprimento" type="button">
                                                        <i class="fa fa-ban" aria-hidden="true"></i> Finalizar por Descumprimento da Contratada
                                                    </button>
                                                    <button type="button" class="btn btn-info btn-rounded" id="pop-finaliza-supresao" data-container="body" 
                                                            data-toggle="popover" data-placement="top" 
                                                            data-content="Quando não ocorrer a entrega ou execução/serviço total do objeto ordenado por parte da contratada, conforme necessidade 
                                                            da administração.">
                                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
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
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>
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
        <script src="/assets/js/financeiro/ordem/entrega/cadEntrega.js"></script>
    </body>
</html>
