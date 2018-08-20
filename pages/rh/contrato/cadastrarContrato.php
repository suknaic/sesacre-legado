<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/rh/pessoaFisica/index.load.php";
if (isset($_GET['id'])){
    $cpf = explode("=", $_GET['id'])[0];
    $nro = (int)(explode("=", $_GET['id'])[1])+ 1;
}
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
                        <h1 class="page-header text-overflow">Cadastro de Novo Contrato</h1> 
                    </div>
                    <div class= "text-center text-bold text-danger" id="contContrato">
                        <?php
                            echo $nro.'° Contrato';
                        ?>
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12">

                                <form class="form-horizontal formRhFuncionario">  
                                    <input type="hidden" class="form-control" name="id_get" id="id_get" value="">
                                    <input type="hidden" class="form-control" name="id_pessoa" id="id_pessoa" value="">
                                    <input type="hidden" class="form-control" name="id_pessoa_fisica" id="id_pessoa_fisica" value="">
                                    <input type="hidden" class="form-control" name="id_contrato" id="id_contrato" value="">
                                    <input type="hidden" class="form-control" name="nr_cpf" id="cpf" value="<?php echo $cpf; ?>">
                                    <div class="panel">
                                        <div class="form-wizard-nav">
                                            <div class="progress"><div class="progress-bar progress-bar-primary"></div></div>
                                            <ul class="nav nav-justified">
                                                <li><a href="#tab1" data-toggle="tab"> <span class="title"><b><span class="text-primary">LOGIN</span></b></span></a></li>
                                                <li><a href="#tab2" data-toggle="tab"><span class="title"><b><span class="text-primary">DADOS PESSOAIS</span></b></span></a></li>
                                                <li><a href="#tab3" data-toggle="tab"><span class="title"><b><span class="text-primary">ENDEREÇO / CONTATO</span></b></span></a></li>
                                                <li class="active"><a href="#tab4" data-toggle="tab"><span class="title"><b><span class="text-primary">DADOS FUNCIONAIS</span></b></span></a></li>
                                            </ul>
                                        </div><!--end .form-wizard-nav -->
                                        <div class="tab-content clearfix">
                                            <div class="tab-pane" id="tab1">
                                                <br/><br/>
                                                <div class="form-group">
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-4">
                                                        Email: <span class="text-danger" title="Informe seu E-mail Institucional do domínio ac.gov.br">*</span>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-file-text-o inputPFa"></p>
                                                            </span>
                                                            <input type="text" class="form-control" name="nm_email" id="nm_email" placeholder="Informe seu E-mail Institucional do domínio ac.gov.br" required="true">
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
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-4">
                                                        Sexo: <span class="text-danger">*</span>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="tp_sexo" class="form-control">
                                                                <option value="0">Selecione Sexo</option>                                                                
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
                                                        Naturalidade: 
                                                        País <span class="text-danger">*</span>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="id_pais_naturalidade" class="form-control pais">
                                                                <option value="0">Selecione País</option>                                                                
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
                                                                <option value="0">Selecione Estado</option>                                                                
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
                                                                <option value="0">Selecione Naturalidade</option>                                                                
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
                                                            <input type="text" class="form-control" name="nr_cpf" id="nr_cpf" placeholder="___.___.___-__" required="true" disabled="">
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
                                                            <select id="id_estado" class="form-control estado">
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
                                                        N° Cartão SUS:
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
                                                            <select id="id_escolaridade" class="form-control">
                                                                <option value="0">Selecione</option>                                                                
                                                                <?php
                                                                // echo $lotacoes;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-10 panel-footer panelCompetencia">
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
                                                                    <table class="table table-striped table-bordered table-hover table-condensed">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="text-capitalize text-center">Curso</th> 
                                                                                <th class="text-capitalize text-center">Escolaridade</th>
                                                                                <th class="text-capitalize text-center">Ação</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="corpoCompetencia" id="corpoCompetencia">
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-8"><br>
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
                                                    <div class="col-md-2">
                                                        País <span class="text-danger">*</span>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="id_pais_endereco" class="form-control pais">
                                                                <option value="0">Selecione País</option>                                                                
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
                                                            <select id="id_estado_endereco" class="form-control estado">
                                                                <option value="0">Selecione Estado</option>                                                                
                                                                <?php
                                                                // echo $lotacoes;
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
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
                                                </div>
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
                                                        Bairro: <span class="text-danger">*</span>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-file-text-o inputPFa"></p>
                                                            </span>
                                                            <input type="text" class="form-control" name="ds_bairro" id="ds_bairro" required="true">
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
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-3">
                                                        Telefone Residencial:
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
                                                            <input type="text" class="form-control" name="nr_telefone_celular" id="nr_telefone_celular" required="true" placeholder="(__) _ ____-____">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2"></div>
                                                </div>

                                            </div><!--end #tab3 -->
                                            <div class="tab-pane active" id="tab4">
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
                                                                    <option value="0">Selecione o Vínculo</option>
                                                                    <?php
                                                                    // echo $lotacoes;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            Empresa: <span class="text-danger">*</span>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <p class="fa fa-list inputPFa"></p>
                                                                </span>
                                                                <select id="id_pessoa_juridica" class="form-control">
                                                                    <option value="0">Selecione a Empresa</option>
                                                                    <?php
                                                                    // echo $lotacoes;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            Data de Admissão: <span class="text-danger">*</span>
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
                                                        <div class="col-md-2">
                                                            Carga Horária: <span class="text-danger">*</span>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                                </span>
                                                                <input type="text" class="form-control nr" name="nr_carga_horaria" id="nr_carga_horaria" required="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            Matrícula: <span class="text-danger">*</span>
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
                                                                    <option value="0">Selecione o Cargo</option>
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
                                                    <div class="col-md-1"></div>
                                                    <div class="panel-footer col-md-10">
                                                        <div class="form-group">
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-6">
                                                                Lotação: <span class="text-danger">*</span>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-list inputPFa"></p>
                                                                    </span>
                                                                    <select id="id_lotacao" class="form-control">
                                                                        <option value="0">Selecione a Lotação</option>
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
                                                                        <option value="0">Selecione a Função</option>
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
                                                                Carga Horária:
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">
                                                                        <p class="fa fa-file-text-o inputPFa"></p>
                                                                    </span>
                                                                    <input type="text" class="form-control nr" name="nr_carga_horaria2" id="nr_carga_horaria2" required="true">
                                                                </div>
                                                            </div>
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
                                                            <div class="col-md-10">
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
                                            <div class="form-group panel-footer">
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
                                        </div><!--end .tab-content -->
                                        <div class="text-center">
                                            <button class="btn btn-primary btn-rounded ant" type="button">
                                                <i class="fa fa-backward" aria-hidden="true"></i> Anterior
                                            </button>
                                            <button class="btn btn-primary btn-rounded pro" type="button">
                                                Próximo <i class="fa fa-forward" aria-hidden="true"></i> 
                                            </button>
                                        </div>
                                        <br>

                                        <!--===================================================-->

                                    </div>
                                    <!-- <div class="panel-body"> -->
                                    <!-- Footer Form -->
                                    <div class="panel-footer text-right">
                                        <button type="button" class="btn btn-default btn-default btn-rounded btn-limpar">
                                            Limpar
                                        </button>                                  
                                        <button class="btn btn-success btn-rounded btn-salvar" type="button">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar Contrato
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
        <script src="/assets/js/rh/contrato/cadastrarContrato.js"></script>
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

