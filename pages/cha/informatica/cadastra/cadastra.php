<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/cha/informatica/chamado/index.load.php";
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
        <link href="/assets/lib/template/plugins/checkbox/checkbox-circle-pimary.css" rel="stylesheet">

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
                        <h1 class="page-header text-overflow">Cadastro de Chamado</h1>
                        <p class="pad-btn text-sm">Preeencha todos os campos obrigatórios para que seu chamado seja realizado sem nenhuma complicação e seja concluído o mais breve possível.</p>
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <?php
                        require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/cha/informatica/cadastra/_modalAnexaArquivo.html";
                        ?>
                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12 eq-box-md eq-no-panel">

                                <div class="panel">
                                    <div id="demo-bv-wz">
                                        <div class="wz-heading pad-top">
                                            <ul class="row wz-nav-off  wz-icon-bw mar-top wz-steps wz-step">
                                                <li class="col-xs-3 bv-tab-success active">
                                                    <a data-toggle="tab" href="#demo-bv-tab1" title class="add-tooltip" data-original-title="Identificação do Solicitante" aria-expanded="true">
                                                        <span class="text-danger">
                                                            <i class="wz-icon fa fa-user fa-2x"></i>
                                                            <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="col-xs-2">
                                                    <a data-toggle="tab" href="#demo-bv-tab2" title class="add-tooltip" data-original-title="Especificação do Chamado" aria-expanded="false">
                                                        <div class="text-warning">
                                                            <i class="wz-icon fa fa-phone fa-2x"></i>
                                                            <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="col-xs-2">
                                                    <a data-toggle="tab" href="#demo-bv-tab3" title class="add-tooltip" data-original-title="Formulário" aria-expanded="false">
                                                        <div class="text-info">
                                                            <i class="wz-icon fa fa-wpforms fa-2x"></i>
                                                            <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="col-xs-2">
                                                    <a data-toggle="tab" href="#demo-bv-tabAnexo" title class="add-tooltip" data-original-title="Anexos" aria-expanded="false">
                                                        <div class="text-purple">
                                                            <i class="wz-icon fa fa-cloud-upload fa-2x"></i>
                                                            <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="col-xs-3">
                                                    <a data-toggle="tab" href="#demo-bv-tab4" title class="add-tooltip" data-original-title="Finalização" aria-expanded="false">
                                                        <div class="text-success">
                                                            <i class="wz-icon fa fa-flag-checkered fa-2x"></i>
                                                            <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="progress progress-xs">
                                            <div class="progress-bar progress-bar-primary" style="width: 20%; left: 0%; position: relative; transition: all 0.5s;"></div>
                                        </div>
                                        <form id="demo-bv-wz-form" class="form-horizontal bv-form" novalidate="novalidate">

                                            <input type="hidden" id="idCategoriaPrincipal" name="idCategoriaPrincipal" value="<?php echo $id; ?>">

                                            <button type="submit" class="bv-hidden-submit" style="display: none; width: 0px; height: 0px;" disabled="disabled"></button>
                                            <div class="panel-body">
                                                <div class="tab-content">

                                                    <div id="demo-bv-tab1" class="tab-pane active in">
                                                        <div class="form-group has-feedback">
                                                            <label class="col-lg-3 control-label">Nome <span class="text-danger">*</span></label>
                                                            <div class="col-lg-7">
                                                                <input type="text" class="form-control nmPessoa" name="nm_usuario" id="nm_usuario"  data-bv-field="Nome" style="background: #FFF" disabled>
                                                                <i class="form-control-feedback" data-bv-icon-for="nome" style="display: none;"></i>
                                                                <small class="help-block" data-bv-validator="notEmpty" data-bv-for="nome" data-bv-result="INVÁLIDO" style="display:none;">É obrigatório peencher o nome do usuário</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group has-feedback">
                                                            <label class="col-lg-3 control-label">Contato: <span class="text-danger">*</span></label>
                                                            <div class="col-lg-7">
                                                                <input type="text" class="form-control" name="nrTelefoneSolicitante" id="nrTelefoneSolicitante"  placeholder="(    ) _ ____-____"  data-bv-field="telefone" required>
                                                                <i class="form-control-feedback" data-bv-icon-for="telefone" style="display: none;"></i>
                                                                <small class="help-block" data-bv-validator="notEmpty" data-bv-for="telefone" data-bv-result="INVÁLIDO" style="display:none;">O telefone para contato é obrigatório</small>
                                                                <small class="help-block" data-bv-validator="digits" data-bv-for="telefone" data-bv-result="INVÁLIDO" style="display:none;">Este campo só pode conter números</small>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">Lotação: <span class="text-danger">*</span></label>
                                                            <div class="col-lg-7">
                                                                <select class="form-control Lotacao" id="id_lotacao" name="id_lotacao">
                                                                    <option value="0">Selecione Lotação</option>
                                                                    <?php
                                                                    // echo $lotacoes;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="demo-bv-tab2" class="tab-pane fade">
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">Tipo: <span class="text-danger">*</span></label>
                                                            <div class="col-lg-7">
                                                                <select id="idCategoriaTipo" class="form-control tipo">
                                                                    <option value="0">Selecione a Categoria Tipo</option>
                                                                    <?php
                                                                    // echo $lotacoes;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">Primária: <span class="text-danger">*</span></label>
                                                            <div class="col-lg-7">
                                                                <select id="idCategoriaPrimaria" class="form-control primaria">
                                                                    <option value="0">Selecione a Categoria Primária</option>
                                                                    <?php
                                                                    // echo $lotacoes;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-lg-3 control-label">Secundária: <span class="text-danger">*</span></label>
                                                            <div class="col-lg-7">
                                                                <select id="idCategoriaSecundaria" class="form-control secundaria">
                                                                    <option value="0">Selecione a Categoria Secundária</option>
                                                                    <?php
                                                                    // echo $lotacoes;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="demo-bv-tab3" class="tab-pane camposformulario">

                                                    </div>

                                                    <div id="demo-bv-tabAnexo" class="tab-pane anexos">
                                                        <div class="row text-center">
                                                            <strong>Arquivo:</strong>
                                                            <!--                                                            <button class="col-md-4 btn-add-arquivo" data-target="#anexaArquivo" data-toggle="modal" type="button" style="border: dashed; margin-left: 33%; background-color: #FFF">
                                                                                                                            <form id="demo-dropzone" action="#" class="dropzone dz-clickable">
                                                                                                                                <div class="dz-default dz-message">
                                                                                                                                    <div class="dz-icon">
                                                                                                                                        <i class="fa fa-cloud-upload fa-5x"></i>
                                                                                                                                    </div>
                                                                                                                                    <div>
                                                                                                                                        <span class="dz-text">ANEXAR ARQUIVOS</span>
                                                                                                                                        <p class="text-sm text-muted">Clique para fazer upload de arquivos</p>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </form>
                                                                                                                        </button>-->
                                                            <button class="btn btn-primary btn-add-arquivo" data-target="#anexaArquivo" data-toggle="modal" type="button">
                                                                <i class="fa fa-plus"></i> Adicionar
                                                            </button>
                                                        </div>
                                                        <br>

                                                        <div id="arquivos">

                                                        </div>

                                                    </div>

                                                    <div id="demo-bv-tab4" class="tab-pane mar-btm text-center">
                                                        <h4>Obrigado</h4>
                                                        <p>Clique em Salvar e seu chamado será computado e analizado. </br> Logo mais ele será passado para o técnico responsável para que ele seja resolvido o mais breve possível.</br> Acompanhe seu chamado para ficar atualizado de todas as ações que estão sendo realizadas.</p>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="box-inline">
                                                        <button type="button" class="previous btn btn-primary btn-rounded disabled" style="padding-left: 30px; padding-right: 30px">Anterior</button>
                                                        <button type="button" class="next btn btn-primary btn-rounded" style="padding-left: 30px; padding-right: 30px">Próximo</button>
                                                        <button type="button" class="finish btn btn-success btn-rounded btn-salvar" style="padding-left: 35px; padding-right: 35px"  >Salvar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>




                            <!--===================================================-->
                            <!--End Horizontal Form-->
                        </div>
                    </div>
                    <!-- Fim Form -->
                </div>
                <!--===================================================-->
                <!--End page content-->
            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

            <!--MENU LATERAL-->
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/menuLateral.php"; ?>
            <!--END MENU LATERAL-->
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
        <script src="/assets/js/cha/informatica/chamado/chamado.js"></script>
        <!--Datapicker-->
        <script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!--MaskedInput-->
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!-- select2 -->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!-- END JAVASCRIPT -->

    </body>
</html>
