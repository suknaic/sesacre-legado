<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/cha/informatica/sistemas/cadweb/index.load.php";
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
                    <!--<div id="page-title">
                        <h1 class="page-header text-overflow">Criar Usuário</h1>
                    </div>-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">

                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel">
                                  <div id="demo-acc-mint-outline">
                                    <div class="panel panel-bordered panel-mint">
                                      <div class="panel-heading ">
                                        <div class="panel-control">
                                          <ul class="nav nav-tabs">
                                            <li class="active">
                                              <a href="#demo-tabs-box-1" data-toggle="tab">Formulário</a>
                                            </li>
                                            <li>
                                              <a href="#demo-tabs-box-2" data-toggle="tab">Anexos</a>
                                            </li>
                                          </ul>
                                        </div>
                                          <h3 class="panel-title">Redefinir Senha</h3>
                                      </div>
                                    </div>
                                  </div>

                                    <!--Horizontal Form-->
                                    <!--===================================================-->
                                    <form class="form-horizontal formDados">
<!--                                        <input type="hidden"  id="id_categoria_principal" name="id_categoria_principal" value="3" />
                                        <input type="hidden"  id="id_categoria_tipo" name="id_categoria_tipo" value="3" />
                                        <input type="hidden"  id="id_categoria_primaria" name="id_categoria_primaria" value="1" />
                                        <input type="hidden"  id="id_categoria_secundaria" name="id_categoria_secundaria" value="1" />-->

                                        <div class="panel-body">
                                          <div class="tab-content">
                                            <div id="demo-tabs-box-1" class="tab-pane fade in active">
                                              <p class="text-main text-semibold">Formulário</p>
                                            </div>
                                            <div id="demo-tabs-box-2" class="tab-pane fade">
                                              <p class="text-main text-semibold">Anexos</p>
                                            </div>

                                          </div>
                                            <div class="form-group">

                                              <div class="col-md-6">
                                                  <div class="panel-body">
                                                      <label for="nome">
                                                          Nome: <span class="text-danger">*</span>
                                                      </label>
                                                      <div class="input-group">
                                                          <span class="input-group-addon">
                                                              <p class="fa fa-file-text-o inputPFa"></p>
                                                          </span>
                                                           <input type="text" class="form-control" name="nome"
                                                                 id="nome" required="true">
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="col-md-6">
                                                  <div class="panel-body">
                                                      <label for="email">
                                                          Email: <span class="text-danger">*</span>
                                                      </label>
                                                      <div class="input-group">
                                                          <span class="input-group-addon">
                                                              <p class="fa fa-envelope-o inputPFa"></p>
                                                          </span>
                                                          <input type="text" class="form-control" name="email"
                                                                 id="email" required="true">
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="col-md-6">
                                                  <div class="panel-body">
                                                      <label for="telefone">
                                                          Telefone: <span class="text-danger">*</span>
                                                      </label>
                                                      <div class="input-group">
                                                          <span class="input-group-addon">
                                                              <p class="fa fa-phone inputPFa"></p>
                                                          </span>
                                                          <input type="text" class="form-control" name="telefone" placeholder="(__) _ ____-____"
                                                                 id="telefone" required="true">
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="col-md-6">
                                                  <div class="panel-body">
                                                      <label for="cns">
                                                          Cartão do SUS: <span class="text-danger">*</span>
                                                      </label>
                                                      <div class="input-group">
                                                          <span class="input-group-addon">
                                                              <p class="fa fa-plus-square inputPFa"></p>
                                                          </span>
                                                          <input type="text" class="form-control" name="cns"
                                                                 id="cns" required="true">
                                                      </div>
                                                  </div>
                                              </div>


                                                  <div class="col-md-6">
                                                    <div class="panel-body">
                                                      <label for="unidade">
                                                        Lotação: <span class="text-danger">*</span>
                                                      </label>
                                                      <div class="input-group">
                                                          <span class="input-group-addon">
                                                              <p class="fa fa-list inputPFa"></p>
                                                          </span>
                                                          <select id="lotacao" class="form-control">
                                                              <?php
                                                              // echo $lotacoes;
                                                              ?>
                                                          </select>
                                                      </div>
                                                    </div>

                                                  </div>



                                            </div>
                                            <!-- End <div class="form-group"> -->


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
                                            <button class="btn btn-success btn-rounded btn-salvar" id="btn-salvar" type="button" value="0">
                                                <i class="fa fa-floppy-o" aria-hidden="true"></i> <span id="txtBtn">Salvar</span>
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
            </div>

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
        <script src="/assets/js/cha/informatica/sistemas/cadweb/redefine.js"></script>
        <!-- select2 -->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!-- END JAVASCRIPT -->

    </body>
</html>
