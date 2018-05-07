<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/pla/pas/pas_info.load.php";
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
        <!--Datapicker-->
        <link href="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
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
                        <h1 class="page-header text-overflow">Programação Anual de Saúde - <?php echo $pas->getNmLotacao(); ?></h1>                           
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    
                    <ol class="breadcrumb">
                        <li class="active"><a href="index.php">Voltar</a></li>                        
                    </ol>

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <div id="menu_pta">
                            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/pla/pta/menuPas.php";  ?>
                        </div>
                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel">
                                    <div class="panel-heading ">
                                        <h3 class="panel-title"><?php echo $pas->getNmPas(); ?></h3>
                                    </div>

                                    <!--Horizontal Form-->
                                    <!--===================================================-->
                                    <form class="form-horizontal form">                                        
                                        <input type="hidden" name="pas" id="pas" value="<?php echo $idPas; ?>" />
                                        <div class="panel-body">
                                            <div class="form-group">
                                                 <div class="panel-body">
                                                <?php echo $info; ?>
                                                 </div>                                                                                                                                                                                                                                                                                   
                                            </div>
                                            
                                            <?php echo $msgValidacaoComCentral; ?>
                                            <?php echo $msgIndicador; ?>
                                            
                                            <!-- End <div class="form-group"> -->
                                            <!--
                                            Várias Informações sobre a PAS, botão de enviar PAS, Validar e etc;
                                            <br><span class="small">
                                            Talvez alguns gráficos
                                            </span> -->
                                        </div>
                                        <!-- <div class="panel-body"> -->

                                        
                                        <!-- Footer Form -->
                                        <div class="panel-footer text-right">    
                                            <button class="btn btn-primary btn-rounded btn-enviar-planejamento" 
                                                    <?php echo $botaoEnviarPlanejamentoDisabled; ?>
                                                    type="button"
                                                    title="Quando todos os Itens forem Validados Pela Central, poderá enviar a PAS para o Planejamento."
                                                    >
                                                <i class="fa fa-paper-plane" aria-hidden="true"></i> Enviar PAS Para Planejamento
                                            </button>
                                            
                                            <a href="pas.php?token=<?php echo $pas->getIdLotacao();?>" class="btn btn-primary btn-entrar btn-rounded" title="Editar PAS"> 
                                                Cadastar/Gerenciar PAS
                                            </a> 
                                            <a href="pas.php?token=<?php echo $pas->getIdLotacao();?>&tokenI=<?php echo $pas->getIdPas(); ?>" class="btn btn-primary btn-entrar btn-rounded" title="Editar PAS"> 
                                                Editar PAS
                                            </a>                                            
                                        </div>
                                        <!-- End Form -->
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
                            id="modalEnvioPlanejamento"
                            data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Mensagem de Envio para o Planejamento</h4>                                                                                                                                        
                                    </div>
                                    <div class="modal-body">
                                        <p>Caso deseje enviar a PAS Para o Planejamento, clique no Botão <strong class="text-success">Enviar</strong>.</p>
                                        <p>Poderá digitar alguma informação para o Planejamento com relação a PAS.</p>
                                        <textarea class="form-control modalMsgEnvio" rows="4"></textarea>   
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Fechar</button>                                        
                                        <button type="button" class="btn btn-success btn-rounded btn-envia-planejamento">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                         <div class="panel">                            
                            <div class="panel-body">
                                <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="tabela" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>PTA</th>
                                                        <th>Título do PTA</th>
                                                        <th>Data</th>                                                                                                                                                                        
                                                        <th class="text-center">Ações</th> 
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
                        
                        <?php echo $textAreaMsgs; ?>
                        
                        <div id="valoresLiberado">
                            
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
              
        
        
        <script src="/assets/js/pla/pas/pas_info.js"></script>
           
        <!-- END JAVASCRIPT -->

    </body>
</html>
