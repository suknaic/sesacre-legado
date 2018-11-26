<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/financeiro/ordem/index.load.php";
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
                        <h1 class="page-header text-overflow">Nova Ordem</h1> 
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    <ol class="breadcrumb">
                        <li><a href="/pages/financeiro/ordem/index.php">Voltar</a></li>                        
                    </ol>
                    <!--Modal itens content-->
                    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalItem" data-keyboard="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Busca de Pedido</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mar-btm">
                                        <input type="text" id="codItemPesquisa" placeholder="Número do pedido" class="form-control">
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
                                                            <th>Pedido</th>
                                                            <th>Descrição</th>
                                                            <th>Tipo de gasto</th>
                                                            <th>Fonte</th>
                                                            <th>Despesa</th>
                                                            <th>Valor</th>
                                                            <th>Ata</th>
                                                            <th>Contrato</th>
                                                            <th>Modalidade</th>
                                                            <th>Projeto/Atividade</th>
                                                            <th>Empenho</th>
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
                        <form data-toggle="validator" class="form-horizontal" id="form-documento" role="form" action="#" method="post">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Informações da ordem</h3>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Pesquisa Pedido:<span class="text-danger">*</span>
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
                                        <input type="hidden" id="id_pedido" value="" />
                                        <p><strong>Pedido:</strong> <span id="pedido"> </span></p>
                                        <p><strong>Descrição:</strong> <span id="desc_pedido"> </span></p>
                                        <p><strong>Tipo de gasto:</strong> <span id="tipo_gasto"> </span></p>
                                        <p><strong>Fonte:</strong> <span id="fonte"> </span></p>
                                        <p><strong>Elemento Despesa:</strong> <span id="despesa"> </span></p>
                                        <p><strong>Valor:</strong> <span id="valor"> </span></p>
                                        <p><strong>Ata:</strong> <span id="ata"> </span></p>
                                        <p><strong>Contrato:</strong> <span id="contrato"> </span></p>
                                        <p><strong>Modalidade:</strong> <span id="modalidade"> </span></p>
                                        <p><strong>Projeto/Atividade:</strong> <span id="projeto"> </span></p>
                                        <p><strong>Empenho:</strong> <span id="empenho"> </span></p>
                                    </div>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="panel-body">
                                                <label for="tipoOrdem">
                                                    Tipo ordem: <span class="text-danger">*</span>
                                                </label>                                                        
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-list inputPFa"></p>
                                                    </span>
                                                    <select id="tipoOrdem" class="form-control">    
                                                        <option value="0">Selecione um tipo</option>
                                                        <option value="1">Entrega</option>
                                                        <option value="2">Execução/Serviço</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 hidden divPrazo">
                                            <div class="panel-body">
                                                <label for="prazo">
                                                    Prazo de entrega: <span class="text-danger">*</span>
                                                </label>                                                        
                                                <div class="input-group">
                                                    <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                    <input class="form-control" type="text" name="prazo" id="prazo" required="true" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 pergunta hidden">
                                            <div class="panel-body">
                                                <label for="prazo">
                                                   Essa ordem é de Produto ?<span class="text-danger">*</span>
                                                </label>                                                        
                                                <div class="radio">
                                                    <label><input type="radio" name="optradio" id="radioSim" value="1">Sim</label>
                                                    <label><input type="radio" name="optradio" id="radioNao"value="2" checked="true">Não</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6" >
                                            <div class="panel-body">
                                                <label for="id_lotacao">
                                                    Local de entrega ou Execução/Serviço: <span class="text-danger">*</span>
                                                </label>                                                        
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-list inputPFa"></p>
                                                    </span>
                                                    <select id="id_lotacao" class="form-control">    
                                                        <option value="0">Selecione uma Lotação</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="periodoConsumo hidden">
                                            <div class="col-md-3" >
                                                <div class="panel-body">
                                                    <label for="id_lotacao">
                                                        Data estimada de consumo inicial: <span class="text-danger">*</span>
                                                    </label>                                                        
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                        <input class="form-control data" type="text" name="vig_inicial" id="vig_inicial" required="true" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3" >
                                                <div class="panel-body">
                                                    <label for="id_lotacao">
                                                        Data estimada de consumo final: <span class="text-danger">*</span>
                                                    </label>                                                        
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                        <input class="form-control data" type="text" name="vig_final" id="vig_final" required="true" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                                                                <th class="text-center">Valor unit</th>
                                                                <th class="text-center">Total</th>
                                                                <th class="text-center">Utilizado</th>
                                                                <th class="text-center">Saldo</th>
                                                                <th class="text-center"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-success btn-salvar btn-rounded btn-finaliza" type="button">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                        </button>
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
        <script src="index.js"></script>
    </body>
</html>
