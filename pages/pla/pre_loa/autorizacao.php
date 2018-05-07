<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/pla/pre_loa/autorizacao.load.php";
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

            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; 
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
                        <h1 class="page-header text-overflow">Autorização da Prévia-LOA</h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content"> 
                        <ul class="nav nav-tabs nav-justified botaoDocumentoAcoes">
                            <li>
                                <a href="#" id="abrirModalAno">Visualizar as Prévia-LOAs</a>
                            </li>                                    
                        </ul>
                        <div class="panel"> 
                            <div class="panel-body">                                
                                <div class="form-group">
                                    <input type="hidden" id="ano" value="<?php echo $ano; ?>" />                                    
                                    <div>
                                        <div class="row" style="margin-bottom: 20px;">
                                            <div class="col-md-12">
                                                <span class="text-main text-semibold">
                                                    
                                                </span>                                                                                                                                                
                                            </div>
                                        </div>                                        
                                    </div>                                                                                                                                                                                                                                                                                               
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <b>Estado da Prévia-LOA:</b>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php echo $estadoPreLoa; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <b>Situação da Prévia-LOA:</b>
                                        </div>
                                        <div class="col-sm-9">
                                            <?php echo $situacaoPreLoa; ?>
                                        </div>
                                    </div>                                
                                    <div class="row">
                                        <div class="text-left">                                                                                                                                          
                                            <textarea class="form-control" rows="4" disabled="" style="text-align: left;"><?php echo $mensagens; ?></textarea>       
                                        </div>
                                    </div>
                                                                                
                                </div>
                                <!-- End <div class="form-group"> -->                                       
                            </div>
                            <div class="panel-footer">                                              
                                <div class="text-right">      
                                    <button class="btn btn-primary btn-rounded" type="button" <?php echo $botaoDisabled; ?> data-toggle="modal" data-target="#modalAutorizar">
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i> Autorizar Prévia-LOA
                                    </button> 
                                    <button class="btn btn-danger btn-rounded" type="button" data-toggle="modal" <?php echo $botaoDisabled; ?> data-target="#modalRetornar">
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i> Retornar Prévia-LOA Para Planejamento
                                    </button>  
                                </div>
                            </div>
                        </div>
                                                                       
                                               
                        <div id="informacao">
                        </div>
                        <a download="sesacre.xlsx" class="btn btn-primary btn-rounded" style="display: none;" href="#" id="sesacre-xlsx" onclick="return exportExcel('xlsx', <?php echo $ano; ?>);">Exportar Excel (Temporário)</a>
                        
                        <div class="modal fade"
                            tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel"
                            id="modalTabelaPreLoa"
                            data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Selecione uma Prévia-LOA para Autorização</h4>                                                                                                                                        
                                    </div>
                                    <div class="modal-body" id="bodyModalTabelaPreLoa">
                                        
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade"
                            tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel"
                            id="modalAutorizar"
                            data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Mensagem de Autorização</h4>                                                                                                                                        
                                    </div>
                                    <div class="modal-body">
                                        <p>Caso deseje autorizar a Prévia-LOA, clique no Botão <strong class="text-success">Autorizar</strong>.</p>
                                        <p>Poderá digitar alguma informação com relação a Prévia-LOA.</p>
                                        <textarea class="form-control modalMsgAutorizar" rows="4"></textarea>   
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Fechar</button>                                        
                                        <button type="button" class="btn btn-success btn-rounded btn-autorizar">Autorizar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade"
                            tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel"
                            id="modalRetornar"
                            data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Mensagem de Autorização</h4>                                                                                                                                        
                                    </div>
                                    <div class="modal-body">
                                        <p>Caso deseje retornar a Prévia-LOA para o Planejamento, clique no Botão <strong class="text-danger">Retornar</strong>.</p>
                                        <p>Retornar a Prévia-LOA indicará que você não está de acordo e requer uma revisão nos valores.</p>
                                        <p>Poderá digitar alguma informação com relação a Prévia-LOA.</p>
                                        <textarea class="form-control modalMsgRetornar" rows="4"></textarea>   
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Fechar</button>                                        
                                        <button type="button" class="btn btn-danger btn-rounded btn-retornar">Retornar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="modal fade"
                            tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel"
                            id="modalAno"
                            data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Escolher Ano</h4>                                                                                                                                        
                                    </div>
                                    <div class="modal-body">                                        
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
        
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/lib/excellentexport/excellentexport.js"></script>
        <script src="/assets/js/pla/pre_loa/autorizacao.js"></script>
           
        <!-- END JAVASCRIPT -->

    </body>
</html>
