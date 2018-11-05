<!DOCTYPE html>

<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/fornecedores_ext/index.load.php";
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
                padding: 10px 20px;
                margin: 43px ;
            }
            .adicionar {
                margin: 32px;
                margin-left: 0;
            }
        </style>
    </head>
    <!--TIPS-->

    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-sm">
            <!--NAVBAR-->
            <!--===================================================-->
<!--            <header id="navbar">-->
<!--                <div id="navbar-container" class="boxed">-->
                    <!--Brand logo & name-->
                    <!--================================-->
                    <!--<div class="navbar-header">
                        <a href="/index.php" class="navbar-brand">
                            <img src="/assets/img/esfera.png" alt="Nifty Logo" class="brand-icon">
                            <div class="brand-title">
                                <span class="brand-text">SESACRENET</span>
                            </div>
                        </a>
                    </div>-->
                    <!--================================-->
                    <!--End brand logo & name-->
                    <!--Navbar Dropdown-->
                    <!--================================-->
<!--                    <div class="navbar-content clearfix">-->
<!--                        <ul class="nav navbar-top-links pull-left">-->

                            <!--Navigation toogle button-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--                            <li class="tgl-menu-btn">-->
<!--                                <a class="mainnav-toggle" href="#">-->
<!--                                    <i class="ti-view-list"></i>-->
<!--                                </a>-->
<!--                            </li>-->

<!--                        </ul>-->
<!--                    </div>-->
                    <!--================================-->
                    <!--End Navbar Dropdown-->
