<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/pla/pta/itens.load.php";
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
                        <h1 class="page-header text-overflow">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <p class="fa fa-list inputPFa"></p>
                                </span>
                                <select class="form-control" id="select-tipo-gasto">
                                    <?php echo $optionTipoGasto; ?>
                                </select>
                            </div>
                        </h1>
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <ol class="breadcrumb">
                        <li><a href="/pages/pla/pas/pas_info.php?token=<?php echo $ptaTitulo->getIdpas(); ?>">PAS</a></li>
                        <li><a href="/pages/pla/pta/index.php?token=<?php echo $ptaTitulo->getIdPas(); ?>">PTA</a></li>
                        <li><a href="/pages/pla/pta/pta_titulo_info.php?token=<?php echo $ptaTitulo->getIdPtaTitulo(); ?>">PTA Título</a></li>
                        <li><a href="/pages/pla/pta/mem_calculo.php?token=<?php echo $ptaTitulo->getIdPtaTitulo(); ?>">Memória de Cálculo</a></li>
                        <li class="active"><?php echo $nomeTipoGasto; ?></li>
                    </ol>

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">


                        <div id="menu_pta">
                            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/pla/pta/menuPta.php";  ?>
                        </div>

                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel ">
                                    <div class="panel-heading">
                                        <div class="panel-control">
                                            <!--Nav tabs-->
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#form-1" aria-expanded="true">Formulário</a></li>
                                                <li class=""><a data-toggle="tab" id="informacoes" href="#info-2" aria-expanded="false">Informações</a></li>
                                                <li class=""><a data-toggle="tab" href="#info-3" aria-expanded="false">Detalhamento da Ação</a></li>
                                            </ul>
                                        </div>
                                        <h3 class="panel-title">Dados</h3>
                                    </div>

                                    <!--Horizontal Form-->
                                    <!--===================================================-->
                                    <form class="form-horizontal form">
                                        <input type="hidden" name="pta_titulo" id="pta_titulo" value="<?php echo $ptaTitulo->getIdPtaTitulo(); ?>" />
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div id="form-1" class="tab-pane fade active in">
                                                    <div class="form-group form-group-mg-bot">
                                                                                                               
                                                        <div class="col-md-6">
                                                            <div class="panel-body">
                                                                <label for="det_acao">
                                                                    Detalhamento da Ação: <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="det_acao" class="form-control">
                                                                        <option value="0">Selecione um Detalhemento da Ação</option>
                                                                        <?php echo $opDetalhamentoAcao; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-md-6">
                                                            <div class="panel-body">
                                                                <label for="item" style="margin-bottom: 0px;">
                                                                    Item: <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="input-group mar-btm">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="item" id="item" class="form-control" placeholder="Pesquisar Item" readonly="true" disabled="true" >
                                                                    <span class="input-group-btn pesquisaItem" data-target="#modalItem" data-toggle="modal">
                                                                        <button type="button" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                                    </span>                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="panel panel-bordered-success">

                                                        <div class="panel-body">
                                                            <input type="hidden" id="pan-codigo" value="" />
                                                            <p><strong>Descrição do Item:</strong> <span id="pan-desc-item"> </span></p>
                                                            <p><strong>Código da Descrição do Item:</strong> <span id="pan-descricao-codigo"> </span> <strong>Item:</strong> <span id="pan-item"> </span> </p>
                                                            <p><strong>Grupo:</strong> <span id="pan-grupo"> </span></p>
                                                            <p><strong>Sub Grupo:</strong> <span id="pan-sub-grupo"> </span></p>
                                                            <p><strong>Elemento de Despesa:</strong> <span id="pan-despesa"> </span></p>
                                                            <p><strong>Tipo de Material:</strong> <span id="pan-tipo"> </span></p>
                                                        </div>
                                                    </div>



                                                    <div class="form-group" style="margin-bottom: 0px;">

                                                        <div class="col-md-3">
                                                            <div class="panel-body">
                                                                <label for="unid_medida">
                                                                    Unidade de Medida: <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="unid_medida" class="form-control">
                                                                        <option value="0">Selecione a Unidade Medida</option>
                                                                        <?php echo $selectUnidMed; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        

                                                        <div class="col-md-2">
                                                            <div class="panel-body">
                                                                <label for="quantidade">
                                                                    Quantidade: <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                                    </span>
                                                                     <input type="text" class="form-control" name="quantidade" id="quantidade" style="text-align: right;" required="true">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        

                                                        <div class="col-md-2">
                                                            <div class="panel-body">
                                                                <label for="valor">
                                                                    Valor Unitário: <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><p class="fa fa-usd inputPFa"></p></span>
                                                                    <input class="form-control" type="text" name="valor" style="text-align: right;"
                                                                           id="valor" required>
                                                                </div>
                                                            </div>
                                                        </div>                                                                                                                                                                         
                                                        
                                                        <div class="col-md-3">
                                                            <div class="panel-body">
                                                                <label for="total">
                                                                    Total:
                                                                </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-usd inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" style="text-align: right;" 
                                                                           name="total" id="total" disabled="true" readonly="true">
                                                                </div>
                                                            </div>
                                                        </div>                                                                                                                                                                         
                                                    </div>
                                                    
                                                    <div class="form-group" style="margin-bottom: 0px;">                                                        
                                                        <div class="col-md-4">
                                                            <div class="panel-body">
                                                                <label for="tipo_gasto_categoria">
                                                                    Tipo Gasto Categoria: <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="tipo_gasto_categoria" class="form-control">
                                                                        <option value="0">Selecione uma Categoria</option>
                                                                        <?php echo $selectTipoGastoCategoria; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-5 infoCentral" style="display: none;">
                                                            <div class="panel-body">
                                                                <label for="central">
                                                                    Central de Demanda:
                                                                </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" 
                                                                           name="central" id="central" disabled="true" readonly="true">
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        
                                                    </div>
                                                    
                                                    <div class="form-group">                                                        
                                                        <div class="col-md-4">
                                                            <div class="panel-body">
                                                                <label for="fonte">
                                                                    Fonte: <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="fonte" class="form-control">
                                                                        <option value="0">Selecione uma Fonte</option>
                                                                        <?php echo $selectFonte; ?>
                                                                    </select>
                                                                    <span class="input-group-btn pesquisaSaldoFonte" title="Pesquisar Saldo da Fonte">
                                                                        <button type="button" class="btn btn-warning">
                                                                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4">
                                                            <div class="panel-body">
                                                                <label for="tp_fonte">
                                                                    Tipo da Fonte:
                                                                </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="tp_fonte" class="form-control">                                                                        
                                                                        <?php echo Metodos::retornaTpFonteSelect(); ?>
                                                                    </select>                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                                                                               

                                                        <div class="col-md-4 selectPortConv">
                                                            <!--
                                                            <div class="panel-body">
                                                                <label for="port">
                                                                    Portaria/Convênio:
                                                                </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="port" class="form-control">
                                                                        <option value="0">Selecione uma Portaria/Convênio</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            -->
                                                        </div>

                                                    </div>


                                                    <div class="form-group">
                                                        <div class="col-md-9">
                                                            <div class="panel-body">
                                                                <label for="descricao">
                                                                    Descrição:
                                                                </label>
                                                                <textarea class="form-control" rows="4" name="descricao" id="descricao" required="true"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="modal fade"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="mySmallModalLabel"
                                                        id="modalItem"
                                                        data-keyboard="false">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal"
                                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    <h4 class="modal-title">Busca de Itens</h4>
                                                                    <div class="input-group">
                                                                        <div class="radio-inline">
                                                                            <label role="button">
                                                                                <input type="radio" name="optradio" value="D" checked="">Descrição do Item
                                                                            </label>
                                                                        </div>
                                                                        <div class="radio-inline">
                                                                            <label role="button">
                                                                                <input type="radio" name="optradio" value="C">Código do Item
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                <div class="modal-body">

                                                                    <div class="input-group mar-btm">
                                                                        <input type="text" id="nomeItemPesquisa" placeholder="Digite Aqui" class="form-control">
                                                                        <span class="input-group-btn">
                                                                            <button class="btn btn-primary" type="button" id="btn-pesquisa">
                                                                                <i class="fa fa-search" aria-hidden="true"></i> Pesquisar
                                                                            </button>
                                                                        </span>
                                                                    </div>


                                                                    <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                                        <div class="row">
                                                                            <!-- style="overflow:auto;" -->
                                                                            <div class="col-sm-12">
                                                                                
                                                                                    <table id="tabelaItens" class="table table-striped table-bordered" cellspacing="0" width="100%" >
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
                                                    
                                                    <div class="modal fade"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="mySmallModalLabel"
                                                        id="modalInformacoes"
                                                        data-keyboard="false">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal"
                                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    <h4 class="modal-title">Informações do Item</h4>                                                                                                                                        
                                                                </div>
                                                                <div class="modal-body">
                                                                                                                                     

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="modal fade"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="mySmallModalLabel"
                                                        id="modalValoresLimite"
                                                        data-keyboard="false">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal"
                                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    <h4 class="modal-title">Liberação pelo Planejamento Dos Valores</h4>                                                                                                                                        
                                                                </div>
                                                                <div class="modal-body">
                                                                                                                                     

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- End <div class="form-group"> -->
                                                </div>
                                                <div id="info-2" class="tab-pane fade">
                                                    <p class="text-main text-lg mar-no"></p>
                                                    <span></span>
                                                </div>

                                                <div id="info-3" class="tab-pane fade">
                                                    <p class="info_det_acao">Informações do Detalhamento da Ação</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="panel-body"> -->


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
                                        <!-- End Form -->
                                    </form>
                                    <!--===================================================-->
                                    <!--End Horizontal Form-->

                                </div>
                            </div>
                        </div>
                       <!-- Fim Form -->

                        <!--
                        <div class="panel">
                            <div class="panel-body">
                        -->
                               
                                <div class="tabelasItens">   


                                </div>
                        <!--         
                            </div>
                        </div>
                        -->
                         

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
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/dataTables.buttons.min.js"></script>           
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/jszip.min.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/pdfmake.min.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/vfs_fonts.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/buttons.html5.min.js"></script>   
        <script src="/assets/lib/template/plugins/datatables/extensions/buttons/js/buttons.print.min.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
        
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <!--MaskedInput-->
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!--Input valor priceformat-->
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>


        <script src="/assets/js/pla/pta/itens.js"></script>

        <!-- END JAVASCRIPT -->

    </body>
</html>
