<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/diarias/diaria/index.load.php";
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
         <!-- select2 -->
        <link href="/assets/lib/template/plugins/select2/css/select2.min.css" rel="stylesheet">

    </head>
    <!--TIPS-->

    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-lg">

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
                        <h1 class="page-header text-overflow">Cadastro de Proposta de Concessão de Diárias</h1>                       
                    </div>
                    <ol class="breadcrumb">
                        <li><a href="../">Voltar</a></li>                        
                    </ol>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <?php 
                            require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/diarias/shared/modalPesqCidade.html";
                            require_once $_SERVER['DOCUMENT_ROOT'] . "/pages/diarias/shared/modalAnexaArquivo.html";
                        ?>
                       

                        <form id="diariaForm">

                           <input type="hidden" id="id_diaria" value="<?php echo $id_diaria; ?>"/>
                           <input type="hidden" id="st_estagio" value="<?php echo $st_estagio; ?>"/>
                           
                          

                           <div class="panel">
                               <div class="panel-heading  text-center">
                                   <h2 class="panel-title">Dados da Solicitação da Diária</h2>
                               </div>
                               <div class="panel-body">
                                   <div class="row">
                                       <div class="col-sm-6">
                                           <div class="form-group">
                                               <label for="nr_protocolo">Nº Protocolo: <span class="text-danger">*</span></label>
                                               <div class="input-group">
                                                    <span class="input-group-addon">
                                                       <p class="fa fa-file-text-o inputPFa"></p>
                                                   </span>
                                                   <input type="text" id="nr_protocolo" class="form-control" value="<?php echo $nr_protocolo;?>"/>
                                                </div>
                                           </div>
                                       </div>
                                       <div class="col-sm-6">
                                           <div class="form-group">
                                                <label for="id_tipo">Tipo da diária: <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-list inputPFa"></p>
                                                    </span>
                                                    <select id="id_tipo" class="form-control">
                                                        <?php echo $selectTipoDiariaOption; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group" id="diaria_pai">
                                                <label for="id_diaria_pai">Diária principal: <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-list inputPFa"></p>
                                                    </span>
                                                    <select id="id_diaria_pai" class="form-control">
                                                        <?php echo $selectDiariaPaiOption; ?>
                                                    </select>
                                                </div>
                                            </div>
                                       </div>
                                   </div>
                                   <div class="row">
                                       <div class="col-md-6">
                                           <div class="form-group">
                                               <label for="id_pessoa_proponente">Proponente: <span class="text-danger">*</span></label>
                                               <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <p class="fa fa-list inputPFa"></p>
                                                   </span>
                                                   <select id="id_pessoa_proponente" class="form-control" >
                                                       <?php
                                                           echo $selectPessoaProponente;
                                                       ?>
                                                   </select>
                                               </div>
                                           </div>
                                           <div class="form-group">
                                               <label for="id_lotacao_proponente">Lotação Proponente: <span class="text-danger">*</span></label>
                                               <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <p class="fa fa-list inputPFa"></p>
                                                   </span>
                                                   <select id="id_lotacao_proponente" class="form-control">
                                                       <?php
                                                           echo $selectLotacaoProponente;
                                                       ?>
                                                   </select>
                                               </div>
                                           </div>
                                           <div class="form-group">
                                               <label for="id_funcao_proponente">Função Proponente: <span class="text-danger">*</span></label>
                                               <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <p class="fa fa-list inputPFa"></p>
                                                   </span>
                                                   <select id="id_funcao_proponente" class="form-control">
                                                       <?php
                                                           echo $selectFuncaoProponente;
                                                       ?>
                                                   </select>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <div class="form-group">
                                               <label for="id_pessoa_proposto">Proposto: <span class="text-danger">*</span></label>
                                               <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <p class="fa fa-list inputPFa"></p>
                                                   </span>
                                                   <select id="id_pessoa_proposto" class="form-control">
                                                       <?php
                                                           echo $selectPessoaProposto;
                                                       ?>
                                                   </select>
                                               </div>
                                           </div>
                                           <div class="form-group">
                                               <label for="id_lotacao_proposto">Lotação Proposto: <span class="text-danger">*</span></label>
                                               <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <p class="fa fa-list inputPFa"></p>
                                                   </span>
                                                   <select id="id_lotacao_proposto" class="form-control">
                                                       <?php
                                                           echo $selectLotacaoProposto;
                                                       ?>
                                                   </select>
                                               </div>
                                           </div>
                                           <div class="form-group">
                                               <label for="id_funcao_proposto">Função Proposto: <span class="text-danger">*</span></label>
                                               <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <p class="fa fa-list inputPFa"></p>
                                                   </span>
                                                   <select id="id_funcao_proposto" class="form-control">
                                                       <?php
                                                           echo $selectFuncaoProposto;
                                                       ?>
                                                   </select>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                   <div class="row">
                                       <div class="col-md-6">
                                           <div class="form-group">
                                               <label for="ds_servico_executado">Descrição do serviço executado: <span class="text-danger">*</span></label>
                                               <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <p class="fa fa-file-text-o inputPFa"></p>
                                                   </span>
                                                   <textarea id="ds_servico_executado" class="form-control"><?php echo $ds_servico_executado;?></textarea>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <div class="form-group">
                                               <label for="ds_locais_executado">Descrição dos locais: <span class="text-danger">*</span></label>
                                               <div class="input-group">
                                                   <span class="input-group-addon">
                                                       <p class="fa fa-file-text-o inputPFa"></p>
                                                   </span>
                                                   <textarea id="ds_locais_executado" class="form-control"><?php echo $ds_servico_executado;?></textarea>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="panel" id="viagem">
                               <div class="panel-heading  text-center">
                                   <h2 class="panel-title">Dados da Viagem</h2>
                                   <input type="hidden" id="id_diaria_destino" disabled />
                               </div>
                               <?php if ($session->vPDiariasSolicitacao() and $edita) {  ?>
                                    <div class="panel-body" id="destinoForm">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="id_cidade_inicio">Cidade de origem: <span class="text-danger">*</span></label>
                                                    <input type="hidden" id="id_cidade_inicio" readonly value="">
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" id="ds_cidade_inicio" readonly value="" />
                                                        <span class="input-group-btn abre-ModalCidade" data-target="#pesquisaCidade" data-toggle="modal" data-id="origem">
                                                            <button type="button" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="id_cidade_fim">Cidade de destino: <span class="text-danger">*</span></label>
                                                    <input type="hidden" id="id_cidade_fim" readonly value="">
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" id="ds_cidade_fim" readonly value=""/>
                                                        <span class="input-group-btn abre-ModalCidade" data-target="#pesquisaCidade" data-toggle="modal" data-id="destino">
                                                            <button type="button" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="dh_inicio">Horário da partida: <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-calendar inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control" name="dh_inicio" id="dh_inicio" required="true" value="<?php echo $dh_inicio ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="dh_fim">Horário da chegada: <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-calendar inputPFa"></p>
                                                        </span>
                                                        <input type="text" class="form-control" name="dh_fim" id="dh_fim" required="true" value="<?php echo $dh_fim ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="id_transporte">Meio de locomoção: <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="id_transporte" class="form-control">
                                                            <?php
                                                                echo $selectTransporteOption;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label for="fl_pernoite">Pernoite: </label>
                                                    <div class="input-group">
                                                        <input style="width: 25px; height: 25px;"  type="checkbox" id="fl_pernoite" <?php echo $fl_pernoite;?> /> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="estadual_nacional">Estadual ou Nacional: </label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input class="form-control"  type="text" id="estadual_nacional" readonly value="" /> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="id_decreto">Base Legal: <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="id_decreto" class="form-control">
                                                            <?php
                                                                echo $selectDecretoOption;
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="hidden" id="id_classe_default" value=""/>
                                                <div class="form-group">
                                                    <label for="id_classe">Classe: <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="id_classe" class="form-control">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="qt_diaria_destino">Quantidades de diária: <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input type="text" id="qt_diaria_destino" class="form-control decimal" value="<?php echo $qt_diaria_destino; ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="vl_diaria_destino">Valor unitário da diária: <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-file-text-o inputPFa"></p>
                                                        </span>
                                                        <input type="text" id="vl_diaria_destino" class="form-control decimal" value="<?php echo $vl_diaria_destino; ?>" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                             <button class="btn btn-rounded btn-default mar-ver pull-right btn-limpar">
                                                 Limpar
                                             </button>   
                                             <button class="btn btn-rounded btn-default mar-ver pull-right btn-cancelar">
                                                 Cancelar
                                             </button>  
                                             <button class="btn btn-rounded btn-primary mar-ver pull-right add-itinerario">
                                                 <i class="fa fa-plus-circle fa-1x" style="margin-right: 5px"></i>
                                                 Itinerário
                                             </button>                               
                                             <button class="btn btn-rounded btn-info mar-ver pull-right btn-editar">
                                                 <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar Edição
                                             </button>
                                        </div>
                                    </div>
                               <?php } ?>
                               <div class="panel-footer">
                                   <table class="table table-striped" id="itinerario">
                                       <thead>
                                           <tr>
                                               <th>Origem</th>
                                               <th>Destino</th>
                                               <th>Horário da Partida</th>
                                               <th>Horário de Chegada</th>
                                               <th>Valor total</th>
                                               <th></th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           <?php echo $linhasItinerario; ?>
                                       </tbody>
                                   </table>
                               </div>
                           </div>
                           
                           <div class="panel">
                               <div class="panel-heading  text-center">
                                   <h2 class="panel-title">Informações adicionais</h2>
                               </div>
                               <div class="panel-body">
                                   <div class="row">
                                        <div class="form-group">
                                            <label for="ds_obs">Observação: </label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-file-text-o inputPFa"></p>
                                                </span>
                                                <textarea id="ds_obs" class="form-control"><?php echo $ds_obs;?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="dt_criacao">Data da criação: <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-calendar inputPFa"></p>
                                                </span>
                                                <input type="text" class="form-control" name="dt_criacao" id="dt_criacao" value="<?php echo $dt_criacao; ?>" required="true">
                                            </div>
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_central_solicitante">Nome do Solicitante:</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon"><p class="fa fa-file-text-o inputPFa"></p></span>
                                                    <input class="form-control" type="text" id="id_pessoa_solicitante" readonly value="<?php echo $nm_usuario ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_central_solicitante">Central de Demanda do Solicitante: <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-list inputPFa"></p>
                                                    </span>
                                                    <select id="id_central_solicitante" class="form-control">
                                                        <?php
                                                            echo $selectCentralSolicitante;
                                                        ?>
                                                    </select>
                                               </div>
                                            </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           
                           <div class="panel">
                               <div class="panel-heading text-center">
                                   <h2 class="panel-title">Anexos</h2>
                               </div>
                               <div class="panel-body">
                                   <div class="row">
                                        <?php if ($session->vPDiariasSolicitacao()) {  ?>
                                            <strong>Arquivo:</strong>
                                            <button class="btn btn-rounded btn-primary btn-add-arquivo" data-target="#anexaArquivo" data-toggle="modal" type="button">
                                                <i class="fa fa-plus"></i> Adicionar
                                            </button>
                                        <?php } ?>
                                    </div>
                               </div>
                               <div class="panel-footer">
                                   <div class="row">
                                        <div id="arquivos">
                                            <?php echo $linhasAnexos; ?>
                                        </div>
                                   </div>
                                </div>
                           </div>
                           
                           <div id="observacoes">
                                <div class="panel">
                                    <div class="panel-heading text-center">
                                        <h2 class="panel-title">Histórico</h2>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <textarea id="historico" cols="250" rows="5" readonly class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           </div>
                           
                           <?php if ($session->vPDiariasSolicitacao()) {  ?>
                                <div class="text-center">
                                    <button id="salvar_diaria" class="btn btn-success btn-rounded btn-salvar" type="button">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                    </button>
                                    <a href="../" class="btn btn-rounded btn-default">Cancelar</a>
                                    <button id="enviar_diaria" class="btn btn-primary btn-rounded btn-enviar" type="button">
                                        <i class="fa fa-share-square" aria-hidden="true"></i> Enviar p/ Deferimento
                                    </button>
                                </div>
                           <?php } ?>
                       </form>

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
        <!--Datapicker-->
        <script src="/assets/lib/template/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
         <!-- select2 -->
        <script src="/assets/lib/template/plugins/select2/js/select2.min.js"></script>
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!--Input valor priceformat-->
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
        <script src="/assets/js/diarias/diaria/index.js"></script>
        <script src="/assets/js/diarias/anexo.js"></script>
        <script src="/assets/js/diarias/pesqCidade.js"></script>
        <!-- END JAVASCRIPT -->

    </body>
</html>



