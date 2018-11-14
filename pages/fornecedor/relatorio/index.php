<!DOCTYPE html>

<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/fornecedor/relatorio/index.load.php";
?>

<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Cadastro de Fornecedores</title>
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
        <!--selec2-->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
        <!--DataTables [ OPT ]-->
        <link href="/assets/lib/template/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.bootstrap.min.css" rel="stylesheet">
        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css">
        <!--Datapicker-->
        <link href="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
        <style>
            li.active {
                background:#EEEEEE;  
            }
            .cep {
                white-space: pre-line;
                /*margin: 28px ;*/
            }
            .adicionar {
                margin: 15px;
                margin-left: 0;
            }

        </style>
    </head>
    <!--TIPS-->

    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-sm">

            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php";
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/modalAlert.html";
            ?>

            <div class="boxed">
                <div id="content-container">
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Relatório de Fornecedoress</h1>
                    </div>
                    <div id="page-content">
                        <form data-toggle="validator" class="form-horizontal" id="form_fornecedor" role="form" action="#"method="post">
                            <div class="panel">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <div class="panel-body">Tipo de Pessoa: <span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-list inputPFa"></p>
                                                </span>
                                                <select id="id_tipo_fornecedor" class="form-control selectTipoPessoa">
                                                    <option value="0">Selecione o Tipo de Pessoa</option>
                                                    <option value="1">Pessoa Física</option>
                                                    <option value="2">Pessoa Jurídica</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 juridica">
                                        <div class="panel-body">Razão Social:
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="rz_social" id="rz_social" required="true">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 fisica">
                                        <div class="panel-body">Nome da Pessoa:
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="nm_pessoa" id="nm_pessoa" required="true">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 fisica">
                                        <div class="panel-body">CPF:
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="nr_cpf" id="nr_cpf" required="true" placeholder="___.___.___-__">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 juridica">
                                        <div class="panel-body">CNPJ:
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="nr_cnpj" id="nr_cnpj" required="true"  placeholder="__.___.___/____-__">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="panel-body">Medicamentos:
                                            <div class="medicamentosCampos">
                                                <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                    <select id="id_medicamentos" class="form-control select selectMedicamentos" title="Selecione o tipo de Medicamento" multiple name="medicamento[]">
                                                        <!--                                                        <option value="0">Selecione o tipo de Medicamento</option>-->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="panel-body">Serviços:
                                            <div class="servicoCampos">
                                                <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                    <select id="id_servicos" class="form-control select selectServico" multiple title="Selecione o tipo de Serviço" name="servico[]">
                                                        <!--                                                        <option value="0">Selecione o tipo de Serviço</option>-->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="panel-body">Material de Consumo:
                                            <div class="consumoCampos">
                                                <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                    <select id="id_material_consumo" class="form-control select selectConsumo" multiple title="Selecione o tipo de Material de Consumo" name="materialConsumo[]">
                                                        <!--                                                        <option value="0">Selecione o tipo de Material de Consumo</option>-->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="panel-body">Material Permanente:
                                            <div class="permanenteCampos">
                                                <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                    <select id="id_material_permanente" class="form-control select selectPermanente" multiple title="Selecione o tipo de material permanente" name="materialPermanente[]">
                                                        <!--                                                        <option value="0">Selecione o tipo material permanente</option>-->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <hr>
                                    <div class="col-sm-5"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary btn-rounded btn-pesquisar btn-block" type="button">
                                            <i class="fa fa-print" aria-hidden="true"></i> Gerar
                                        </button>
                                    </div>
                                    <br><br>
                                    <div class="col-sm-4"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--===================================================-->
                <!--END CONTENT CONTAINER-->

                <!--MENU LATERAL-->
                <?php
                require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/menuLateral.php";
                ?>
                <!--END MENU LATERAL-->
            </div>
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
        <!--jQuery [ REQUIRED ]-->
        <script src="/assets/lib/template/js/jquery-2.2.4.min.js"></script>
        <!--BootstrapJS [ REQUIRED ]-->
        <script src="/assets/lib/template/js/bootstrap.min.js"></script>
        <!--NiftyJS [ REQUIRED ]-->
        <script src="/assets/lib/template/js/nifty.min.js"></script>
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>     
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="index.js"></script>
        <!--SELECT2-->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!--Datapicker-->
        <script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!--MaskedInput-->
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!-- select2 -->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!-- END JAVASCRIPT -->
    </body>
</html>
