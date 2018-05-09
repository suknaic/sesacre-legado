<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/cha/index.load.php";
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
        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css">
        <style>
            .rotate:hover
            {
                -webkit-transform: rotateZ(50deg);
                -ms-transform: rotateZ(50deg);
                transform: rotateZ(50deg);
            }
            .grow:hover
            {
                -webkit-transform: scale(1.3);
                -ms-transform: scale(1.3);
                transform: scale(1.3);
            }
            .hover-btn:hover
            {
                display: block;
            }
        </style>
    </head>
    <!--TIPS-->

    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-lg">

            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

            <div class="boxed">

                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">

                    <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Help Desk</h1>
                        <p class="pad-btm text-sm">Acompanhamento rápido dos seus chamados</p>
                        <form action="abertura/cadastraChamado.php?id=<?php echo $id; ?>" method="post" style="margin-top: -80px; margin-bottom: 100px">
                                <div class="btn-group dropdown" style="float: right">
                                    <button class="btn btn-warning btn-hover mar-ver btn-circle add-tooltip dropdown-toggle dropdown-toggle-icon rotate" style="display: block" aria-expanded="false" data-toggle="dropdown">
                                        <i class="fa fa-plus" style="margin-bottom: 6px; margin-left: 7px; margin-right: 7px; margin-top: 6px"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right" style="opacity: 1">
                                        <li>
                                            <a href="abertura/cadastraChamado.php?id=<?php echo $id; ?>" method="post">Novo Chamado</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#">Sugestões</a>
                                        </li>
                                        <li>
                                            <a href="#">Reclamações</a>
                                        </li>
                                    </ul>
                                </div>

                        </form>
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->



                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <div class="row">
                            <!--//*****************************************-->
                            <div class="col-sm-6 col-lg-6" style="margin-left: 5px; margin-right: -3px">
                                <div class="panel">
                                    <div class="panel-heading" style="background-color: #00C5CD">
                                        <h3 class="panel-title text-center" style="color: #FFF">Chamados</h3>
                                    </div>
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">2</p>                                            
                                            </div>
                                            <p class="text-bold text-uppercase" style="font-size: 12px">Chamados Abertos</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <form action="/pages/cha/listagem/chamadosAbertos.php">
                                                <button class="btn mar-ver" style="background-color: #00C5CD; color: #FFF">Visualizar Chamados</button>
                                            </form>                                            <p class="text-xs">Clique para visualizar todos os seus chamados.</p>
                                            <ul class="list-unstyled text-center bord-top pad-top mar-no row">
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">302</span> <!--idDoChamado-->
                                                    <p class="text-sm text-muted mar-no">Computador</p><!--Primaria-->
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">273</span>
                                                    <p class="text-sm text-muted mar-no">Sesacrenet</p>
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">122</span>
                                                    <p class="text-sm text-muted mar-no">Siag</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6" style="margin-right: -3px">
                                <div class="panel">
                                    <div class="panel-heading" style="background-color: #00C5CD">
                                        <h3 class="panel-title text-center" style="color: #FFF">Aguardando Aprovação</h3>
                                    </div>
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">2</p>                                            
                                            </div>
                                            <p class="text-bold text-uppercase" style="font-size: 12px">Aguardando Aprovação</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <form action="/pages/cha/listagem/aguardandoAprovacao.php">
                                                <button class="btn mar-ver" style="background-color: #00C5CD; color: #FFF">Visualizar Chamados</button>
                                            </form>
                                            <p class="text-xs">Clique para visualizar seus chamados que estão Aguardando Aprovação.</p>
                                            <ul class="list-unstyled text-center bord-top pad-top mar-no row">
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">302</span> <!--idDoChamado-->
                                                    <p class="text-sm text-muted mar-no">Computador</p><!--Primaria-->
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">273</span>
                                                    <p class="text-sm text-muted mar-no">Sesacrenet</p>
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">122</span>
                                                    <p class="text-sm text-muted mar-no">Siag</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6" style="margin-left: 5px; margin-right: -3px">
                                <div class="panel">
                                    <div class="panel-heading" style="background-color: #00C5CD">
                                        <h3 class="panel-title text-center" style="color: #FFF">Em Atendimento</h3>
                                    </div>
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">2</p>                                            
                                            </div>
                                            <p class="text-bold text-uppercase" style="font-size: 12px">Em Atendimento</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <button class="btn mar-ver" style="background-color: #00C5CD; color: #FFF">Visualizar Chamados</button>
                                            <p class="text-xs">Clique para visualizar seus chamados que estão em atendimento.</p>
                                            <ul class="list-unstyled text-center bord-top pad-top mar-no row">
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">302</span> <!--idDoChamado-->
                                                    <p class="text-sm text-muted mar-no">Computador</p><!--Primaria-->
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">273</span>
                                                    <p class="text-sm text-muted mar-no">Sesacrenet</p>
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">122</span>
                                                    <p class="text-sm text-muted mar-no">Siag</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6" style="margin-right: -3px">
                                <div class="panel">
                                    <div class="panel-heading" style="background-color: #00C5CD">
                                        <h3 class="panel-title text-center" style="color: #FFF">Cancelados</h3>
                                    </div>
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">2</p>                                            
                                            </div>
                                            <p class="text-bold text-uppercase" style="font-size: 12px">Cancelados</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <form action="/pages/cha/listagem/cancelado.php">
                                                <button class="btn mar-ver" style="background-color: #00C5CD; color: #FFF">Visualizar Chamados</button>
                                            </form>
                                            <p class="text-xs">Clique para visualizar seus chamados que foram cancelados.</p>
                                            <ul class="list-unstyled text-center bord-top pad-top mar-no row">
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">302</span> <!--idDoChamado-->
                                                    <p class="text-sm text-muted mar-no">Computador</p><!--Primaria-->
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">273</span>
                                                    <p class="text-sm text-muted mar-no">Sesacrenet</p>
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">122</span>
                                                    <p class="text-sm text-muted mar-no">Siag</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6" style="margin-left: 5px; margin-right: -3px">
                                <div class="panel">
                                    <div class="panel-heading" style="background-color: #00C5CD">
                                        <h3 class="panel-title text-center" style="color: #FFF">Agendados</h3>
                                    </div>
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">2</p>                                            
                                            </div>
                                            <p class="text-bold text-uppercase" style="font-size: 12px">Agendados</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <button class="btn mar-ver" style="background-color: #00C5CD; color: #FFF">Visualizar Chamados</button>
                                            <p class="text-xs">Clique para visualizar seus chamados que estão agendados.</p>
                                            <ul class="list-unstyled text-center bord-top pad-top mar-no row">
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">302</span> <!--idDoChamado-->
                                                    <p class="text-sm text-muted mar-no">Computador</p><!--Primaria-->
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">273</span>
                                                    <p class="text-sm text-muted mar-no">Sesacrenet</p>
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">122</span>
                                                    <p class="text-sm text-muted mar-no">Siag</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6" style="margin-right: -3px">
                                <div class="panel">
                                    <div class="panel-heading" style="background-color: #00C5CD">
                                        <h3 class="panel-title text-center" style="color: #FFF">Pausados</h3>
                                    </div>
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">2</p>                                            
                                            </div>
                                            <p class="text-bold text-uppercase" style="font-size: 12px">Pausados</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <button class="btn mar-ver" style="background-color: #00C5CD; color: #FFF">Visualizar Chamados</button>
                                            <p class="text-xs">Clique para visualizar seus chamados que estão pausados.</p>
                                            <ul class="list-unstyled text-center bord-top pad-top mar-no row">
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">302</span> <!--idDoChamado-->
                                                    <p class="text-sm text-muted mar-no">Computador</p><!--Primaria-->
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">273</span>
                                                    <p class="text-sm text-muted mar-no">Sesacrenet</p>
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">122</span>
                                                    <p class="text-sm text-muted mar-no">Siag</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6" style="margin-left: 5px; margin-right: -3px">
                                <div class="panel">
                                    <div class="panel-heading" style="background-color: #00C5CD">
                                        <h3 class="panel-title text-center" style="color: #FFF">Aguardando Avaliação</h3>
                                    </div>
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">2</p>                                            
                                            </div>
                                            <p class="text-bold text-uppercase" style="font-size: 12px">Aguardando Avaliação</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <button class="btn mar-ver" style="background-color: #00C5CD; color: #FFF">Visualizar Chamados</button>
                                            <p class="text-xs">Clique para visualizar seus chamados que precisam ser avaliados.</p>
                                            <ul class="list-unstyled text-center bord-top pad-top mar-no row">
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">302</span> <!--idDoChamado-->
                                                    <p class="text-sm text-muted mar-no">Computador</p><!--Primaria-->
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">273</span>
                                                    <p class="text-sm text-muted mar-no">Sesacrenet</p>
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">122</span>
                                                    <p class="text-sm text-muted mar-no">Siag</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-6" style="margin-right: -3px">
                                <div class="panel">
                                    <div class="panel-heading" style="background-color: #00C5CD">
                                        <h3 class="panel-title text-center" style="color: #FFF">Finalizados</h3>
                                    </div>
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">2</p>                                            
                                            </div>
                                            <p class="text-bold text-uppercase" style="font-size: 12px">Finalizados</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <button class="btn mar-ver" style="background-color: #00C5CD; color: #FFF">Visualizar Chamados</button>
                                            <p class="text-xs">Clique para visualizar seus chamados que estão finalizados.</p>
                                            <ul class="list-unstyled text-center bord-top pad-top mar-no row">
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">302</span> <!--idDoChamado-->
                                                    <p class="text-sm text-muted mar-no">Computador</p><!--Primaria-->
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">273</span>
                                                    <p class="text-sm text-muted mar-no">Sesacrenet</p>
                                                </li>
                                                <li class="col-xs-4">
                                                    <span class="text-lg text-semibold text-main">122</span>
                                                    <p class="text-sm text-muted mar-no">Siag</p>
                                                </li>
                                            </ul>
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
            </div>
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
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>

        <!-- END JAVASCRIPT -->

    </body>
</html>
