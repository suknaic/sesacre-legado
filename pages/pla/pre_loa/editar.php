<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/pla/pre_loa/editar.load.php";
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

            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; 
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
                        <h1 class="page-header text-overflow">Editar/Desativar Prévia-LOA <?php echo $ano; ?></h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    <ol class="breadcrumb">
                        <li><a href="index.php?token=<?php echo $ano; ?>">Voltar</a></li>                        
                    </ol>

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <input type="hidden" id="ano" value="<?php echo $ano; ?>" />
                        
                        <div class="panel"> 
                            <div class="panel-body">                                                                                                                                                                       
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span class="text-main text-semibold">
                                                    Aqui poderá ser feita a Alteração ou Desativação da Prévia-LOA Ativa de <?php echo $ano; ?><br>
                                                    Somente poderá ser Feita Alteração da Prévia-LOA que está com o Planejamento(Criada)
                                                    ou quando for Retornada em algum momento de suas autorizações.<br>
                                                    Caso deseje criar uma Nova Prévia-LOA, deverá desativar esta primeira.<br>
                                                    Para Editar Algum Valor, basta clicar encima do Valor. Os Totais(Em Negrito) será calculado automaticamente.
                                                </span>                                                                                                                                                
                                            </div>
                                        </div>                                                                                                            
                                <!-- End <div class="form-group"> -->                                       
                            </div>
                        </div>             
                        <div style="margin-bottom: 10px;">
                            <button class="btn btn-primary btn-rounded btn-add">Adicionar Novo Valor</button>
                            <button class="btn btn-danger btn-rounded" data-toggle="modal" data-target="#modalDesativar">Desativar Prévia-LOA</button>
                        </div>
                        <div id="informacao">
                        </div>                                                
                        
                        <div class="modal fade"
                            tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel"
                            id="modalDesativar"
                            data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Confirmação de Desativação</h4>                                                                                                                                        
                                    </div>
                                    <div class="modal-body">
                                        <p>Quando esta Prévia-LOA for desativada, poderá ser criada uma nova Prévia-LOA para o ano de <?php echo $ano;?>.</p>
                                        <p><strong>ESTÁ AÇÃO É IRREVERSÍVEL.</strong></p>
                                        <p>Caso deseje Desativar a Prévia-LOA, clique no Botão <strong class="text-danger">Desativar Prévia-LOA</strong>.</p>
                                        <p>Poderá digitar alguma informação com relação a Prévia-LOA.</p>
                                        <textarea class="form-control modalMsgEnvio" rows="4"></textarea>   
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Fechar</button>                                        
                                        <button type="button" class="btn btn-danger btn-rounded btn-desativar">Desativar Prévia-LOA</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade"
                            tabindex="-1" role="dialog"
                            aria-labelledby="mySmallModalLabel"
                            id="modalValor"
                            data-keyboard="false">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close"
                                                data-dismiss="modal"
                                                aria-label="Close"><span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Valores da Prévia-LOA</h4>                                                                                                                                        
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal form">                                                                                
                                            <div class="panel-body">                                                                               
                                                <div class="form-group">
                                                    
                                                    <div class="col-md-6">
                                                        <div class="panel-body">
                                                            <label for="programa">
                                                                <?PHP echo STR_FUNCIONAL_PROGRAMATICA; ?>: <span class="text-danger">*</span>
                                                            </label>                                                        
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <p class="fa fa-list inputPFa"></p>
                                                                </span>
                                                                <select id="programa" class="form-control">
                                                                    <?php echo $selectProgTrab; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>                                                                                                

                                                    <div class="col-md-6">
                                                        <div class="panel-body">
                                                            <label for="despesa">
                                                                <?php echo STR_DESPESA_ELEMENTO; ?>: <span class="text-danger">*</span>
                                                            </label>                                                        
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <p class="fa fa-list inputPFa"></p>
                                                                </span>
                                                                <select id="despesa" class="form-control">                                                                                                                              
                                                                    <?php echo $selectElemDespesa; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="panel-body">
                                                            <label for="fonte">
                                                                Fonte: <span class="text-danger">*</span>
                                                            </label>                                                        
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <p class="fa fa-list inputPFa"></p>
                                                                </span>
                                                                <select id="fonte" class="form-control">   
                                                                    <?php echo $selectFontes; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <div class="panel-body">
                                                            <label for="valor">
                                                                Valor: <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <p class="fa fa-usd inputPFa"></p>
                                                                </span>
                                                                 <input type="text" class="form-control" name="valor" id="valor" required="true">
                                                            </div>
                                                        </div>
                                                    </div>  
                                                    
                                                </div>                                                                                                                                                                                       
                                            </div>                                                                            
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default btn-rounded" data-dismiss="modal">Fechar</button>                                                                                
                                        <button type="button" class="btn btn-danger btn-rounded btn-remover" value="0" style="display: none;">Remover</button>                                        
                                        <button type="button" class="btn btn-success btn-rounded btn-salvar" value="0">Salvar</button>                                        
                                    </div>
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
        
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>        
        <!--MaskedInput-->
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!--Input valor priceformat-->
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
        <script src="/assets/js/pla/pre_loa/editar.js"></script>
           
        <!-- END JAVASCRIPT -->

    </body>
</html>
