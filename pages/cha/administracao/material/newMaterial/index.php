<!DOCTYPE html>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "/model/cha/administracao/material/index.lod.php";
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
        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css">
        <!--selec2-->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">
        <!-- Datapicker -->
        <link href="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
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
                        <?php
                            if ($dadosMaterial == 0) {
                                echo '<h1 class="page-header text-overflow">Cadastro de Materiais</h1>';
                            } else {
                                echo '<h1 class="page-header text-overflow">Editar Material</h1>';
                            }
                        ?>
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    
                    <div id="page-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-horizontal" id="form_process">
                                    <input type="hidden" name="idMaterial" id="idMaterial" value="<?php echo $dadosMaterial['id_material'];?>">
                                    <div class="panel">
                                        <div id="menu_material"></div>
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Dados do Material</h3>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <div class="panel-body">Nome: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                                    <input type="text" class="form-control" name="nm_material" id="nm_material" value="<?php echo $dadosMaterial['nm_material'];?>" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="panel-body">Data de Aquisição:
                                                    <input type="text" class="form-control" name="data_aquisicao" id="data_aquisicao" value="<?php if ($dadosMaterial != 0) { if ($dadosMaterial['dt_aquisicao'] != 0) {echo Metodos::ConverteDataBR($dadosMaterial['dt_aquisicao']);} else {echo $dadosMaterial['dt_aquisicao'];}} else {echo $dadosMaterial['dt_aquisicao'];}?>" placeholder="99/99/9999" data-mask="99/99/9999">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="panel-body">Garantia: <span class="text-danger">(Qt. em meses)</i></span>
                                                    <input class="form-control" type="number" name="qt_garantia" id="qt_garantia" min="0" value="<?php echo $dadosMaterial['qt_meses_garantia'];?>" placeholder="10 meses">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <div class="panel-body">Unidade de Medida: <span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                                    <input type="hidden" name="idUnidadeMedida" id="idUnidadeMedida" value="<?php echo $dadosMaterial['id_unidade_medida'];?>">
                                                    <select class="form-control" name="id_unidade_medida" id="id_unidade_medida">
                                                        <option value="0">Selecione uma unidade de medida</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="panel-body">N° Patrimônio:
                                                    <input type="text" class="form-control" name="nm_patrimonio" id="nm_patrimonio" placeholder="" value="<?php echo $dadosMaterial['nr_patrimonio'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="panel-body">Valor:
                                                    <input class="form-control" type="text" name="valor" id="valor" placeholder="1.000.000,00" value="<?php if ($dadosMaterial != 0) {echo number_format($dadosMaterial['vl_preco'], 2, ',', '.');} else {echo $dadosMaterial['vl_preco'];}?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Dados da Máquina</h3>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <div class="panel-body">Modelo:
                                                    <input type="text" class="form-control" name="ds_modelo" id="ds_modelo" placeholder="" value="<?php echo $dadosMaterial['ds_modelo'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="panel-body">Fonte:
                                                    <input class="form-control" type="number" min="0" name="ds_fonte" id="ds_fonte" placeholder="100W" value="<?php echo $dadosMaterial['qt_fonte'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="panel-body">Descrição do Processador:
                                                    <input class="form-control" type="text" name="ds_processador" id="ds_processador" value="<?php echo $dadosMaterial['ds_processador'];?>">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <div class="panel-body">Marca:
                                                    <input type="text" class="form-control" name="ds_marca" id="ds_marca" placeholder="" value="<?php echo $dadosMaterial['ds_marca'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="panel-body">Qt. HD:
                                                    <input class="form-control" type="number" name="ds_hd" id="ds_hd" min="0" placeholder="100GB" value="<?php echo $dadosMaterial['qt_hd'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="panel-body">Wireless:
                                                    <select class="form-control" name="ds_wireless" id="ds_wireless">
                                                        <?php
                                                            if ($dadosMaterial != 0) {
                                                                if ($dadosMaterial['fl_wireless'] == 1) {
                                                                    echo $edita = '<option value="0">Máquina possui Wirelles?</option>
                                                                                   <option value="1" selected>Sim</option>
                                                                                   <option value="2">Não</option>';
                                                                } elseif ($dadosMaterial['fl_wireless'] == 2) {
                                                                    echo $edita = '<option value="0">Máquina possui Wirelles?</option>
                                                                                   <option value="1">Sim</option>
                                                                                   <option value="2" selected>Não</option>';
                                                                }
                                                            } else {
                                                                echo $edita = '<option value="0">Máquina possui Wirelles?</option>
                                                                               <option value="1">Sim</option>
                                                                               <option value="2">Não</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">
                                                <div class="panel-body"> Estado<span class="text-danger"><i class="glyphicon glyphicon-asterisk"></i></span>
                                                    <select class="form-control" name="tp_estado" id="tp_estado">
                                                        <?php
                                                            if ($dadosMaterial == 0) {
                                                                echo '<option value="0">Selecione um estado</option>
                                                                      <option value="1">Novo</option>
                                                                      <option value="2">Velho</option>';
                                                            } else {
                                                                if ($dadosMaterial['tp_estado'] == 1) {
                                                                    echo '<option value="0">Selecione um estado</option>
                                                                          <option value="1" selected>Novo</option>
                                                                          <option value="2">Velho</option>';
                                                                } elseif ($dadosMaterial['tp_estado'] == 2) {
                                                                    echo '<option value="0">Selecione um estado</option>
                                                                          <option value="1">Novo</option>
                                                                          <option value="2" selected>Velho</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="panel-body">QT. Memória Ram:
                                                    <input type="number" class="form-control" name="qt_memoria_ram" min="0" id="qt_memoria_ram" placeholder="100GB" value="<?php echo $dadosMaterial['qt_memoria_ram'];?>">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="panel-body">N° Serie:
                                                    <input class="form-control" type="text" name="nm_serie" id="nm_serie" placeholder=""  value="<?php echo $dadosMaterial['nm_serie'];?>">
                                                </div>
                                            </div>
                                        </div>
                                        <br><hr>
                                        <div class="form-group">
                                            <div class="col-md-4"></div>
                                            <?php 
                                                if ($dadosMaterial == 0){
                                                    echo '
                                                            <div class="col-md-2 text-center">
                                                                <button  type="button" class="btn btn-success btn-rounded btn-block btn-salvar" title="Salvar">
                                                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                                                </button>
                                                            </div>
                                                            <div class="col-md-2 text-center">
                                                                <button  type="button" class="btn btn-default btn-limpar btn-block btn-rounded" title="Limpar">
                                                                    <i class="glyphicon glyphicon-erase" aria-hidden="true"></i> Limpar
                                                                </button>
                                                            </div>';
                                                } else {
                                                    echo '
                                                            <div class="col-md-2 text-center">
                                                                <button  type="button" class="btn btn-success btn-rounded btn-block btn-atualizar" title="Atualizar">
                                                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Atualizar
                                                                </button>
                                                            </div>
                                                            <div class="col-md-2 text-center">
                                                                <button  type="button" class="btn btn-default btn-cancelar btn-block btn-rounded" title="Cancelar">
                                                                    <i class="glyphicon glyphicon-remove" aria-hidden="true"></i> Cancelar
                                                                </button>
                                                            </div>';
                                                }
                                            ?>
                                            <div class="col-md-4"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--===================================================-->
            <!--END CONTENT CONTAINER-->

            <!--MENU LATERAL-->
            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/menuLateral.php";
            ?>
            <!--END MENU LATERAL-->

            <!-- FOOTER -->
            <?php
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/rodape.php";
            ?>
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
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <script src="/assets/js/cha/administracao/material/newMaterial/material.js"></script>
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
        <script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <!--Select2-->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <!-- END JAVASCRIPT -->
    </body>
</html>

