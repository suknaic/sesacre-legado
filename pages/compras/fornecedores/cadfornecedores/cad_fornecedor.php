<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/compras/fornecedores/index.load.php";
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
    <link rel="stylesheet" href="/assets/lib/template/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- themify icons [ REQUIRED ] -->
    <link rel="stylesheet" href="/assets/lib/template/plugins/themify-icons/themify-icons.min.css" rel="stylesheet">
    <!--Select2-->
    <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
    <!--Datapicker-->
    <link href="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- Estilo Default das Páginas [ REQUIRED ] -->
    <link rel="stylesheet" href="/assets/css/estilo.css" rel="stylesheet">
</head>
<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
<body>
    <div id="container" class="effect aside-float aside-bright mainnav-lg">
        <?php
        //Cabeçalho do Sistema
        require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php";
        ?>
        <?php
        //Modal Alert
        require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/modalAlert.html";
        ?>
        <div class="boxed">
            <!--CONTENT CONTAINER-->
            <!--===================================================-->
            <div id="content-container">
                <!--Page content-->
                <!--===================================================-->
                <div id="page-content">
                    <form data-toggle="validator" class="form-horizontal" id="form-documento" role="form" action="#" method="post">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Informações do credor</h3>
                            </div>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <div class="panel-body">
                                        Nome do contratado:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                            <input class="form-control" type="text" name="nome" id="nome" required="true" value="Acretec Indústria Comércio de Água e Representações LTDA"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="panel-body">
                                        Data de assinatura:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                            <input class="form-control data" type="text" name="data_assinatura" id="data_assinatura" value="01/01/2017"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="panel-body">
                                        Data de publicação:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                            <input class="form-control data" type="text" name="data_publicacao" id="data_publicacao" required="true" value="01/01/2017"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="panel-body">
                                        Modalidade:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                            <select class="form-control select" name="modalidade" id="modalidade" required="true">
                                                <option value="">Selecionar uma modalidade</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3">
                                    <div class="panel-body">
                                        Vigência inicial:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                            <input class="form-control data" type="text" name="vig_inicial" id="vig_inicial" required="true" value="01/01/2017"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="panel-body">
                                        Vigência final:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                            <input class="form-control data" type="text" name="vig_final" id="vig_final" required="true" value="01/12/2017"/>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="panel-body">
                                        Prazo de entrega:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                            <input class="form-control" type="text" name="prazo_entrega" id="prazo_entrega" required="true" value="30">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6">
                                    <div class="panel-body">
                                        Resumo do objeto:<span class="text-danger">*</span>
                                        <textarea class="form-control" rows="4" id="resumo_objeto">teste resumo</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel-body">
                                        Descrição da ATA:<span class="text-danger">*</span>
                                        <textarea class="form-control" rows="4" id="desc_ata">Descricao ata</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-heading">
                                <h3 class="panel-title">Informações do contratado</h3>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <div class="radio">
                                            <label><input type="radio" id="cont_pj" value="1" name="contratado" checked>Pessoa juridica</label>
                                            <label><input type="radio" id="cont_pf" value="2" name="contratado">Pessoa Física</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-5">
                                    <div class="panel-body">
                                        Nome do contratado:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                            <select class="form-control select" name="empresa" id="empresa" required="true">
                                                <option value="">Selecionar uma contratado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="panel-body">
                                        CNPJ/CPF:<span class="text-danger">*</span>
                                        <div class="input-group">
                                            <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                            <input class="form-control" type="text" name="cnpj" id="cnpj" required="true"
                                            disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-heading">
                                <h3 class="panel-title">Configuração da ata</h3>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <div class="checkbox">
                                            <label><input type="checkbox" value="S" name="cofiguracaoAta[]">Serviço Continuado</label>
                                        </div>
                                        <div class="checkbox">
                                            <label><input type="checkbox" value="C" name="cofiguracaoAta[]">Carona</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="doc_botao">
                            <button class="btn btn-success btn-salvar btn-rounded btn-block" type="button">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>Salvar
                            </button>
                        </div>
                    </form>
                </div>
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
    <!-- /.login-box -->
    <!--jQuery [ REQUIRED ]-->
    <script src="/assets/lib/template/js/jquery-2.2.4.min.js"></script>
    <!--BootstrapJS [ REQUIRED ]-->
    <script src="/assets/lib/template/js/bootstrap.min.js"></script>
    <!--NiftyJS [ RECOMMENDED ]-->
    <script src="/assets/lib/template/js/nifty.min.js"></script>
    <!--Datapicker-->
    <script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!--MaskedInput-->
    <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
    <!--Input valor priceformat-->
    <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
    <!--Select2-->
    <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
    <!--JAVASCRIP da pagina-->
    <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
    <script src="/assets/lib/sesacre/funcoes.js"></script>
    <script src="/assets/js/compras/gestao_contratos/cad_ata.js"></script>
</body>
</html>
