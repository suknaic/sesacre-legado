<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/compras/ata/edit.load.php";
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
        <!--DataTables [ OPT ]-->
        <link href="/assets/lib/template/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.dataTables.min.css" rel="stylesheet">
        <link href="/assets/lib/template/plugins/datatables/extensions/buttons/css/buttons.bootstrap.min.css" rel="stylesheet">
        <!--Datapicker-->
        <link href="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet">
        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css" rel="stylesheet">
    </head>
    <!--TIPS-->
    <!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-sm">
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
                    <!--Modal itens content-->
                    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalItem" data-keyboard="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Busca de Licitação</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mar-btm">
                                        <input type="text" id="codItemPesquisa" placeholder="Número da Licitação" class="form-control">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" id="btn-pesquisa">
                                                <i class="fa fa-search" aria-hidden="true"></i> Pesquisar
                                            </button>
                                        </span>
                                    </div>

                                    <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table id="tabelaItens" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>ADA/CPR</th>
                                                            <th>Licitação</th>
                                                            <th>Tipo de gasto</th>
                                                            <th>Objeto</th>
                                                            <th>Modalidade</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <form data-toggle="validator" class="form-horizontal" id="form-documento" role="form" action="#" method="post">
                            <input type="hidden" name="idFornecedor" id="idFornecedor" value="<?php echo $id;?>"/>
                            <input type="hidden" name="idContrato" id="idContrato" value="<?php echo $array[0]["id_contrato"];?>"/>
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Informações da ATA</h3>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Pesquisa licitação:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="text" name="itemGrp" id="itemGrp" disabled />
                                                <span class="input-group-btn pesquisaItem" data-target="#modalItem" data-toggle="modal">
                                                    <button type="button" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-bordered-success">
                                    <div class="panel-body">
                                        <input type="hidden" id="id_processo" value="<?php echo $array[0]["id_processo"];?>" />
                                        <p><strong>ADA/CPR:</strong> <span id="ada_cpr"><?php echo $array[0]["cd_ada_cpr"];?></span></p>
                                        <p><strong>Licitação:</strong> <span id="licitacao"><?php echo $array[0]["cd_pregao"];?></span></p>
                                        <p><strong>Tipo de gasto:</strong> <span id="tipoGasto"><?php echo $array[0]["nm_tipo_gasto"];?></span></p>
                                        <p><strong>Objeto:</strong> <span id="obejto"><?php echo $array[0]["nm_objeto"];?></span></p>
                                        <p><strong>Modalidade:</strong> <span id="modalidade"> <?php echo $array[0]["nm_modalidade"];?></span></p>
                                        <p><strong>Área de Abrangência:</strong> <span id="area_abragencia"></span></p>
                                        <p><strong>Unidades Contempladas:</strong> <span id="unidade"></span></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Nº da ata:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="text" name="num_ata" id="num_ata" value="<?php echo $array[0]["nr_contrato"];?>" required="true" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Data de assinatura:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control data" type="text" name="data_assinatura" id="data_assinatura" value="<?php echo Metodos::ConverteDataBR($array[0]["dt_assinatura"]);?>" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Data de publicação:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control data" type="text" name="data_publicacao" id="data_publicacao" value="<?php echo Metodos::ConverteDataBR($array[0]["dt_publicacao"]);?>" required="true" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Vigência inicial:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control data" type="text" name="vig_inicial" id="vig_inicial" value="<?php echo Metodos::ConverteDataBR($array[0]["dt_ini_vigencia_contrato"]);?>" required="true" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            Vigência final:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-calendar" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control data" type="text" name="vig_final" id="vig_final" value="<?php echo Metodos::ConverteDataBR($array[0]["dt_fim_vigencia_contrato"]);?>" required="true" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6"></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <div class="panel-body">
                                            Descrição do objeto:<span class="text-danger">*</span>
                                            <textarea class="form-control" rows="4" id="desc_objeto"><?php echo $array[0]["ds_objeto"];?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="panel-body">
                                            Observações da ATA:
                                            <textarea class="form-control" rows="4" id="obs_ata"><?php echo $array[0]["ds_obs_contrato"];?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-heading">
                                    <h3 class="panel-title">Informações do contratado</h3>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="panel-body">
                                            <div class="radio">
                                                <label><input type="radio" id="cont_pj" value="1" name="contratado" checked>Pessoa juridica</label>
                                                <label><input type="radio" id="cont_pf" value="2" name="contratado">Pessoa Física</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-5">
                                        <div class="panel-body">
                                            Nome do contratado:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-list" style="margin-bottom: -4px"></p></span>
                                                <select class="form-control select" name="empresa" id="empresa" required="true">
                                                    <option value="">Selecione um contratado</option>
                                                    <?php echo $sesPessoaJuridicaModel::optionPessoaJuridica($array[0]["id_pessoa"]); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            CNPJ/CPF:<span class="text-danger">*</span>
                                            <div class="input-group">
                                                <span class="input-group-addon"><p class="fa fa-sort-numeric-asc" style="margin-bottom: -4px"></p></span>
                                                <input class="form-control" type="text" name="cnpj" id="cnpj" required="true" disabled value="<?php echo $cnpj->msg;?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4"></div>
                                </div>

                                <div id="orgao"></div>

                                <div class="panel-heading">
                                    <h3 class="panel-title">Centrais</h3>
                                </div>
                                <div class="campoCentrais">
                                    <?php echo $campoCentral;?>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3">
                                        <div class="panel-body">
                                            <a href="#" class="addCentrais btn btn-info">+</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-9"></div>
                                </div>

                            </div>

                            <div id="doc_botao">
                                <button class="btn btn-default btn-info btn-rounded btn-editar btn-block" type="button">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar Edição
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
        <!--DataTables [OPT]-->
        <script src="/assets/lib/template/plugins/datatables/media/js/jquery.dataTables.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/js/compras/gestao_contratos/edit_ata.js"></script>
    </body>
</html>
