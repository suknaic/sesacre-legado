<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/pla/index.load.php";
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
                        <h1 class="page-header text-overflow">Planejamento</h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <div class="row">
                            <?php if($session->vPPlanejamentoUsuario()){ ?>
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">
                                        <!-- <img alt="Profile Picture" class="img-lg img-circle mar-btm" src="img/profile-photos/5.png"> -->
                                        <p class="text-lg text-semibold mar-no text-main">Programação Anual de Saúde(PAS)/Plano de Trabalho Anual(PTA)</p>                                        
                                        <div class="mar-top">
                                            <a href="pas/" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            
                            <?php if($session->vPPlanejamento()){ ?>
                            
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">
                                        <!-- <img alt="Profile Picture" class="img-lg img-circle mar-btm" src="img/profile-photos/5.png"> -->
                                        <p class="text-lg text-semibold mar-no text-main">Programa/Projeto/Atividade do PPA</p>                                        
                                        <div class="mar-top">     
                                            <a href="ppa_prog/" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">
                                        <!-- <img alt="Profile Picture" class="img-lg img-circle mar-btm" src="img/profile-photos/5.png"> -->
                                        <p class="text-lg text-semibold mar-no text-main">Plano Estadual de Saúde</p>                                        
                                        <div class="mar-top">
                                            <a href="pes/" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">
                                        <!-- <img alt="Profile Picture" class="img-lg img-circle mar-btm" src="img/profile-photos/5.png"> -->
                                        <p class="text-lg text-semibold mar-no text-main">Responsáveis Pela Programação Anual de Saúde</p>                                        
                                        <div class="mar-top">
                                            <a href="pas_resp/" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">                                        
                                        <p class="text-lg text-semibold mar-no text-main">Indicador de Saúde</p>                                        
                                        <div class="mar-top">
                                            <a href="ind_saude/" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">                                        
                                        <p class="text-lg text-semibold mar-no text-main">Liberação de Valor Limite Para Unidades</p>                                        
                                        <div class="mar-top">
                                            <a href="liberacao_fonte/" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">                                        
                                        <p class="text-lg text-semibold mar-no text-main">PAS Esperando Autorização</p>                                        
                                        <div class="mar-top">
                                            <a href="pas_validacao" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">                                        
                                        <p class="text-lg text-semibold mar-no text-main">Autorizar Alteração da PAS</p>                                        
                                        <div class="mar-top">
                                            <a href="pas_liberacao" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">                                        
                                        <p class="text-lg text-semibold mar-no text-main">Prévia-LOA</p>                                        
                                        <div class="mar-top">
                                            <a href="pre_loa" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">                                        
                                        <p class="text-lg text-semibold mar-no text-main">Relatórios</p>                                        
                                        <div class="mar-top">
                                            <a href="relatorios" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">                                        
                                        <p class="text-lg text-semibold mar-no text-main">Perfil No Sistema</p>                                        
                                        <div class="mar-top">
                                            <a href="perfil" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">                                        
                                        <p class="text-lg text-semibold mar-no text-main">Responsáveis Pelas Centrais de Demanda</p>                                        
                                        <div class="mar-top">
                                            <a href="central_resp/" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php } ?>
                            
                            <?php if($session->vPPlanejamento() 
                                    || $session->vPPlanejamentoCentral()){ ?>
                            
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">                                        
                                        <p class="text-lg text-semibold mar-no text-main">Central de Demanda</p>                                        
                                        <div class="mar-top">
                                            <a href="central/" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php } ?>
                           
                            <?php if($session->vPPlanejamento() 
                                    || $session->vPPlanejamentoPreLoa()){ ?>
                            
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">                                        
                                        <p class="text-lg text-semibold mar-no text-main">Autorização da Prévia-LOA</p>                                        
                                        <div class="mar-top">
                                            <a href="pre_loa/autorizacao.php" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                     
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } ?>
                            
                             <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body text-center">                                        
                                        <p class="text-lg text-semibold mar-no text-main">Ordem de Entrega</p>                                        
                                        <div class="mar-top">
                                            <a href="ordem_entrega/" class="btn btn-primary btn-rounded" title="Ação">Entrar</a>                                                                                     
                                        </div>
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
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>     
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
           
        <!-- END JAVASCRIPT -->

    </body>
</html>
