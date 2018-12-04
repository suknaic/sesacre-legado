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
        <!--checkbox-circle-primary -->
        <link href="/assets/lib/template/plugins/checkbox/checkbox-circle-pimary.css" rel="stylesheet">
        <style>
            li.active {
                background:#EEEEEE;  
            }
            .cep {
                white-space: pre-line;
                margin: 14px ;
            }
            .adicionar {
                margin: 32px;
                margin-left: 0;
            }
            .remover {
                margin: 19px;
                margin-left: 0;
            }
        </style>
    </head>
    <!--TIPS-->

    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-sm">

            <?php
            //Modal Alert
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/modalAlert.html";
            ?>

            <div class="boxed">
                <div id="page-title">
                    <h1 class="page-header text-overflow">Cadastro de Fornecedor</h1>
                </div>
                <div id="page-content">
                    <div class="row">
                        <div class="col-sm-12 eq-box-md eq-no-panel">
                            <div class="panel">
                                <div id="demo-bv-wz">
                                    <div class="wz-heading pad-top">
                                        <ul class="nav row wz-nav-off  wz-icon-bw mar-top wz-steps wz-step">
                                            <li class="col-xs-2 bv-tab-success active">
                                                <a data-toggle="tab" href="#tab1" class="add-tooltip" data-original-title="Tipo de Pessoa" aria-expanded="true">
                                                    <span class="text-danger">
                                                        <i class="wz-icon fa fa-user fa-2x"></i>
                                                        <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="col-xs-2">
                                                <a data-toggle="tab" href="#tab2" class="add-tooltip" data-original-title="Dados Cadastrais" aria-expanded="false">
                                                    <div class="text-warning">
                                                        <i class="wz-icon fa fa-file-text fa-2x"></i>
                                                        <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="col-xs-2">
                                                <a data-toggle="tab" href="#tab3" class="add-tooltip" data-original-title="Endereço" aria-expanded="false">
                                                    <div class="text-info">
                                                        <i class="wz-icon fa fa-home fa-2x"></i>
                                                        <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                    </div>
                                                </a>
                                            </li>

                                            <li class="col-xs-2">
                                                <a data-toggle="tab" href="#tab4" class="add-tooltip" data-original-title="Contato" aria-expanded="false">
                                                    <div class="text-success">
                                                        <i class="wz-icon fa fa-phone fa-2x"></i>
                                                        <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                    </div>
                                                </a>
                                            </li>

                                            <li class="col-xs-2">
                                                <a data-toggle="tab" href="#tab5" class="add-tooltip" data-original-title="Informações da Empresa" aria-expanded="false">
                                                    <div class="text-purple">
                                                        <i class="wz-icon fa fa-list-alt fa-2x"></i>
                                                        <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                    </div>
                                                </a>
                                            </li>

                                            <li class="col-xs-2">
                                                <a data-toggle="tab" href="#tab6" class="add-tooltip" data-original-title="Objeto Social" aria-expanded="false">
                                                    <div class="text-dark">
                                                        <i class="wz-icon fa fa-list-ul fa-2x"></i>
                                                        <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="progress progress-xs">
