<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/compras/gcon/processo/processo.load.php";
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
        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css">
        <!--selec2-->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
        <!-- Datapicker -->
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
                        <h1 class="page-header text-overflow">Gestão de Compras</h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <div id="page-content">
                        <!-- Menu GCON -->
                        <div id="menu_gcon"></div>
                        <!-- Fim_Menu_Gcon --> 

                        <!--Modal upload-->
                        <div class=" modal fade modal-upload" id="upload" 
                             tabindex="-1" role="dialog" 
                             aria-labelledby="mySmallModalLabel"
                             data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Fechar"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Anexo</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/model/compras/gcon/upload/uploadAnexo.php" method="POST" enctype="multipart/form-data" id="form-upload" name="form-upload">
                                            <input type="hidden" name="id_processo" id="id_processo" value="<?php echo $dados['id_processo']; ?>">
                                            <input type="file" name="file" id="file">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default fechar" data-dismiss="modal">Fechar</button>
                                        <input type="submit" class="btn btn-primary btn-enviarUpload" value="Enviar">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Fim Modal Upload-->
                        <!--Modal addAnotacao-->
                        <div class=" modal fade modal-footer" id="adAnotacao"
                             tabindex="-1" role="dialog"
                             aria-labelledby="mySmallModalLabel"
                             data-keyboard="false" data-backdrop="static">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Fechar"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Anotação</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form method="GET" enctype="multipart/form-data" id="form-anotacao" name="form-anotacao">
                                            <input type="hidden" name="id_processo_anotacao" id="id_processo_anotacao" value="<?php echo $dados['id_processo']; ?>">
                                            <textarea class="form-control" rows="5" name="anotacao" id="anotacao"></textarea>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default fechar" data-dismiss="modal">Fechar</button>
                                        <input type="submit" class="btn btn-primary btn-enviarAnotacao" value="Adicionar">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Fim Modal AddAnotacao-->

                        <!-- Inicio do Formulário de Edição de Processos-->
                        <form data-toggle="validator" class="form-horizontal" id="form_process" role="form" action="#"method="post">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Edição de Processo</h3>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <div class="panel-body">ADA/CPR: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                            <input type="text" class="form-control" name="ADA_process" id="ADA_process" value="<?php echo $dados['cd_ada_cpr']; ?>" placeholder="">
                                            <input type="hidden" name="ada_temp" id="ada_temp" value="<?php echo $dados['cd_ada_cpr']; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="panel-body">N° Pregão:
                                            <input type="numberelivel" class="form-control" name="nume_pregao_process" id="nume_pregao_process" min="1" maxlength="20" value="<?php echo $dados['cd_pregao']; ?>">

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="panel-body">Data: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                            <input type="text" class="form-control" name="data_process" id="data_process" placeholder="99/99/9999" data-mask="99/99/9999" value="<?php echo Metodos::ConverteDataBR($dados['dt_processo']); ?>">
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <div class="panel-body">Unidades Contempladas: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                            <input type="hidden" name="id_unidade" id="id_unidade" value="<?php echo $dados['id_unidade_contempladas']; ?>">
                                            <select class="form-control" name="uni_cont_process" id="uni_cont_process">
                                                <option value="0">Selecione uma unidade</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="panel-body">Técnico Responsável: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                            <input type="hidden" name="id_tecnico" id="id_tecnico" value="<?php echo $dados['id_pessoa']; ?>">
                                            <select class="form-control" name="tecnico_process" id="tecnico_process">
                                                <option value="0">Selecione um técnico</option>
                                            </select>
                                        </div>
                                    </div> 

                                    <div class="col-md-4">
                                        <div class="panel-body">Área de Abrangência: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                            <input type="hidden" name="id_area" id="id_area" value="<?php echo $dados['id_cidade']; ?>">
                                            <select class="form-control" name="abrangencia_process" id="abrangencia_process" multiple="">
                                                <option value="0">Selecione uma área</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <div class="panel-body">Objeto:
                                            <input type="hidden" name="id_objeto" id="id_objeto" value="<?php echo $dados['id_objeto']; ?>">
                                            <select class="form-control" name="objeto_process" id="objeto_process">
                                                <option value="0">Selecione um objeto</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="panel-body">Situação de Acompanhamento: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                            <input type="hidden" name="id_situacao" id="id_situacao" value="<?php echo $dados['id_situacao']; ?>">
                                            <select class="form-control" name="sit_acom_process" id="sit_acom_process">
                                                <option value="0">Selecione a situação</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="panel-body">Modalidade:
                                            <input type="hidden" name="id_modalidade" id="id_modalidade" value="<?php echo $dados['id_modalidade']; ?>">
                                            <select class="form-control" name="modalidade_process" id="modalidade_process">
                                                <option value="0">Selecione a modalidade</option>
                                            </select>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <div class="panel-body">Valor Total Estimado:
                                            <input class="form-control" type="text" name="valor_process" id="valor_process" value="<?php echo Metodos::ConverteValorBr($dados['vl_total_est'], 2); ?>" placeholder="1.000.000,00">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="panel-body">Valor Total Homologado:
                                            <input class="form-control" type="text" name="val_homo_process" class="val_homo_process" id="val_homo_process" placeholder="1.000.000,00" value="<?php echo Metodos::ConverteValorBr($dados['vl_total_hom'], 2); ?>">

                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                            </div>

                            <div class="panel">
                                <div id="tipogasto">
