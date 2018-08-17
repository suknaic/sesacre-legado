<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/rh/lotacao/index.load.php";
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
        <!--checkbox-circle-primary -->
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
                        <h1 class="page-header text-overflow">Cadastro de Lotação</h1>   
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <?php
                    require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/rh/modalPessoa.php";
                    ?>
                    <!--===================================================-->
                    <div id="page-content">
                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-horizontal formRhLotacao">  
                                    <div class="panel">
                                        <div class="panel-heading ">
                                            <h3 class="panel-title">Dados</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-5">
                                                    Categoria: <span class="text-danger"> * </span><i class="fa fa-question-circle" title="Informar o que a Lotação é."></i>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="id_categoria" class="form-control">
                                                            <option value="0">Selecione Categoria</option>                                                                
                                                            <?php
                                                            // echo $lotacoes;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    Nome da Lotação: <span class="text-danger"> * </span>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control" name="nm_lotacao" id="nm_lotacao" required="true">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-2">
                                                    CNPJ: <span class="text-danger"></span>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control" name="nr_cnpj" id="nr_cnpj" placeholder="__.___.___/____-__" required="true">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    Email: <span class="text-danger"></span><i class="fa fa-question-circle" title="Informe o email da Lotação"></i>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control" name="nm_email" id="nm_email" required="true">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    Lotação Pai: <span class="text-danger">*</span>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="id_pai_lotacao" class="form-control">
                                                            <option value="0">Selecione Lotação Pai</option>                                                                
                                                            <?php
                                                            // echo $lotacoes;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-9">
                                                    <input type="hidden" id="id_pessoa_juridica" disabled value="">
                                                    Empresa Responsável: <span class="text-danger">*</span>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input class="form-control" type="text" id="nm_pessoa_juridica" disabled value="" />
                                                    </div>

                                                </div>
                                                <div class="col-md-1">
                                                    <br>
                                                    <span class="input-group-btn abre-ModalPj" data-target="#pesquisaPessoa" data-toggle="modal" data-id="pj">
                                                        <button type="button" class="btn btn-primary pesquisaPessoaJuridica"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-9">
                                                    Pessoa Responsável: <span class="text-danger">*</span>
                                                    <input type="hidden" id="id_pessoa" disabled value="">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input class="form-control" type="text" id="nm_pessoa2" disabled value="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <br>
                                                    <span class="input-group-btn abre-ModalPf pesquisaPessoaFisica" data-target="#pesquisaPessoa" data-toggle="modal" data-id="pf">
                                                        <button type="button" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-heading ">
                                            <h3 class="panel-title">Endereço / Contato</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">    
                                                <div class="col-md-1"></div>
                                                <div class="col-md-5">
                                                    Logradouro: <span class="text-danger">*</span>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control" name="ds_logradouro" id="ds_logradouro" required="true">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    Bairro: <span class="text-danger">*</span>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control" name="ds_bairro" id="ds_bairro" required="true" >
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group"> 
                                                <div class="col-md-1"></div>
                                                <div class="col-md-2">
                                                    CEP:
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control" name="nr_cep" id="nr_cep" placeholder="______-___">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <br>
                                                        <button class="btn btn-primary btn-rounded cep" type="button">
                                                            <i class="fa fa-search" aria-hidden="true"></i> CEP
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Latitude:
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control" name="mp_latitude" id="mp_latitude">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    Longitude: 
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control" name="mp_longitude" id="mp_longitude" required="true">
                                                    </div>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-1"></div>
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
                                                <div class="col-md-4">
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
                                            </div>
                                            <!-- End <div class="form-group"> -->
                                            <div class="form-group panel-footer panelTelefone">
                                                <div class="form-group">
                                                    <div class="col-md-2"></div>
                                                    <div class="col-md-2">
                                                        Telefone:
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-file-text-o inputPFa"></p>
                                                            </span>
                                                            <input type="text" class="form-control" name="nr_telefone" id="nr_telefone" placeholder="(__) ____-____">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="checkbox checkbox-info checkbox-circle"><br>
                                                            <input id="checkbox8" type="checkbox" class="st_principal">
                                                            <label for="checkbox8"> É Principal <i class="fa fa-question-circle" title="Selecione caso este seja o Telefone Principal da Lotação"></i></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="input-group">
                                                            <br>
                                                            <button class="btn btn-primary btn-rounded btn-add" type="button">
                                                                <i class="fa fa-plus"></i> Telefone
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
                                                                            <th class="text-capitalize text-center">Telefone</th> 
                                                                            <th class="text-capitalize text-center">Principal</th>
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
                                        </div>


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
        <script src="/assets/js/rh/lotacao/cadastroLotacao.js"></script>
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
