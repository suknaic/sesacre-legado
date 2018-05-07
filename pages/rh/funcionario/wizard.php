<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/rh/pessoaFisica/index.load.php";
?>
<html lang="pt-br">
    <head>
        <title>Material Admin - Form Wizard</title>

        <!-- BEGIN STYLESHEETS -->
        <link type="text/css" rel="stylesheet" href="/assets2-3/css/theme-default/bootstrap.css?1422792965" />
        <link type="text/css" rel="stylesheet" href="/assets2-3/css/theme-default/materialadmin.css?1425466319" />
        <link type="text/css" rel="stylesheet" href="/assets2-3/css/theme-default/font-awesome.min.css?1422529194" />
        <link type="text/css" rel="stylesheet" href="/assets2-3/css/theme-default/material-design-iconic-font.min.css?1421434286" />
        <link type="text/css" rel="stylesheet" href="/assets2-3/css/theme-default/libs/wizard/wizard.css?1425466601" />
        <!-- END STYLESHEETS -->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
        <script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
        <![endif]-->
    </head>
    <body class="menubar-hoverable header-fixed ">
        <!-- END HEADER-->
        <!-- BEGIN BASE-->
        <div id="base">
            <!-- BEGIN OFFCANVAS LEFT -->
            <div class="offcanvas">
            </div><!--end .offcanvas-->
            <!-- END OFFCANVAS LEFT -->

            <!-- BEGIN CONTENT-->
            <div id="content">
                <section>
                    <div class="section-body contain-lg">

                        <!-- BEGIN FORM WIZARD -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body ">
                                        <div id="rootwizard1" class="form-wizard form-wizard-horizontal">
                                            <!--  <form class="form floating-label"> -->
                                            <form class="form-horizontal formRhFuncionario">  
                                                <div class="panel">
                                                    <div class="form-wizard-nav">
                                                        <div class="progress"><div class="progress-bar progress-bar-primary"></div></div>
                                                        <ul class="nav nav-justified">
                                                            <li class="active"><a href="#tab1" data-toggle="tab"><span class="step">1</span> <span class="title">LOGIN</span></a></li>
                                                            <li><a href="#tab2" data-toggle="tab"><span class="step">2</span> <span class="title">DADOS PESSOAIS</span></a></li>
                                                            <li><a href="#tab3" data-toggle="tab"><span class="step">3</span> <span class="title">ENDEREÇO / CONTATO</span></a></li>
                                                            <li><a href="#tab4" data-toggle="tab"><span class="step">4</span> <span class="title">DADOS FUNCIONAIS</span></a></li>
                                                        </ul>
                                                    </div><!--end .form-wizard-nav -->
                                                    <div class="tab-content clearfix">
                                                        <div class="tab-pane active" id="tab1">
                                                            <br/><br/>
                                                            <div class="form-group">
                                                                <div class="col-md-4"></div>
                                                                <div class="col-md-4">
                                                                    email: <span class="text-danger">*</span>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                                        </span>
                                                                        <input type="text" class="form-control" name="nm_email" id="nm_email" required="true">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!--end #tab1 -->
                                                        <div class="tab-pane" id="tab2">
                                                            <br/><br/>
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
                                                                <div class="col-md-1"></div>
                                                                <div class="col-md-3">
                                                                    Sexo: <span class="text-danger">*</span>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-list inputPFa"></p>
                                                                        </span>
                                                                        <select id="tp_sexo" class="form-control">
                                                                            <option value="0">Selecione Sexo</option>                                                                
                                                                            <option value="1">Femenino</option>
                                                                            <option value="2">Masculino</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    Naturalidade: <span class="text-danger">*</span>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-list inputPFa"></p>
                                                                        </span>
                                                                        <select id="id_naturalidade" class="form-control idCidade">
                                                                            <option value="0">Selecione Naturalidade</option>                                                                
                                                                            <?php
                                                                            // echo $lotacoes;
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    Data Nascimento: <span class="text-danger">*</span>
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
                                                                    Estado Orgão Expedidor: <span class="text-danger">*</span>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-list inputPFa"></p>
                                                                        </span>
                                                                        <select id="id_estado" class="form-control">
                                                                            <option value="0">Selecione</option>                                                                
                                                                            <?php
                                                                            // echo $lotacoes;
                                                                            ?>
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
                                                                    Estado Civil: <span class="text-danger">*</span>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-list inputPFa"></p>
                                                                        </span>
                                                                        <select id="id_estado_civil" class="form-control">
                                                                            <option value="0">Selecione</option>                                                                
                                                                            <?php
                                                                            // echo $lotacoes;
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-md-3">
                                                                    Nro. Cartão SUS:
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                                        </span>
                                                                        <input type="text" class="form-control" name="nr_cns" id="nr_cns">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    Escolaridade: <span class="text-danger">*</span>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-list inputPFa"></p>
                                                                        </span>
                                                                        <select id="id_escolaridade_formacao" class="form-control formacao">
                                                                            <option value="0">Selecione</option>                                                                
                                                                            <?php
                                                                            // echo $lotacoes;
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group panel-footer panelCompetencia">
                                                                <div class="form-group">
                                                                    <div class="col-md-2"></div>
                                                                    <div class="col-md-5">
                                                                        Competência:
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <p class="fa fa-list inputPFa"></p>
                                                                            </span>
                                                                            <select id="id_competencia" class="form-control formacao competencia">
                                                                                <option value="0">Selecione Competência</option>                                                                
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
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
                                                                    Habilidades:
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                                        </span>
                                                                        <textarea class="form-control" name="ds_habilidade" id="ds_habilidade" rows="5"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!--end #tab2 -->
                                                        <div class="tab-pane" id="tab3">
                                                            <br/><br/>
                                                            <div class="form-group">    
                                                                <div class="col-md-2"></div>
                                                                <div class="col-md-5">
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

                                                            </div>
                                                            <div class="form-group"> 
                                                                <div class="col-md-2"></div>
                                                                <div class="col-md-5">
                                                                    Bairo: <span class="text-danger">*</span>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                                        </span>
                                                                        <input type="text" class="form-control" name="ds_bairro" id="ds_bairro" required="true" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    CEP:
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                                        </span>
                                                                        <input type="text" class="form-control" name="nr_cep" id="nr_cep" placeholder="______-___">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group"> 
                                                                <div class="col-md-2"></div>
                                                                <div class="col-md-4">
                                                                    Cidade: <span class="text-danger">*</span>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-list inputPFa"></p>
                                                                        </span>
                                                                        <select id="id_cidade" class="form-control idCidade">
                                                                            <option value="0">Selecione Cidade</option>                                                                
                                                                            <?php
                                                                            // echo $lotacoes;
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    Telefone Residêncial:
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                                        </span>
                                                                        <input type="text" class="form-control" name="nr_telefone_residencial" id="nr_telefone_residencial">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    Telefone Celular: <span class="text-danger">*</span>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                                        </span>
                                                                        <input type="text" class="form-control" name="nr_telefone_celular" id="nr_telefone_celular" required="true">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-2"></div>
                                                                <div class="col-md-8">
                                                                    Observação:
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                                        </span>
                                                                        <textarea class="form-control" name="ds_observacao" id="ds_observacao" rows="5"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!--end #tab3 -->
                                                        <div class="tab-pane" id="tab4">
                                                            <br/><br/>
                                                            <div class="panel-body panelForm">
                                                                <div class="form-group"> 
                                                                    <div class="col-md-1"></div>
                                                                    <div class="col-md-3">
                                                                        Vínculo: <span class="text-danger">*</span>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <p class="fa fa-list inputPFa"></p>
                                                                            </span>
                                                                            <select id="id_vinculo" class="form-control">
                                                                                <option value="0">Selecione Vínculo</option>                                                                
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        Empresa: <span class="text-danger">*</span>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <p class="fa fa-list inputPFa"></p>
                                                                            </span>
                                                                            <select id="id_pessoa_juridica" class="form-control">
                                                                                <option value="0">Selecione Empresa</option>                                                                
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        Data Admissão: <span class="text-danger">*</span>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <p class="fa fa-calendar inputPFa"></p>
                                                                            </span>
                                                                            <input type="text" class="form-control data" name="dt_admissao" id="dt_admissao" placeholder="__/__/____" pattern="\d*" maxlength="4" required="true">
                                                                        </div>
                                                                    </div>
                                                                </div>    
                                                                <div class="form-group"> 
                                                                    <div class="col-md-1"></div>
                                                                    <div class="col-md-1">
                                                                        Carga Horária:
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <p class="fa fa-file-text-o inputPFa"></p>
                                                                            </span>
                                                                            <input type="text" class="form-control" name="nr_carga_horaria" id="nr_carga_horaria" required="true">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        Matrícula Nº: <span class="text-danger">*</span>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <p class="fa fa-file-text-o inputPFa"></p>
                                                                            </span>
                                                                            <input type="text" class="form-control" name="nr_matricula" id="nr_matricula" required="true">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        Cargo: <span class="text-danger">*</span>
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <p class="fa fa-list inputPFa"></p>
                                                                            </span>
                                                                            <select id="id_cargo" class="form-control">
                                                                                <option value="0">Selecione Cargo</option>                                                                
                                                                                <?php
                                                                                // echo $lotacoes;
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2 demissao" style="display:none">
                                                                        Data Demissão: 
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">
                                                                                <p class="fa fa-calendar inputPFa"></p>
                                                                            </span>
                                                                            <input type="text" class="form-control data" name="dt_demissao" id="dt_demissao" placeholder="__/__/____" pattern="\d*" maxlength="4">
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                                <div class="form-group panel-footer">
                                                                    <div class="form-group">
                                                                        <div class="col-md-1"></div>
                                                                        <div class="col-md-4">
                                                                            Lotação: <span class="text-danger">*</span>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">
                                                                                    <p class="fa fa-list inputPFa"></p>
                                                                                </span>
                                                                                <select id="id_lotacao" class="form-control">
                                                                                    <option value="0">Selecione Lotação</option>                                                                
                                                                                    <?php
                                                                                    // echo $lotacoes;
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            Função: <span class="text-danger">*</span>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">
                                                                                    <p class="fa fa-list inputPFa"></p>
                                                                                </span>
                                                                                <select id="id_funcao" class="form-control">
                                                                                    <option value="0">Selecione Função</option>                                                                
                                                                                    <?php
                                                                                    // echo $lotacoes;
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            Carga Horária:
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">
                                                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                                                </span>
                                                                                <input type="text" class="form-control" name="nr_carga_horaria2" id="nr_carga_horaria2" required="true">
                                                                            </div>
                                                                        </div>
                                                                    </div>    
                                                                    <div class="form-group">    
                                                                        <div class="col-md-1"></div>
                                                                        <div class="col-md-2">
                                                                            Data Inicio: <span class="text-danger">*</span>
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">
                                                                                    <p class="fa fa-calendar inputPFa"></p>
                                                                                </span>
                                                                                <input type="text" class="form-control data" name="dt_inicio" id="dt_inicio" placeholder="__/__/____" pattern="\d*" maxlength="4" required="true">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            Data Fim:
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">
                                                                                    <p class="fa fa-calendar inputPFa"></p>
                                                                                </span>
                                                                                <input type="text" class="form-control data" name="dt_fim" id="dt_fim" placeholder="__/__/____" pattern="\d*" maxlength="4" required="true">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4"></div>
                                                                        <div class="col-md-2">
                                                                            <div class="input-group">
                                                                                <br>
                                                                                <button class="btn btn-primary btn-rounded btn-add-lotacao" type="button">
                                                                                    <i class="fa fa-plus"></i> Lotação
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="col-md-1"></div>
                                                                        <div class="col-md-9">
                                                                            <div class="panel-footer text-left">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-striped table-bordered table-hover table-condensed" id="tabelaLotacao">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th class="text-capitalize text-center">Lotação</th> 
                                                                                                <th class="text-capitalize text-center">Função</th>
                                                                                                <th class="text-capitalize text-center">C. H.</th>
                                                                                                <th class="text-capitalize text-center">Data Inicio</th>
                                                                                                <th class="text-capitalize text-center">Data Fim</th>
                                                                                                <th class="text-capitalize text-center">Ação</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody class="corpoTabelaLotacao" id="corpoTabelaLotacao">
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!--end #tab4 -->
                                                    </div><!--end .tab-content -->
                                                    <ul class="pager wizard">
                                                        <li class="previous first"><a class="btn-raised" href="javascript:void(0);">Inicio</a></li>
                                                        <li class="previous"><a class="btn-raised" href="javascript:void(0);">Anterior</a></li>
                                                        <li class="next last"><a class="btn-raised" href="javascript:void(0);">Último</a></li>
                                                        <li class="next"><a class="btn-raised" href="javascript:void(0);">Próximo</a></li>
                                                    </ul>       
                                                    <!--Horizontal Form-->
                                                    <!--===================================================-->

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
                                        </div><!--end #rootwizard -->
                                    </div><!--end .card-body -->
                                </div><!--end .card -->
                                <em class="text-caption">Form wizard</em>
                            </div><!--end .col -->
                        </div><!--end .row -->
                        <!-- END FORM WIZARD -->



                    </div><!--end .section-body -->
                </section>
            </div><!--end #content-->
            <!-- END CONTENT -->

        </div><!--end #base-->
        <!-- END BASE -->
        
   
        
        
        
       
        <script src="/assets2-3/js/libs/jquery/jquery-1.11.2.min.js"></script> 
        <script src="/assets2-3/js/libs/bootstrap/bootstrap.min.js"></script>
        <script src="/assets2-3/js/libs/wizard/jquery.bootstrap.wizard.min.js"></script>    
        <script src="/assets2-3/js/core/demo/DemoFormWizard.js"></script>
<!--    
        


        <script src="/assets2/js/core/demo/Demo.js"></script>

        <script src="/assets2/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
        
        
        
        <script src="/assets2/js/core/source/AppNavSearch.js"></script>
        
        <script src="/assets2/js/libs/spin.js/spin.min.js"></script>
        <script src="/assets2/js/libs/autosize/jquery.autosize.min.js"></script>
        <script src="/assets2/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
        <script src="/assets2/js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="/assets2/js/libs/jquery-validation/dist/additional-methods.min.js"></script>
        


    <script src="/assets2/js/core/source/App.js"></script>
    <script src="/assets2/js/core/source/AppOffcanvas.js"></script>
    <script src="/assets2/js/core/source/AppCard.js"></script>
    <script src="/assets2/js/core/source/AppForm.js"></script>
    <script src="/assets2/js/core/source/AppVendor.js"></script>
        
        
-->

    </body>
</html>
