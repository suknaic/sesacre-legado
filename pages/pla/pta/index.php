<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/pla/pta/index.load.php";
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
                        <h1 class="page-header text-overflow">Plano de Trabalho Anual - <?php echo $nomePas; ?></h1>                           
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    
                    <ol class="breadcrumb">
                        <li ><a href="../pas/pas_info.php?token=<?php echo $idPas; ?>">PAS</a></li>
                        <li class="active">PTA</li>                        
                    </ol>

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        
                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel ">
                                    <div class="panel-heading">                                        
                                        <div class="panel-control">					
                                            <!--Nav tabs-->
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#form-1" aria-expanded="true">Formulário</a></li>
                                                <li class=""><a data-toggle="tab" href="#info-2" aria-expanded="false">Informações</a></li>
                                            </ul>					
                                        </div>                                     
                                        <h3 class="panel-title">Dados do PTA</h3>
                                    </div>

                                    <!--Horizontal Form-->
                                    <!--===================================================-->
                                    <form class="form-horizontal form">                                        
                                        <input type="hidden" name="pas" id="pas" value="<?php echo $idPas; ?>" />
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div id="form-1" class="tab-pane fade active in">
                                                    <div class="form-group">

                                                        <div class="col-md-6">
                                                            <div class="panel-body">
                                                                <label for="nome">
                                                                    Nome do Plano: <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                     <input type="text" class="form-control" name="nome" id="nome" required="true">
                                                                </div>
                                                            </div>
                                                        </div>                                                                                                                                                                                                                                                                                                                                                                                  

                                                        <div class="col-md-3">
                                                            <div class="panel-body">
                                                                <label for="dt_inicio">
                                                                    Data Início: <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <p class="fa fa-calendar inputPFa"></p>
                                                                            </span>
                                                                    <input type="text" class="form-control" name="dt_inicio" id="dt_inicio" placeholder="__/__/____" required="true">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="panel-body">
                                                                <label for="dt_fim">
                                                                    Data Fim: <span class="text-danger">*</span>
                                                                </label>
                                                                <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <p class="fa fa-calendar inputPFa"></p>
                                                                            </span>
                                                                    <input type="text" class="form-control" name="dt_fim" id="dt_fim" placeholder="__/__/____" required="true">
                                                                </div>
                                                            </div>
                                                        </div>                                                     

                                                    </div>
                                                    <!-- End <div class="form-group"> -->
                                                </div>
                                                <div id="info-2" class="tab-pane fade">
                                                    <p class="text-main text-lg mar-no"><?php echo $lista; ?></p>
                                                    
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

                        <!-- Modal -->
                        <div class="modal fade" id="modalTitulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Cadastro/Edição do Título do PTA</h4>
                              </div>
                              <div class="modal-body">
                                    <form class="form-horizontal form">                                                                                
                                        <div class="panel-body">                                                                               
                                            <div class="form-group">
                                                
                                                <div class="col-md-6">
                                                    <div class="panel-body">
                                                        <label for="titulo">
                                                            Nome do Título: <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-file-text-o inputPFa"></p>
                                                            </span>
                                                             <input type="text" class="form-control" name="titulo" id="titulo" required="true">
                                                        </div>
                                                    </div>
                                                </div>  
                                                
                                                <div class="col-md-6">
                                                    <div class="panel-body">
                                                        <label for="objeto">
                                                            Objeto:
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-file-text-o inputPFa"></p>
                                                            </span>
                                                             <input type="text" class="form-control" name="objeto" id="objeto" required="true">
                                                        </div>
                                                    </div>
                                                </div> 
                                                
                                                <div class="col-md-6">
                                                    <div class="panel-body">
                                                        <label for="programa">
                                                            Programa de Trabalho: <span class="text-danger">*</span>
                                                        </label>                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="programa" class="form-control">
                                                                <!-- <option value="0">Selecione um Programa de Trabalho</option> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>                                                                                                
                                                
                                                <div class="col-md-6">
                                                    <div class="panel-body">
                                                        <label for="proj_ppa_ati">
                                                            Projeto/Atividade do PPA: <span class="text-danger">*</span>
                                                        </label>                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="proj_ppa_ati" class="form-control">                                                                                                                              
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                                                               
                                                <div class="col-md-6">
                                                    <div class="panel-body">
                                                        <label for="justificativa">
                                                            Justificativa:
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-file-text-o inputPFa"></p>
                                                            </span>
                                                             <input type="text" class="form-control" name="justificativa" id="justificativa" required="true">
                                                        </div>
                                                    </div>
                                                </div>  
                                               
                                                
                                            </div>                                                                                                                                                                                       
                                        </div>                                                                            
                                    </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-default btn-info btn-rounded btn-titulo-editar" style="display: none;">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar Edição
                                </button>
                                <button type="button" class="btn btn-danger btn-info btn-rounded btn-titulo-remover" style="display: none;">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Remover
                                </button>
                                <button class="btn btn-success btn-rounded btn-titulo-salvar" type="button">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                </button>                                
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="panel">                            
                            <div class="panel-body">
                                <div class="row box-ptas">                                                                                                        
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
        <!--Datapicker-->
        <script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!--MaskedInput-->
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        
        
        <script src="/assets/js/pla/pta/index.js"></script>
           
        <!-- END JAVASCRIPT -->

    </body>
</html>
