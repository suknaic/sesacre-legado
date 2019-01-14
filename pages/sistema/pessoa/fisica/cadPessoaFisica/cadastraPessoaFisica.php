<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/sistema/pessoa/index.load.php";
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
        <style>
            li.active {
                background:#EEEEEE;  
            } 
        </style>
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
                        <h1 class="page-header text-overflow">Cadastro de Pessoa Física</h1>
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="panel">
                                    <div id="demo-bv-wz">
                                        <div class="wz-heading pad-top">
                                            <ul class="nav row wz-nav-off  wz-icon-bw mar-top wz-steps wz-step">
                                                <li class="col-xs-4 bv-tab-success active">
                                                    <a data-toggle="tab" href="#demo-bv-tab1" title class="add-tooltip" data-original-title="Email da Pessoa Física" aria-expanded="true">
                                                        <span class="text-danger">
                                                            <i class="wz-icon fa fa-at fa-2x"></i>
                                                            <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="col-xs-4">
                                                    <a data-toggle="tab" href="#demo-bv-tab2" title class="add-tooltip" data-original-title="Dados Pessoais" aria-expanded="false">
                                                        <div class="text-warning">
                                                            <i class="wz-icon fa fa-user fa-2x"></i>
                                                            <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li class="col-xs-4">
                                                    <a data-toggle="tab" href="#demo-bv-tab3" title class="add-tooltip" data-original-title="Endereço e Contato" aria-expanded="false">
                                                        <div class="text-info">
                                                            <i class="wz-icon fa fa-phone fa-2x"></i>
                                                            <i class="wz-icon-done fa fa-thumbs-o-up fa-2x"></i>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="progress progress-xs">
                                            <div id="progresso" class="progress-bar progress-bar-primary" style="width: 33.33%; left: 0%; position: relative; transition: all 0.5s;"></div>
                                        </div>
                                        <form id="demo-bv-wz-form" class="form-horizontal bv-form formRhFuncionario" novalidate="novalidate">

                                            <input type="hidden" id="idCategoriaPrincipal" name="idCategoriaPrincipal" value="<?php echo $id; ?>">

                                            <button type="submit" class="bv-hidden-submit" style="display: none; width: 0px; height: 0px;" disabled="disabled"></button>
                                            <div class="panel-body">
                                                <div class="tab-content">
                                                    <div id="demo-bv-tab1" class="tab-pane active in">
                                                        <div class="form-group has-feedback">
                                                            <div class="col-md-4"></div>
                                                            <div class="col-md-4">
                                                                E-mail: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nm_email" id="nm_email" required="true">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="demo-bv-tab2" class="tab-pane fade">
                                                        <div class="form-group">
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-5">
                                                                Nome Civil: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nome_civil" id="nm_civil" required="true">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                Nome Social:
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nome" id="nm_nome">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-4">
                                                                Sexo: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="tp_sexo" class="form-control sexo">
                                                                        <option value="0">Selecione o Sexo</option>
                                                                        <option value="1">Feminino</option>
                                                                        <option value="2">Masculino</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                Data de Nascimento: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-calendar inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control data" name="dt_nascimento" id="dt_nascimento" placeholder="__/__/____" pattern="\d*" maxlength="4" required="true">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-3">
                                                                País <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_pais_naturalidade" class="form-control pais">
                                                                        <option value="0">Selecione o País</option>
                                                                        <?php
                                                                        // echo $lotacoes;
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                Estado: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_estado_naturalidade" class="form-control estado">
                                                                        <option value="0">Selecione o Estado</option>
                                                                        <?php
                                                                        // echo $lotacoes;
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                Cidade: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_naturalidade" class="form-control idCidade">
                                                                        <option value="0">Selecione a Naturalidade</option>
                                                                        <?php
                                                                        // echo $lotacoes;
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-2">
                                                                CPF: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nr_cpf" id="nr_cpf" placeholder="___.___.___-__" required="true">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                Registro Geral: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nr_rg" id="nr_rg" required="true">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                Orgão Expedidor: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="ds_orgao_expedidor" id="ds_orgao_expedidor" required="true">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                Estado do Orgão Expedidor: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_estado" class="form-control select">
                                                                        <option value="0">Selecione o Estado do Órgão Expeditor</option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-5">
                                                                Nome da Mãe: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nm_mae" id="nm_mae" required="true">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                Nome do Pai:
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nm_pai" id="nm_pai">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-3">
<!--                                                                Estado Civil: <span class="text-danger">*</span>-->
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_estado_civil" class="form-control select">
                                                                        <option value="0">Selecione o Estado Civil</option>

                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="col-md-3">
                                                                Número do Cartão SUS:
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nr_cns" id="nr_cns" placeholder="___ ____ ____ ____">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                Escolaridade:
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_escolaridade" class="form-control select">
                                                                        <option value="0">Selecione a Escolaridade</option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                        <div class="panel-footer panelCompetencia col-md-10">
                                                            <div class="form-group">
                                                                <div class="col-md-2"></div>
                                                                <div class="col-md-5">
                                                                    Competência:
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-list inputPFa"></p>
                                                                        </span>
                                                                        <select id="id_competencia" class="form-control formacao competencia select">
                                                                            <option value="0">Selecione a Competência</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="input-group">
                                                                        <br>
                                                                        <button class="btn btn-primary btn-rounded btn-add" type="button">
                                                                            <i class="fa fa-plus"></i> Competência
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-2"></div>
                                                                <div class="col-md-8">
                                                                    <div class="">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-striped table-bordered table-hover table-condensed" id="tabela">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th class="text-capitalize text-center">Formação</th> 
                                                                                        <th class="text-capitalize text-center">Escolaridade</th>
                                                                                        <th class="text-capitalize text-center">Ação</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="corpoTabela" id="corpoTabela">
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>    
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                                <br>
                                                                Habilidades:
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <textarea class="form-control" name="ds_habilidade" id="ds_habilidade" rows="5"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div id="demo-bv-tab3" class="tab-pane camposformulario">
                                                        <div class="form-group">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-2">
                                                                País <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_pais_endereco" class="form-control pais select">
                                                                        <option value="0">Selecione País</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                Estado: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_estado_endereco" class="form-control estado select">
                                                                        <option value="0">Selecione Estado</option>                                                                

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                Cidade: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_cidade" class="form-control idCidade select">
                                                                        <option value="0">Selecione Cidade</option>                                                                

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">    
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-3">
                                                                Logradouro: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="ds_logradouro" id="ds_logradouro" required="true">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                Complemento:
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="ds_complemento" id="ds_complemento">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                Número:
                                                                <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                                </span>
                                                                    <input type="number" class="form-control" name="nr_endereco" id="nr_endereco" min="0" required="true">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group"> 
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-5">
                                                                Bairro: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="ds_bairro" id="ds_bairro" required="true" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                CEP:
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nr_cep" id="nr_cep" placeholder="_____-___">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <div class="input-group">
                                                                    <br>
                                                                    <button class="btn btn-primary btn-rounded cep" type="button">
                                                                        <i class="fa fa-search" aria-hidden="true"></i> CEP
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group"> 
                                                            <div class="col-md-3"></div>
                                                            <div class="col-md-3">
                                                                Telefone Residêncial:
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nr_telefone_residencial" id="nr_telefone_residencial" placeholder="(__) ____-____">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                Telefone Celular: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="nr_telefone_celular" id="nr_telefone_celular" required="true" placeholder="(__) _ ____-____" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group panel-footer">
                                                        <div class="col-md-2"></div>
                                                        <div class="col-md-8">
                                                            Observação:
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                                </span>
                                                                <textarea class="form-control" name="ds_observacao" id="ds_observacao" rows="5"></textarea>
                                                            </div><br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-primary btn-rounded ant" type="button">
                                                    <i class="fa fa-backward" aria-hidden="true"></i> Anterior
                                                </button>
                                                <button class="btn btn-primary btn-rounded pro" type="button">
                                                    Próximo <i class="fa fa-forward" aria-hidden="true"></i> 
                                                </button>
                                            </div>
                                            <br>
                                            <div class="panel-footer text-center">
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
        <script src="/assets/js/sistema/pessoa/cadastroPessoaFisica.js"></script>
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