<!--                </div>-->
<!--            </header>-->
            <!--===================================================-->
            <!--END NAVBAR-->
            <div id="page-title">
                <h2 class="text-overflow">Cadastro de Fornecedores</h2>
            </div>

            <?php
                //Modal Alert
                require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/modalAlert.html";
            ?>

            <div class="boxed">
                <div id="page-content"><br>
                    <form data-toggle="validator" class="form-horizontal formPesquisa" id="form_pesquisa" role="form" action="#"method="post">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Formulário</h3>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>Razão Social: </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="rz_social" id="rz_social" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>Nome Fantasia:  </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="nm_fantasia" id="nm_fantasia" required="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>CNPJ: </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="nr_cnpj" id="nr_cnpj" required="true"  placeholder="__.___.___/____-__">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>Inscrição Estadual: </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="nr_estadual" id="nr_estadual" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>Inscrição Municipal: </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="nr_municipal" id="nr_municipal" required="true">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>País: </strong><span class="text-danger">*</span></p>
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
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>Estado: </strong><span class="text-danger">*</span></p>
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
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>Cidade: </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-list inputPFa"></p>
                                            </span>
                                            <select id="id_cidade" class="form-control select">
                                                <option value="0">Selecione o Cidade</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>Logradouro: </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="logradouro" id="ds_logradouro" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>Bairro: </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="bairro" id="ds_bairro" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>CEP: </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="nr_cep" id="nr_cep" placeholder="_____-___">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-1">
                                    <div class="panel-group">
                                        <button class="btn btn-info btn-rounded cep" type="button">
                                            <i class="fa fa-search" aria-hidden="true"></i> CEP
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>Telefone da Empresa: </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="telefone" id="nr_telefone_empresa" required="true" placeholder="(  )______-_____">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>Telefone Celular: </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="telefone" id="nr_telefone_celular" required="true" placeholder="(  )______-_____">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>E-mail: </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="email" id="nm_email" required="true" placeholder="Ex.: sesacre@ac.gov.com">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-5">
                                    <label><strong>A Empresa é Distribuidora? <span class="text-danger">*</span></strong></label>
                                    <input type="radio" name="emp_dist" id="emp_dist" value="sim"> Sim
                                    <input type="radio" name="emp_dist" id="emp_dist" value="nao"> Não
                                </div>
                                <div class="col-sm-5">
                                    <label><strong>A Empresa possui Exclusividade? <span class="text-danger">*</span></strong></label>
                                    <input type="radio" name="emp_exc" id="emp_exc" value="sim"> Sim
                                    <input type="radio" name="emp_exc" id="emp_exc" value="nao"> Não
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>Caso a empresa seja distribuidora, informar para qual empresa presta esse serviço. </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="emp_dist" id="emp_dist" required="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="panel-body">
                                        <p class= "form-control-static"><strong>Caso a empresa possua exclusividade, informar para qual empresa presta esse serviço. </strong><span class="text-danger">*</span></p>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <p class="fa fa-file-text-o inputPFa"></p>
                                            </span>
                                            <input type="text" class="form-control" name="emp_exclu" id="emp_exclu" required="true">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Tipos de Produtos ou Serviços que a Empresa Fornece</h5>
                                </div>

                                <div id="medicamentos">
                                    <div class="col-sm-5">
                                        <div class="panel-body">
                                            <p class= "form-control-static"><strong>Medicamentos: </strong><span class="text-danger">*</span></p>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-list inputPFa"></p>
                                                </span>
                                                <select id="id_medicamentos" class="form-control select">
                                                    <option value="0">Selecione o tipo de Medicamento</option>
                                                    <option value="1">Medicamentos</option>
                                                    <option value="2">Medicamentos Manipulados</option>
                                                    <option value="3">Medicamentos Importados</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            <button  type="button" class="btn btn-primary adicionar addMedicamentos">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="servico">
                                    <div class="col-sm-5">
                                        <div class="panel-body">
                                            <p class= "form-control-static"><strong>Serviços: </strong><span class="text-danger">*</span></p>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-list inputPFa"></p>
                                                </span>
                                                <select id="id_servicos" class="form-control select">
                                                    <option value="0">Selecione o tipo de Serviço</option>
                                                    <option value="1">Alimentação</option>
                                                    <option value="2">Home Care</option>
                                                    <option value="3">Fisioterapia Therasuit</option>
                                                    <option value="4">Fisioterapia Pediasuit</option>
                                                    <option value="5">Fisioterapia Equoterapia</option>
                                                    <option value="6">Fisioterapia Hidroterapia</option>
                                                    <option value="7">Informática</option>
                                                    <option value="8">Lavagem de Roupa</option>
                                                    <option value="9">Limpeza</option>
                                                    <option value="10">Telefonia</option>
                                                    <option value="11">Veículos</option>
                                                    <option value="12">Vigilância</option>
                                                    <option value="13">Clínica de Exame</option>
                                                    <option value="14">Clínica de Imagem</option>
                                                    <option value="15">Clínica de Drenagem Linfática</option>
                                                    <option value="16">Óticas</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            <button  type="button" class="btn btn-primary adicionar addServico">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="consumo">
                                    <div class="col-sm-5">
                                        <div class="panel-body">
                                            <p class= "form-control-static"><strong>Material de Consumo:  </strong><span class="text-danger">*</span></p>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-list inputPFa"></p>
                                                </span>
                                                <select id="id_material_consumo" class="form-control select">
                                                    <option value="0">Selecione o tipo de Material de Consumo</option>
                                                    <option value="1">Material Médico Hospitalar - Cirúrgico</option>
                                                    <option value="2">Material Médico Hospitalar - Descartável (Agulhas, Seringas, Curativos, etc)</option>
                                                    <option value="3">Material Odontológico</option>
                                                    <option value="4">Material para Hemoterapia</option>
                                                    <option value="5">Roupas Hospitalares</option>
                                                    <option value="6">Material Laboratorial (Reagentes e Testes)</option>
                                                    <option value="7">Saneantes</option>
                                                    <option value="8">Fórmula Alimentar</option>
                                                    <option value="9">Vidraria</option>
                                                    <option value="10">Bolsa de Ostomia</option>
                                                    <option value="11">Filmes Radiológicos</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            <button  type="button" class="btn btn-primary adicionar addConsumo">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="permanente">
                                    <div class="col-sm-5">
                                        <div class="panel-body">
                                            <p class= "form-control-static"><strong>Material Permanente: </strong><span class="text-danger">*</span></p>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-list inputPFa"></p>
                                                </span>
                                                <select id="idmaterial_permanente" class="form-control select">
                                                    <option value="0">Selecione o tipo Material</option>
                                                    <option value="1">Máquinas e Equipamentos Hospitalares</option>
                                                    <option value="2">Máquinas e Equipamentos Hospitalares de Imagem</option>
                                                    <option value="3">Máquinas e Equipamentos Médico Cirúrgicos</option>
                                                    <option value="4">Máquinas e Equipamentos Médico Endoscópios</option>
                                                    <option value="5">Máquinas e Equipamentos Médico Oftalmológicos</option>
                                                    <option value="6">Máquinas e Equipamentos Médico Auditivos</option>
                                                    <option value="7">Máquinas e Equipamentos Odontológicos</option>
                                                    <option value="8">Máquinas e Equipamentos Ortopédicos e Mobilidade</option>
                                                    <option value="9">Máquinas e Equipamentos de Laboratórios</option>
                                                    <option value="10">Máquinas e Equipamentos de Fisioterapia</option>
                                                    <option value="11">Máquinas e Equipamentos de Informática</option>
                                                    <option value="12">Eletroeletrônicos</option>
                                                    <option value="13">Mobiliário Hospitalar</option>
                                                    <option value="14">Mobiliário de Escritório</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            <button  type="button" class="btn btn-primary adicionar addPermanente">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <hr>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-2">
                                    <button class="btn btn-default btn-rounded btn-limpar btn-block" type="button">
                                        <i class="fa fa-eraser" aria-hidden="true"></i> Limpar
                                    </button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-success btn-rounded btn-salvar btn-block" type="button">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                    </button>
                                </div><br><br><br>
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
