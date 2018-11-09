<!DOCTYPE html>

<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/fornecedor/cadFornecedor/index.load.php";
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
            <div id="page-title">
                <h1 class="page-header text-overflow">Cadastro de Fornecedores</h1>
            </div>

            <?php
                //Modal Alert
                require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/modalAlert.html";
            ?>

            <div class="boxed">
                <div id="page-content"><br>
                    <form data-toggle="validator" class="form-horizontal" id="form_fornecedor" role="form" action="#"method="post">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Formulário</h3>
                            </div>
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
                                    <div class="panel-body">Razão Social:  <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="rz_social" id="rz_social" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4 juridica">
                                    <div class="panel-body">Nome Fantasia: <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="nm_fantasia" id="nm_fantasia" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4 fisica">
                                    <div class="panel-body">Nome da Pessoa: <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="nm_pessoa" id="nm_pessoa" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2 fisica">
                                    <div class="panel-body">CPF: <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="nr_cpf" id="nr_cpf" required="true" placeholder="___.___.___-__">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2 fisica">
                                    <div class="panel-body">Sexo: <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-list inputPFa"></p>
                                            </span>
                                            <select id="tp_sexo" class="form-control select">
                                                <option value="0">Selecione o Sexo</option>
                                                <option value="1">Feminino</option>
                                                <option value="2">Masculino</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group juridica">
                                <div class="col-sm-3">
                                    <div class="panel-body">CNPJ: <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="nr_cnpj" id="nr_cnpj" required="true"  placeholder="__.___.___/____-__">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="panel-body">Inscrição Estadual:
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="nr_estadual" id="nr_estadual" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="panel-body">Inscrição Municipal:
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="nr_municipal" id="nr_municipal" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="panel-body">Natureza: <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <select id="id_natureza" class="form-control select">
                                                <option value="0">Selecione a Natureza</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group resto">
                                <div class="col-sm-4">
                                    <div class="panel-body">País: <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-list inputPFa"></p>
                                            </span>
                                            <select id="id_pais" class="form-control select">
                                                <option value="0">Selecione um País</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="panel-body">Estado: <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-list inputPFa"></p>
                                            </span>
                                            <select id="id_estado" class="form-control select">
                                                <option value="0">Selecione um Estado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="panel-body">Cidade: <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-list inputPFa"></p>
                                            </span>
                                            <select id="id_cidade" class="form-control select">
                                                <option value="0">Selecione uma Cidade</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group resto">
                                <div class="col-sm-4">
                                    <div class="panel-body">Logradouro: <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="logradouro" id="ds_logradouro" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="panel-body">Bairro: </strong><span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="bairro" id="ds_bairro" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel-body">CEP: <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="nr_cep" id="nr_cep" placeholder="_____-___">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-1">
                                    <div class="panel-group cep">
                                        <button class="btn btn-info btn-rounded" type="button">
                                            <i class="fa fa-search" aria-hidden="true"></i> CEP
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group resto">
                                <div class="col-sm-4 juridica">
                                    <div class="panel-body">Telefone da Empresa: <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="telefone" id="nr_telefone_empresa" required="true" placeholder="(   )______-_____">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4 fisica">
                                    <div class="panel-body">Telefone Celular: <span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="telefone" id="nr_telefone_celular" required="true" placeholder="(   ) _ ____-____">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="panel-body">Telefone Residêncial:
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="telefone" id="nr_telefone_residencial" required="true" placeholder="(   ) ____-____">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="panel-body">E-mail:
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="email" class="form-control" name="email" id="nm_email" required="true" placeholder="Ex.: sesacre@ac.gov.com">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group resto">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-5">
                                    <label>A Empresa é Distribuidora? <span class="text-danger">*</span></label>
                                    <input type="checkbox" name="emp_dist" id="empDistS" value="1"> Sim
                                    <input type="checkbox" name="emp_dist" id="empDistN" value="0"> Não
                                </div>
                                <div class="col-sm-5">
                                    <label>A Empresa possui Exclusividade? <span class="text-danger">*</span></label>
                                    <input type="checkbox" name="emp_exc[]" id="empExcS" value="1"> Sim
                                    <input type="checkbox" name="emp_exc[]" id="empExcN" value="0"> Não
                                </div>
                            </div>

                            <div class="form-group resto">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Tipos de Produtos ou Serviços que a Empresa Fornece</h5>
                                </div>
                            </div>

                            <div class="medicamentos">
                                <div class="form-group resto">
                                    <div class="col-sm-5">
                                        <div class="panel-body">Medicamentos: <span class="text-danger">*</span>
                                            <div class="medicamentosCampos">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-list inputPFa"></p>
                                                    </span>
                                                    <select id="id_medicamentos" class="form-control select selectMedicamentos" name="medicamento[]">
                                                        <option value="0">Selecione o tipo de Medicamento</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-7"></div>
                                </div>
                            </div>
                            <div class="form-group resto">
                                <div class="col-sm-3">
                                    <div class="panel-body">
                                        <button  type="button" class="btn btn-primary adicionar addMedicamentos">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="servicos">
                                <div class="form-group resto">
                                    <div class="col-sm-5">
                                        <div class="panel-body">Serviços: <span class="text-danger">*</span>
                                            <div class="servicoCampos">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-list inputPFa"></p>
                                                    </span>
                                                    <select id="id_servicos" class="form-control select selectServico" name="servico[]">
                                                        <option value="0">Selecione o tipo de Serviço</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-7"></div>
                                </div>
                            </div>
                            <div class="form-group resto">
                                <div class="col-sm-3">
                                    <div class="panel-body">
                                        <button  type="button" class="btn btn-primary adicionar addServico">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="consumo">
                                <div class="form-group resto">
                                    <div class="col-sm-5">
                                        <div class="panel-body">Material de Consumo: <span class="text-danger">*</span>
                                            <div class="consumoCampos">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-list inputPFa"></p>
                                                    </span>
                                                    <select id="id_material_consumo" class="form-control select selectConsumo" name="materialConsumo[]">
                                                        <option value="0">Selecione o tipo de Material de Consumo</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-7"></div>
                                </div>
                            </div>
                            <div class="form-group resto">
                                <div class="col-sm-3">
                                    <div class="panel-body">
                                        <button  type="button" class="btn btn-primary adicionar addConsumo">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="permanente">
                                <div class="form-group resto">
                                    <div class="col-sm-5">
                                        <div class="panel-body">Material Permanente: <span class="text-danger">*</span>
                                            <div class="permanenteCampos">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-list inputPFa"></p>
                                                    </span>
                                                    <select id="id_material_permanente" class="form-control select selectPermanente" name="materialPermanente[]">
                                                        <option value="0">Selecione o tipo material permanente</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-7"></div>
                                </div>
                            </div>
                            <div class="form-group resto">
                                <div class="col-sm-3">
                                    <div class="panel-body">
                                        <button  type="button" class="btn btn-primary adicionar addPermanente">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <hr>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-2">
                                    <button class="btn btn-default btn-rounded btn-limpar btn-block" type="button">
                                         Limpar
                                    </button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-success btn-rounded btn-salvar btn-block" type="button">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                    </button>
                                </div>
                                <br><br><br>
                                <div class="col-sm-4"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <footer id="footer">
                <p class="pad-lft">&#0169; Secretaria Estadual de Saúde do Acre - SESACRE || Em caso de dúvidas. Ligar 3215-2711 / 3215-2759</p>
            </footer>
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
