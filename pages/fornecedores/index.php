
<!DOCTYPE html>
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
                require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/compras/fornecedores/header.php";
                //Modal Alert
                require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/modalAlert.html";
            ?>

            <div class="boxed">
                <br>
                <br>
                <div class="row">
                    <div class="col-sm-3">
                        <h3> Cadastro de Fornecedores</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div id="page-content">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label><strong>Razão Social: </strong><span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="razao_soc" id="razao_soc" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label><strong>Nome Fantasia: </strong></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="nm_fantasia" id="nm_fantasia" required="true">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <p></p><label><strong>CNPJ: </strong><span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-sort-numeric-asc inputPFa"></p> 
                                                </span>
                                                <input type="text" class="form-control" name="nr_cnpj" id="nr_cnpj" required="true" placeholder="__.___.___/____-__">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p></p><label><strong>Inscrição Estadual:</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <p><input type="text" class="form-control" name="isncricao-estadual" id="ds_isnc_estadual" required="true"></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p></p><label><strong>Inscrição Municipal:</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="isncricao-municipal" id="ds_isnc_municipal" required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p></p><label><strong>País: </strong><span class="text-danger">*</span></label>
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
                                            <p></p><label><strong>Estado: </strong><span class="text-danger">*</span></label>
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
                                            <p></p><label><strong>Cidade: </strong><span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-list inputPFa"></p>
                                                </span>
                                                <select id="id_naturalidade" class="form-control idCidade">
                                                    <option value="0">Selecione a Cidade</option>
                                                    <?php
                                                    // echo $lotacoes;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p></p><label><strong>Logradouro:</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="logradouro" id="ds_logradouro" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <p></p><label><strong>Bairro: </strong></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="bairro" id="ds_bairro" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <p></p><label><strong>CEP: </strong><span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="nr_cep" id="nr_cep" placeholder="______-___">
                                            </div>
                                        </div>
                                        <p></p><div class="col-md-1">
                                            <div class="input-group">
                                                <br>
                                                <button class="btn btn-info btn-rounded cep" type="button">
                                                    <i class="fa fa-search" aria-hidden="true"></i> CEP
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <p></p><label><strong>Telefone da Empresa: </strong><span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="telefone" id="nr_telefone_celular" required="true" placeholder="(  )______-_____">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <p></p><label><strong>Telefone Celular:</strong></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="telefone" id="nr_telefone_residencial" required="true" placeholder="(  )______-_____">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p></p><label><strong>E-mail: </strong><span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="email" id="nm_email" required="true" placeholder="Ex.: sesacre@ac.gov.mail">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p></p><label><strong>A Empresa é Distribuidora? <span class="text-danger">*</span></strong></label>
                                            <form action="">
                                                <input type="radio" name="emp_dist" id="emp_dist" value="sim"> Sim
                                                <input type="radio" name="emp_dist" id="emp_dist" value="nao"> Não<br>
                                            </form>
                                        </div>
                                        <div class="col-md-4">
                                            <p></p><label><strong>A Empresa possui Exclusividade? <span class="text-danger">*</span></strong></label>
                                            <form action="">
                                                <input type="radio" name="emp_exc" id="emp_exc" value="sim"> Sim
                                                <input type="radio" name="emp_exc" id="emp_exc" value="nao"> Não<br>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <p></p><label>Caso a empresa seja distribuidora, informar para qual empresa presta esse serviço.</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="emp_dist" id="emp_dist" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <p></p><label>Caso a empresa possua exclusividade, informar para qual empresa presta esse serviço.</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="emp_dist" id="emp_dist" required="true">
                                            </div>
                                        </div>
                                        <p></p>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <p></p><label><strong>Tipos de Produtos ou Serviços que a Empresa Fornece</strong></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p></p><label>Medicamentos: <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-list inputPFa"></p>
                                                </span>
                                                <select id="id_naturalidade" class="form-control idCidade">
                                                    <option value="0">Selecione o tipo de Medicamento</option>
                                                    <option value="1">Medicamentos</option>
                                                    <option value="2">Medicamentos Manipulados</option>
                                                    <option value="3">Medicamentos Importados</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                        </div>
                                        <div class="col-sm-5">
                                            <p></p><label>Outro:</label> 
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="outro-med" id="outro_med" required="true">
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <p></p><div class="panel-body">
                                                <a href="#" class="btn btn-info">+</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Serviços: <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-list inputPFa"></p>
                                                </span>
                                                <select id="id_naturalidade" class="form-control idCidade">
                                                    <option value="0">Selecione o tipo de Serviços</option>
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
                                        <div class="col-sm-1">
                                        </div>
                                        <div class="col-sm-5">
                                            <label>Outro:</label> 
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="outro-serv" id="outro_serv" required="true">
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <p></p><div class="panel-body">
                                                <a href="#" class="btn btn-info">+</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Material de Consumo: <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-list inputPFa"></p>
                                                </span>
                                                <select id="id_naturalidade" class="form-control idCidade">
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
                                        <div class="col-sm-1">
                                        </div>
                                        <div class="col-sm-5">
                                            <label>Outro:</label> 
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="outro-serv" id="outro_serv" required="true">
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <p></p><div class="panel-body">
                                                <a href="#" class="btn btn-info">+</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Material Permanente: <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-list inputPFa"></p>
                                                </span>
                                                <select id="id_naturalidade" class="form-control idCidade">
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
                                        <div class="col-sm-1">
                                        </div>
                                        <div class="col-sm-5">
                                            <label>Outro:</label> 
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="outro-serv" id="outro_serv" required="true">
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <p></p><div class="panel-body">
                                                <a href="#" class="btn btn-info">+</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                            <br>
                            <div class="col-sm-2">
                                <button class="btn btn-success btn-rounded btn-salvar" type="button">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                </button>
                                <br>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                    <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/compras/fornecedores/rodapefornecedores.php"; ?>
                </div>
            </div>

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
