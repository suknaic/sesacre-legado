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
                        <h4 class="text-main pad-btm bord-btm">Acompanhamento rápido dos seus chamados</h4>
                        <form action="abertura/cadastraChamado.php?id=<?php echo $id; ?>" method="post">
                            <div class="container-fluid">
                                <div class="btn-group dropdown dropup">
                                    <button class="btn btn-primary btn-hover mar-ver btn-circle add-tooltip dropdown-toggle dropdown-toggle-icon rotate" style="margin-left: 870px; display: block" aria-expanded="false" data-toggle="dropdown">
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
                            </div>

                        </form>
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->



                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <div class="row">

                            <!--                            <div class="col-sm-4 text-center">
                                                            <button class="btn">
                                                                <a href="listagem/index.php">
                                                                    <div class="panel panel-bordered panel-primary">
                                                                        <div class="panel-heading">
                                                                            <h3 class="panel-title text-center">Meus Chamados</h3>
                                                                        </div>
                                                                        <div class="panel-body text-center">
                                                                            <span class="fa fa-user fa-2x" style="margin-right: 200px"></span>
                                                                            <span class="text-right text-lg mar-no" style="font-size: 25px">15</span>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </button>
                                                        </div>-->

                            <div class="col-lg-5 text-center" style="margin-left: 90px">
                                <div class="panel">
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">30</p>                                            
                                            </div>
                                            <p class="text-sm text-bold text-uppercase">Chamados</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <button class="btn btn-primary mar-ver">Visualizar Chamados</button>
                                            <p class="text-xs">Clique para visualizar seus chamados que já foram abertos.</p>
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

                            <div class="col-lg-5 text-center">
                                <div class="panel">
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">9</p>                                            
                                            </div>
                                            <p class="text-sm text-bold text-uppercase">Aguardando Atendimento</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <form action="/pages/cha/listagem/aguardandoAtendimento.php">
                                                <button class="btn btn-primary mar-ver">Visualizar Chamados</button>
                                            </form>
                                            <p class="text-xs">Clique para visualizar seus chamados que estão aguardando atendimento.</p>
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

                            <div class="col-lg-5 text-center" style="margin-left: 90px">
                                <div class="panel">
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">2</p>                                            
                                            </div>
                                            <p class="text-sm text-bold text-uppercase">Em Atendimento</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <button class="btn btn-primary mar-ver">Visualizar Chamados</button>
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

                            <div class="col-lg-5 text-center">
                                <div class="panel">
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">5</p>                                            
                                            </div>
                                            <p class="text-sm text-bold text-uppercase">Agendados</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <button class="btn btn-primary mar-ver">Visualizar Chamados</button>
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

                            <div class="col-lg-5 text-center" style="margin-left: 90px">
                                <div class="panel">
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">25</p>                                            
                                            </div>
                                            <p class="text-sm text-bold text-uppercase">Finalizados</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <button class="btn btn-primary mar-ver">Visualizar Chamados</button>
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

                            <div class="col-lg-5 text-center">
                                <div class="panel">
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">13</p>                                            
                                            </div>
                                            <p class="text-sm text-bold text-uppercase">Cancelados</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <form action="/pages/cha/listagem/cancelado.php">
                                                <button class="btn btn-primary mar-ver">Visualizar Chamados</button>
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

                            <div class="col-lg-5 text-center" style="margin-left: 90px">
                                <div class="panel">
                                    <div class="panel-body text-center clearfix">
                                        <div class="col-sm-4 pad-top">
                                            <div class="text-lg">
                                                <p class="text-5x text-thin text-main">4</p>                                            
                                            </div>
                                            <p class="text-sm text-bold text-uppercase">Não Avaliados</p>
                                        </div>
                                        <div class="col-sm-8">
                                            <button class="btn btn-primary mar-ver">Visualizar Chamados</button>
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