<!--                                    <div class="tipoGastoCampos row">
                                        <div class="col-md-4 ">
                                            <div class="panel-body">Tipo de Gasto: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                                <select class="form-control tipoGastoSelect" name="tipoGasto">
                                                    <option value="0" selected>Selecione a categoria</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="panel-body">Valor do Tipo de Gasto: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                                <input class="form-control valorTipoGasto" type="text" name="val_tipo_gasto" id="val_tipo_gasto" placeholder="1.000.000,00">
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <div class="panel-body">
                                            <button  type="button" class="btn btn-primary addTipoGastoValorHomologado">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="centrais">
<!--                                    <div class="centrais row">
                                        <div class="col-md-4">
                                            <div class="panel-body">Centrais de Atendimento: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                                <div class="centraisCampos">
                                                    <select class="form-control selectCentrais" name="centraisAtendimento" required id="centraisAtendimento">
                                                        <option value="0" selected="">Selecione uma central</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <div class="panel-body">
                                            <button  type="button" class="btn btn-primary addCentrais">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-sm-9"></div>
                                </div>
                            </div>
                            <div id="anexos"></div>

                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Anotações
                                        <button  type="button" class="btn btn-primary btn-rounded btn-addAnotacao" title="Adicionar">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </h3>
                                </div>
                                <div class="input_ordens">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="panel-body">
                                                <textarea class="form-control" rows="6" readonly name="anotacoes_process" id="anotacoes_process"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2 text-center">
                                        <button  type="button" class="btn btn-success btn-rounded btn-block btn-editar" title="Editar">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Editar
                                        </button>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <button  type="button" class="btn btn-default btn-rounded btn-block btn-cancelar" title="Editar">
                                            <i class="fa fa-remove" aria-hidden="true"></i> Cancelar
                                        </button>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>    
                        </form>  
                        <!-- Fim do Formulário de Edição de Processos-->
                    </div>
                </div>
            </div>

            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

            <!--MENU LATERAL-->
            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/menuLateral.php";
            ?>
            <!--END MENU LATERAL-->

            <!-- FOOTER -->
            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/rodape.php";
            ?>
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

        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>
        <!--SELECT2-->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <script src="/assets/js/compras/gcon/Processo/editarProcesso.js"></script>
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
        <script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!-- END JAVASCRIPT -->
    </body>
</html>
