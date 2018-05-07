<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/pla/pas_validacao/pas_validar.load.php";
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
                        <h1 class="page-header text-overflow">Dados da PAS Para Autorização pela Planejamento</h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    
                     <ol class="breadcrumb">
                        <li class="active"><a href="index.php">Voltar</a></li>                        
                    </ol>

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        
                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel">                                    
                                    
                                    <!--Horizontal Form-->
                                    <!--===================================================-->
                                    <form class="form-horizontal formDados">
                                        <div class="panel-body">                                            
                                            <input type="hidden" name="pas" id="pas" value="<?php echo $idPas; ?>" />                                            
                                            <div class="form-group">                                                
                                                <div class="form-group">
                                                     <div class="panel-body">
                                                    <?php echo $info; ?>
                                                     </div>                                                                                                                                                                                                                                                                                   
                                                </div>                                                                                                    
                                            </div>
                                            <!-- End <div class="form-group"> -->                                       
                                        </div>
                                        <!-- <div class="panel-body"> -->
                                        
                                        <div class="panel-footer">                                               
                                            <div class="text-right">                                                   
                                                <a href="../pas/pas_info.php?token=<?php echo $idPas;?>" target="_blank" class="btn btn-primary btn-entrar btn-rounded" title="Visualizar PAS"> 
                                                    Abrir uma Nova Aba e Visualizar a PAS por Completo
                                                </a>
                                                <button class="btn btn-primary btn-rounded" type="button" data-toggle="modal" data-target="#modalValida">
                                                    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Autorizar a PAS
                                                </button>
                                                <button class="btn btn-primary btn-rounded" type="button" data-toggle="modal" data-target="#modalNaoValida">
                                                    <i class="fa fa-thumbs-o-down" aria-hidden="true"></i> Não Autorizar a PAS
                                                </button>
                                            </div>                                                                                                                                                                                                                                                                              
                                        </div>
                                            
                                      

                                    </form>
                                    <!--===================================================-->
                                    <!--End Horizontal Form-->

                                </div>
                            </div>
                        </div>
                        <!-- Fim Form -->
                                                                                                                                                                                                   
                        
                        <div class="modal fade"
                            tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel"
                            id="modalValida"
                            data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Mensagem de Autorização da PAS</h4>
                                    </div>
                                    <div class="modal-body">                                        
                                        <p>Como Planejamento, você <strong>ESTÁ AUTORIZANDO</strong> a PAS.</p>                                        
                                        <p>Quando Autorizado, a PAS está pronta. A Área Administrativa/Técnica/Assistencial está bloqueada de fazer qualquer alterarão na Memória de Cálculo, para qualquer alteração deverá ser solicitado liberação para o Planejamento.</p>
                                        <p>Caso tenha necessidade, poderá enviar alguma mensagem para a Área Administrativa/Técnica/Assistencial.</p>   
                                        <p>Caso deseje Autorizar a PAS, clique no Botão <span class="text-success">Autorizar</span>.</p>
                                        <textarea class="form-control modalMsgValida" rows="4"></textarea>   
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Fechar</button>                                        
                                        <button type="button" class="btn btn-success btn-rounded btn-enviar-valida">Autorizar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade"
                            tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel"
                            id="modalNaoValida"
                            data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Mensagem de Autorização da PAS</h4>                                                                                                                                    
                                    </div>
                                    <div class="modal-body">
                                        <p>Como Planejamento, você <strong>NÃO ESTÁ AUTORIZANDO</strong> a PAS.</p>
                                        <p>Ela será retornada para a Área Administrativa/Técnica/Assistencial para fazer os devidos reajustes.</p>
                                        <p>Caso tenha necessidade, poderá enviar alguma mensagem para a Área Administrativa/Técnica/Assistencial.</p> 
                                        <p>Caso deseje Não Autorizar a PAS, clique no Botão <span class="text-success">Não Autorizar</span>.</p>
                                        <textarea class="form-control modalMsgNaoValida" rows="4"></textarea>   
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Fechar</button>                                        
                                        <button type="button" class="btn btn-success btn-rounded btn-enviar-nao-valida">Não Autorizar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    <?php echo $textAreaMsgs; ?>
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
        <script src="/assets/js/pla/pas_validacao/pas_validar.js"></script>
           
        <!-- END JAVASCRIPT -->

    </body>
</html>
