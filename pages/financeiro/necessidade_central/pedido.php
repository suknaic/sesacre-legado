<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/financeiro/necessidade_central/pedido.load.php";
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
        <!--Select2-->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">

        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css">
        
        <style>

            /* Important part */
            .modal-diaria{
                overflow-y: initial !important
            }
            .modal-diaria-corpo{
                height: 650px;
                overflow-y: auto;
            }
        </style>
    </head>
    <!--TIPS-->

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
                    <!--End page title-->
                    
                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        
                        <!-- Modal -->
                        <div id="diaria_info" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-diaria" role="document" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Informações da Diária</h4>
                                    </div>
                                    <div class="modal-body modal-diaria-corpo" id="diaria_dados">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                        
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Informações sobre a Solicitação de necessidade</h3>
                            </div>

                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        Tipo de solicitação:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                            <select class="form-control select" name="tipoSolicitacao" id="tipoSolicitacao" required="true">
                                                <option value="" >Selecione o tipo de Solicitação</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        Central:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                            <select class="form-control select" name="central" id="central" required="true">
                                                <option value="" >Selecione uma central</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        Tipo de gasto:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                            <select class="form-control select" name="tipoDeGasto" id="tipoDeGasto" required="true">
                                                <option value="" >Selecione uma tipo de gasto</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            
                            <!--                            VINCULACAO DA DIARIA-->
                            <div class="row" id="diaria">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        Nº da Diária:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                            <select id="id_diaria" name="id_diaria" class="form-control select">
                                            
                                            </select>
                                            <span class="input-group-btn">
                                                <button data-toggle="modal" data-target="#diaria_info" class="btn btn-primary" type="button">Detalhes</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
<!--                                FIM VINCULACAO DIARIA-->

                            <div class="campoForneceor">
                                <div class="row">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4">
                                        <div class="panel-body">
                                            <div class="radio">
                                                <label><input type="radio" id="ata" value="1" name="contratado" >Ata<span class="text-danger">*</span>
                                                </label>
                                                <label><input type="radio" id="contrato" value="2" name="contratado" checked>Contrato<span class="text-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4"></div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-4">
                                        <div class="panel-body">
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                <select class="form-control select" name="contratada" id="contratada" required="true">
                                                    <option value="" >Selecione primeiro o tipo de gasto</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4"></div>
                                </div>
                            </div>    

                            <hr/>
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Informações sobre o Recurso</h3>
                            </div>


                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        Fonte:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                            <select class="form-control select" name="fonte" id="fonte" required="true">
                                                <option value="" >Selecione uma fonte</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        Ano:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                            <select class="form-control select" name="ano" id="ano" required="true">
                                                <option value="" >Selecione uma ano</option>
                                                <?php echo Metodos::retornaAnosSelect('0'); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        Programa/Atividade:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                            <select class="form-control select" name="Programa" id="Programa" required="true">
                                                <option value="" >Selecione a fonte e ano</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        Elemento de despesa:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                            <select class="form-control select" name="despesa" id="despesa" required="true">
                                                <option value="" >Selecione um programa/atividade</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        Sub-Elemento:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                            <select class="form-control select" name="subElemento" id="subElemento" required="true">
                                                <option value="" >Selecione um Elemento de despesa</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <hr/>
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Especificação da Solicitação</h3>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        Justificativa:<span class="text-danger">*</span>
                                        <textarea class="form-control" rows="4" id="desc_pedido">descrição do obejeto</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>

                            <div class="row hidden campoValor">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        Valor:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                            <input type="text" name="valor" id="valor" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        <button class="btn btn-success btn-rounded btn-salvar" type="button">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
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
        <!--Select2-->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!--Input valor priceformat-->
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
        <!--MaskedInput-->
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/js/financeiro/necessidade_central/pedido.js"></script>
        <!-- END JAVASCRIPT -->
    </body>
</html>
