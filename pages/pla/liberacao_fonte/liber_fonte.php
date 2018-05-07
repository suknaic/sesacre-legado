<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/pla/liberacao_fonte/liber_fonte.load.php";
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
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Liberação por Fonte Para as Unidades/Departamentos/Setores</h1> 
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    
                    <!--End page title-->
                    <ol class="breadcrumb">
                        <li><a href="index.php">Voltar</a></li>                        
                    </ol>

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        

                        <input type="hidden" name="liberacaoFonte" id="liberacaoFonte" value="<?php echo $idLiberacaoFonte; ?>" />
                        <input type="hidden" name="ano" id="ano" value="<?php echo $liberacaoFonte->getAaLiberacaoFonte(); ?>" />
                        <input type="hidden" name="fonte" id="fonte" value="<?php echo $liberacaoFonte->getIdFonte(); ?>" />
                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel">                                    
                                    <!--Horizontal Form-->
                                    <!--===================================================-->
                                    <form class="form-horizontal formDados">
                                        <div class="panel-body">
                                            <div class="form-group">    
                                                <div class="panel-body">
                                                    <div class='row'>
                                                        <div class='col-sm-2'><b>Fonte:</b></div>
                                                        <div class='col-sm-9'><?php echo $liberacaoFonte->getNrFonte(); ?></div>
                                                    </div>
                                                    <div class='row'>
                                                        <div class='col-sm-2'><b>Ano:</b></div>
                                                        <div class='col-sm-9'><?php echo $liberacaoFonte->getAaLiberacaoFonte(); ?></div>
                                                    </div>
                                                    <div class='row'>
                                                        <div class='col-sm-2'><b>Valor Total:</b></div>
                                                        <div class='col-sm-9'>R$ <?php echo $liberacaoFonte->getVlLiberacaoFonte(); ?></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">                                            
                                                    <label for="programa">
                                                        <?php echo STR_FUNCIONAL_PROGRAMATICA; ?>: <span class="text-danger">*</span>
                                                    </label>                                                       
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="programa" class="form-control">                                                                                                                    
                                                            <?php
                                                                echo $selectProgramaTrabalho;
                                                            ?>
                                                        </select>
                                                    </div>                                            
                                                </div>                                        
                                                <div class="col-md-3">                                            
                                                        <label for="lotacao">
                                                            <?php echo STR_LOTACAO; ?>: <span class="text-danger">*</span>
                                                        </label>                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="lotacao" class="form-control">                                                                                                                    
                                                                <?php
                                                                    echo $selectLotacao;
                                                                ?>
                                                            </select>
                                                        </div>                                            
                                                </div>                                        
                                                <div class="col-md-3">                                            
                                                        <label for="despesa">
                                                            <?php echo STR_DESPESA_ELEMENTO; ?>: <span class="text-danger">*</span>
                                                        </label>                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-list inputPFa"></p>
                                                            </span>
                                                            <select id="despesa" class="form-control">                                                                                                                    
                                                                <?php
                                                                    echo $selectDespesa;
                                                                ?>
                                                            </select>
                                                        </div>                                            
                                                </div>  
                                                <div class="col-md-3">                                                    
                                                    <label for="valor">
                                                        Valor Limite: <span class="text-danger">*</span>
                                                    </label>                                                                
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-usd inputPFa"></p></span>
                                                        <input class="form-control" type="text" name="valor"
                                                               id="valor" required>
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
                                                <i class="fa fa-floppy-o" aria-hidden="true"></i> <span id="txtBtn">Salvar Valor Inicial</span>
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
                        
                        
                        <div class="modal fade"
                            tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel"
                            id="modalSuplementado"
                            data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Suplementar, Adicionar Recurso</h4>                                                                                                                                        
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal form">                                                                                                                                                                                                     
                                                <div class="form-group">                                                                                                                                                            
                                                    <div class="panel-body">
                                                        <div class='row'>
                                                            <div class='col-sm-2'><b>Local:</b></div>
                                                            <div class='col-sm-9 local_suple'>asd</div>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-sm-2'><b>Programa:</b></div>
                                                            <div class='col-sm-9 programa_suple'>asd</div>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-sm-2'><b>Despesa:</b></div>
                                                            <div class='col-sm-9 despesa_suple'>asd</div>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-sm-2'><b>Inicial:</b></div>
                                                            <div class='col-sm-9 inicial_suple'>asd</div>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-sm-2'><b>Suplementado:</b></div>
                                                            <div class='col-sm-9 suplementado_suple'>asd</div>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-sm-2'><b>Total:</b></div>
                                                            <div class='col-sm-9 total_suple'>asd</div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                       
                                                        <label for="">
                                                            Valor: <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <p class="fa fa-usd inputPFa"></p>
                                                            </span>
                                                             <input type="text" class="form-control valor valorSuplementado" name="valor" required="true">
                                                        </div>
                                                        
                                                    </div>  
                                                    
                                                </div>                                                                                                                                                                                       
                                                                                                                        
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Fechar</button>                                                                                                                        
                                        <button type="button" class="btn btn-success btn-rounded btn-salvar-suplementacao" value="0">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Adicionar Recurso
                                        </button>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="modal fade"
                            tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel"
                            id="modalReduzido"
                            data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Reduzir Recurso</h4>                                                                                                                                        
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal form">                                                                                                                                                                                                     
                                                <div class="form-group">                                                                                                                                                            
                                                    <div class="panel-body">
                                                        <div class='row'>
                                                            <div class='col-sm-4'><b><?php echo STR_LOTACAO; ?>:</b></div>
                                                            <div class='col-sm-8 local_suple'>asd</div>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-sm-4'><b>Funcional Programática:</b></div>
                                                            <div class='col-sm-8 programa_suple'>asd</div>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-sm-4'><b>Despesa:</b></div>
                                                            <div class='col-sm-8 despesa_suple'>asd</div>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-sm-4'><b>Inicial:</b></div>
                                                            <div class='col-sm-8 inicial_suple'>asd</div>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-sm-4'><b>Suplementado:</b></div>
                                                            <div class='col-sm-8 suplementado_suple'>asd</div>
                                                        </div>
                                                        <div class='row'>
                                                            <div class='col-sm-4'><b>Total:</b></div>
                                                            <div class='col-sm-8 total_suple'>asd</div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                       
                                                            <label for="">
                                                                Valor: <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <p class="fa fa-usd inputPFa"></p>
                                                                </span>
                                                                 <input type="text" class="form-control valor valorReduzido" name="valor" required="true">
                                                            </div>
                                                        
                                                    </div>  
                                                    
                                                </div>                                                                                                                                                                                       
                                                                                                                        
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Fechar</button>                                                                                                                        
                                        <button type="button" class="btn btn-danger btn-rounded btn-salvar-reduzido" value="0">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Reduzir Recurso
                                        </button>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                                                                                            
                                           
                         <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Valores</h3>
                            </div>
                            <div class="panel-body">
                                <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="tabela" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>                                                        
                                                        <th><?php echo STR_LOTACAO; ?></th>  
                                                        <th><?php echo STR_FUNCIONAL_PROGRAMATICA; ?></th>
                                                        <th><?php echo STR_DESPESA_ELEMENTO; ?></th>                                                                                                                                                                      
                                                        <th>Inicial</th>
                                                        <th>Suplementado</th>
                                                        <th>Reduzido</th>
                                                        <th>Atualizado</th>
                                                        <th class="text-center">Ações</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                                                                                                                                                                                                             
                                                </tbody>
                                                <tfoot>
                                                    
                                                </tfoot>
                                            </table>            
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">Situação dos Valores Liberado, QDD e PAS/PTA</h3>
                            </div>
                            <div class="panel-body">
                                <button class="btn btn-primary btn-rounded" id="btn-situacao" type="button" value="0">
                                    <i class="fa fa-refresh" aria-hidden="true"></i> Carregar
                                </button>
                                
                                <div id="situacao">
                                    
                                </div>
                                
                            </div>
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
        <!--Input valor priceformat-->
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/js/pla/liberacao_fonte/liber_fonte.js"></script>
           
        <!-- END JAVASCRIPT -->

    </body>
</html>