<!--                                        <div class="progress-bar progress-bar-primary" style="width: 20%; left: 0%; position: relative; transition: all 0.5s;"></div>-->
                                    </div>

                                    <form id="demo-bv-wz-form" class="form-horizontal bv-form formFornecedores" novalidate="novalidate">
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                <div id="tab1" class="tab-pane active">
                                                    <div class="form-group">
                                                        <div class="col-lg-4"></div>
                                                        <div class="col-lg-4">
                                                            Tipo de Pessoa: <span class="text-danger">*</span>
                                                            <select class="form-control" id="id_tipo_fornecedor" name="id_tipo_fornecedor">
                                                                <option value="0">Selecione Tipo de Pessoa</option>
                                                                <option value="1">Pessoa Física</option>
                                                                <option value="2">Pessoa Jurídica</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="tab2" class="tab-pane">
                                                    <div class="form-group">
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

                                                        <div class="col-sm-4 juridica">
                                                            <div class="panel-body">CNPJ: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nr_cnpj" id="nr_cnpj" required="true"  placeholder="__.___.___/____-__">
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

                                                        <div class="col-sm-4 fisica">
                                                            <div class="panel-body">CPF: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nr_cpf" id="nr_cpf" required="true" placeholder="___.___.___-__">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4 fisica">
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
                                                        <div class="col-sm-4">
                                                            <div class="panel-body">Inscrição Estadual:
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nr_estadual" id="nr_estadual" required="true">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="panel-body">Inscrição Municipal:
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nr_municipal" id="nr_municipal" required="true">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="tab3" class="tab-pane">
                                                    <div class="form-group resto">
                                                        <div class="col-sm-4">
                                                            <div class="panel-body">País: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_pais" class="form-control select">
                                                                        <option value="0">Selecione o País</option>
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
                                                                        <option value="0">Selecione o Estado</option>
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
                                                                        <option value="0">Selecione a Cidade</option>
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
                                                            <div class="panel-body">CEP:
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
                                                                <button class="btn btn-primary btn-rounded" type="button">
                                                                    <i class="fa fa-search" aria-hidden="true"></i> CEP
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group resto">
                                                        <div class="col-sm-4">
                                                            <div class="panel-body">Complemento:
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="complemento" id="ds_complemento" required="true">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <div class="panel-body">Número: </strong><span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="number" class="form-control" name="numero" id="nr_numero" min="0" required="true">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="tab4" class="tab-pane">
                                                    <div class="form-group resto">
                                                        <div class="col-sm-4 juridica">
                                                            <div class="panel-body">Telefone da Empresa: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="telefone" id="nr_telefone_empresa" required="true" placeholder="(__) _ ____-____">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4 fisica">
                                                            <div class="panel-body">Telefone Celular: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="telefone" id="nr_telefone_celular" required="true" placeholder="(__) _ ____-____">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="panel-body">Telefone Comercial:
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="telefone" id="nr_telefone_residencial" required="true" placeholder="(__) ____-____">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="panel-body">E-mail: </strong><span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="email" class="form-control" name="email" id="nm_email" required="true" placeholder="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="tab5" class="tab-pane">
                                                    <div class="form-group resto">
                                                        <div class="col-sm-2"></div>
                                                        <div class="col-sm-5">
                                                            <label for="dist">A Empresa é Distribuidora? <span class="text-danger">*</span></label>
                                                            <div class="checkbox checkbox-info checkbox-circle" id="dist">
                                                                <input type="checkbox" name="emp_dist" id="empDistS" value="1"><label for="empDistS"> Sim</label>
                                                            </div>
                                                            <div class="checkbox checkbox-info checkbox-circle" id="dist">
                                                                <input type="checkbox" name="emp_dist" id="empDistN" value="0"><label for="empDistN"> Não</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <label for="empExcS">A Empresa possui Exclusividade? <span class="text-danger">*</span></label>
                                                            <div class="checkbox checkbox-info checkbox-circle" id="dist">
                                                                <input type="checkbox" name="emp_exc" id="empExcS" value="1"><label for="empExcS"> Sim</label>
                                                            </div>
                                                            <div class="checkbox checkbox-info checkbox-circle" id="dist">
                                                                <input type="checkbox" name="emp_exc" id="empExcN" value="0"><label for="empExcN"> Não</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group resto">
                                                        <div class="col-sm-2"></div>
                                                        <div class="col-sm-4 empDist">
                                                            <div class="panel-body" style="margin-left: -20px;">Nome da empresa que presta serviço: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="ds_emp_dist[]" id="ds_emp_dist" required="true" placeholder="Nome da Empresa">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1 empDist">
                                                            <button class="btn btn-primary adicionar">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="panel-body juridica" style="margin-left: -20px;">Natureza: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                                        </span>
                                                                    <select class="form-control" id="id_natureza" name="id_natureza">
                                                                        <option value="0">Selecione a natureza</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group resto empresas">

                                                    </div>
                                                </div>
                                                <div id="tab6" class="tab-pane">
                                                    <div class="form-group resto">
                                                        <div class="panel-heading text-center">
                                                            <h3 class="panel-title">Tipos de Produtos ou Serviços que a Empresa Fornece</h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group resto">
                                                        <div class="col-sm-2"></div>
                                                        <div class="col-sm-4">
                                                            <div class="panel-body">
                                                                <div class="panel-heading text-left">
                                                                    <h4 class="panel-title">Medicamentos: </h4>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_medicamentos" class="form-control select" multiple name="medicamento">
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="panel-body">
                                                                <div class="panel-heading text-left">
                                                                    <h4 class="panel-title">Serviços: </h4>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_servicos" class="form-control select" multiple name="servico">

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group resto">
                                                        <div class="col-sm-2"></div>
                                                        <div class="col-sm-4">
                                                            <div class="panel-body">
                                                                <div class="panel-heading text-left">
                                                                    <h4 class="panel-title">Material de Consumo: </h4>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_material_consumo" class="form-control select" multiple name="materialConsumo">

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="panel-body">
                                                                <div class="panel-heading text-left">
                                                                    <h4 class="panel-title">Material Permanente: </h4>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_material_permanente" class="form-control" multiple name="materialPermanente">

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><br>
                                            <div class="text-center">
                                                <button type="button" class="btn btn-primary btn-rounded anterior">
                                                    <i class="fa fa-backward" aria-hidden="true"></i> Anterior
                                                </button>
                                                <button type="button" class="btn btn-primary btn-rounded proximo">
                                                    Próximo <i class="fa fa-forward" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="panel-footer text-right">
                                            <button type="button" class="btn btn-default btn-default btn-rounded btn-limpar">
                                                Limpar
                                            </button>
                                            <button class="btn btn-success btn-rounded btn-salvar" type="button">
                                                <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--===================================================-->
                        <!--End Horizontal Form-->
                    </div>
                </div>
            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

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
