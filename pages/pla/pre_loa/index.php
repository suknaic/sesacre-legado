<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/pla/pre_loa/index.load.php";
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
                        <h1 class="page-header text-overflow">Prévia-LOA <?php echo ($ano == 0)? "" : $ano; ?></h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <div id="menu_pta">
                            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/pla/pre_loa/menuPreLoa.php";  ?>
                        </div>
                        <div class="panel"> 
                            <div class="panel-body">                                
                                <div class="form-group">
                                    <input type="hidden" id="ano" value="<?php echo $ano; ?>" />                                    
                                    <div>
                                        <div class="row" style="margin-bottom: 20px;">
                                            <div class="col-md-12">
                                                <span class="text-main text-semibold">
                                                    Depois que todos os PAS estiverem autorizados pelo Planejamento, poderá ser gerado a Prévia-LOA.<br>                                                    
                                                    Será analisado como está a situação das PAS, se alguma ainda está em processo de autorização ou não foi criado.<br>
                                                    Ao Gerar uma Simulação da Prévia-LOA somente será considerado as PAS Autorizadas.
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
                                    
                                    <button class="btn btn-danger btn-rounded btn-retornar-planejamento" 
                                            <?php echo $botaoRetornoPlanejamentoDisabled; ?>
                                            type="button"                                            
                                            >
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i> Retornar Prévia-LOA Para Planejamento
                                    </button>
                                    <button class="btn btn-primary btn-rounded btn-enviar-planejamento" 
                                            <?php echo $botaoEnviarPlanejamentoDisabled; ?>
                                            type="button"
                                            title="Quando a Prévia-LOA for Criada ou Retornada, poderá enviar para Autorização."
                                            >
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i> Enviar Prévia-LOA Para Autorização
                                    </button>
                                    <a href="valores.php?token=<?php echo $ano; ?>" class="btn btn-primary btn-rounded btn-pre-loa" title="Simular Valores da Prévia-LOA">
                                        Simular Valores da Prévia-LOA
                                    </a>                                
                                </div>
                            </div>
                        </div>
                        
                        <div class="panel-body selecaoAno" style="display: none;">                                
                            <div class="form-group">
                                <div class="panel-body" >                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="anoSelect">
                                                Ano:
                                            </label>                                                        
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-list inputPFa"></p>
                                                </span>
                                                <select id="anoSelect" class="form-control anoSelect">
                                                    <option value="0">Selecione um Ano</option>                                                                
                                                    <?php
                                                        echo Metodos::retornaAnosSelect(1);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                                                                                                                                                                                                                                                                               
                            </div>
                            <!-- End <div class="form-group"> -->                                       
                        </div>
                        
                                               
                        <div id="informacao">
                        </div>
                        
                        <div class="modal fade"
                            tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel"
                            id="modalEnvioPlanejamento"
                            data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Mensagem de Envio para Autorização</h4>                                                                                                                                        
                                    </div>
                                    <div class="modal-body">
                                        <p>Caso deseje enviar a Prévia-LOA Para Autorização, clique no Botão <strong class="text-success">Enviar</strong>.</p>
                                        <p>Poderá digitar alguma informação com relação a Prévia-LOA.</p>
                                        <textarea class="form-control modalMsgEnvio" rows="4"></textarea>   
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Fechar</button>                                        
                                        <button type="button" class="btn btn-success btn-rounded btn-envia-planejamento">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade"
                            tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel"
                            id="modalRetornoPlanejamento"
                            data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Mensagem de Retorno da Prévia-LOA</h4>                                                                                                                                        
                                    </div>
                                    <div class="modal-body">
                                        <p>Caso deseje Retornar a Prévia-LOA Para o Planejamento, clique no Botão <strong class="text-success">Retornar</strong>.</p>
                                        <p>Planejamento poderá Retornar a Prévia-LOA a Qualquer momento para alteração, porém ela deverá passar por todas as autorizações para ser validada.</p>
                                        <p>Poderá digitar alguma informação com relação a Prévia-LOA.</p>
                                        <textarea class="form-control modalMsgRetorno" rows="4"></textarea>   
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Fechar</button>                                        
                                        <button type="button" class="btn btn-success btn-rounded btn-retorna-planejamento">Retornar</button>
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
        <script src="/assets/js/pla/pre_loa/index.js"></script>
           
        <!-- END JAVASCRIPT -->

    </body>
</html>
