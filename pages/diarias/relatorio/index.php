<!DOCTYPE html>
<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . "/model/diarias/relatorio/index.load.php";
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
         <!-- select2 -->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
                 <!--Datapicker-->
        <link href="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
    </head>
    
    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-lg">

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
                        <h1 class="page-header text-overflow">Relatório de Viagem </h1>                       
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="../">Voltar</a></li>                        
                    </ol>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <?php 
                            require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/diarias/shared/modalPesqCidade.html";
                            require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/diarias/shared/modalAnexaArquivo.html";
                        ?>
                        <form>
                            <input type="hidden" id="id_diaria" value="<?php echo $id_diaria; ?>">
                            <input type="hidden" id="id_relatorio" value="<?php echo $id_relatorio; ?>"/>
                            <div class="panel">
                                <div class="panel-heading text-center">
                                    <h3 class="panel-title">Informações do proposto</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
<!--                                        <div class="col-md-2">-->
                                            <strong>Nome do Servidor: </strong><?php echo $dadosProposto['nm_proposto']; ?> <br>
                                            <strong>Cargo,Função ou Emprego: </strong> <?php echo $dadosProposto['nm_funcao_proposto']; ?> <br>
                                            <strong>Órgão/Setor de Lotação: </strong> <?php echo $dadosProposto['nm_lotacao_proposto']; ?>
<!--                                        </div>-->
<!--                                        <div class="col-md-10 pull-left">-->
<!--                                        </div>-->
                                    </div>
                                    <br/>
                                    <div class="form-group">
                                        <label for="ds_servico_executado">Descrição detalhada do(s) serviço(s) executado(s): <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <textarea id="ds_servico_executado" class="form-control"><?php echo $ds_servico_executado; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ds_locais_executado">Local(is) de realização do(s) serviços: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <textarea id="ds_locais_executado" class="form-control"><?php echo $ds_locais_executado; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="fl_retorno">Teve Retorno ao Município SEDE?</label>
                                        <div class="input-group">
                                            <input style="width: 25px; height: 25px;"  type="checkbox" id="fl_retorno" <?php echo $fl_retorno; ?>/> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="dt_relatorio_destino">Data do relatório: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-calendar inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="dt_relatorio_destino" id="dt_relatorio_destino" value="<?php echo $dt_relatorio_destino; ?>" required="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel" id="formDestino">
                                <div class="panel-heading  text-center">
                                    <h3 class="panel-title" id="viagem">Período do Afastamento</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="hidden" id="id_relatorio_destino" value="<?php echo $id_diaria_destino; ?>" />
                                            <div class="form-group">
                                                <label for="id_cidade_inicio">Cidade de origem: <span class="text-danger">*</span></label>
                                                <input type="hidden" id="id_cidade_inicio" disabled value="<?php echo $id_cidade_inicio; ?>">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" id="ds_cidade_inicio" disabled value="<?php echo $origem;?>" />
                                                    <span class="input-group-btn abre-ModalCidade" data-target="#pesquisaCidade" data-toggle="modal" data-id="origem">
                                                        <button type="button" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_cidade_fim">Cidade de destino: <span class="text-danger">*</span></label>
                                                <input type="hidden" id="id_cidade_fim" disabled value="<?php echo $id_cidade_fim; ?>">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" id="ds_cidade_fim" disabled value="<?php echo $destino;?>"/>
                                                    <span class="input-group-btn abre-ModalCidade" data-target="#pesquisaCidade" data-toggle="modal" data-id="destino">
                                                        <button type="button" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dh_inicio">Horário da partida: <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-calendar inputPFa"></p>
                                                    </span>
                                                    <input type="text" class="form-control" name="dh_inicio" id="dh_inicio" required="true" value="<?php echo $dh_inicio ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dh_fim">Horário da chegada: <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-calendar inputPFa"></p>
                                                    </span>
                                                    <input type="text" class="form-control" name="dh_fim" id="dh_fim" required="true" value="<?php echo $dh_fim ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_transporte">Meio de locomoção: <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-list inputPFa"></p>
                                                    </span>
                                                    <select id="id_transporte" class="form-control">
                                                        <?php
                                                            echo $selectTransporteOption;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="hidden" id="id_transporte_tipo_default" />
                                                <label for="id_transporte_tipo">Transporte: <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-list inputPFa"></p>
                                                    </span>
                                                    <select id="id_transporte_tipo" class="form-control">
                                                        <?php
                                                            echo $selectTransporteTipoOption;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                    </span>
                                                    <input type="text" id="ds_transporte_tipo" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-rounded btn-default mar-ver pull-right btn-limpar">
                                        Limpar
                                    </button>   
                                    <button class="btn btn-rounded btn-default mar-ver pull-right btn-cancelar">
                                        Cancelar
                                    </button>
                                    <button class="btn btn-rounded btn-primary mar-ver pull-right add-destino">
                                        <i class="fa fa-plus-circle fa-1x" style="margin-right: 5px"></i>
                                        Itinerário
                                    </button>
                                    <button class="btn btn-rounded btn-info mar-ver pull-right btn-editar">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar Edição
                                    </button>
                                </div>
                                <div class="panel-footer">
                                    <table class="table table-striped" id="destinos">
                                        <thead>
                                            <tr>
                                                <th>Origem</th>
                                                <th>Destino</th>
                                                <th>Horário da Partida</th>
                                                <th>Horário de Chegada</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php echo $linhasDestinos; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="panel">
                                <div class="panel-heading  text-center">
                                    <h3 class="panel-title">Arquivos anexados</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <strong>Arquivo:</strong>
                                        <button class="btn btn-rounded btn-primary btn-add-arquivo" data-target="#anexaArquivo" data-toggle="modal"" type="button">
                                            <i class="fa fa-plus"></i> Adicionar
                                        </button>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div id="arquivos">
                                            <?php echo $linhasAnexos; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel" id="relViagem">
                                <div class="panel-heading text-center">
                                    <h3 class="panel-title">Relatório de Viagem</h3>
                                </div>
                                <div class="panel-body">
                                    <a href="imprimir.php?id=<?php echo $id_relatorio;?>" target="_blank">Anexo III - PDF</a>
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success btn-rounded btn-salvar" type="button">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                </button>
                                <a href="../" class="btn btn-rounded btn-default">Cancelar</a>
                            </div>
                        </form>
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
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> 
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>     
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <script src="/assets/js/diarias/relatorio/index.js"></script>
        <script src="/assets/js/diarias/anexo.js"></script>
        <script src="/assets/js/diarias/pesqCidade.js"></script>
         <!-- select2 -->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!--Datapicker-->
        <script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        
        <!-- END JAVASCRIPT -->
    </body>
</html>
