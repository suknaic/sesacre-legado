<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/pla/ordem_entrega/ordem.load.php";
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
                        <h1 class="page-header text-overflow">Recebimento da Ordem de Entrega</h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->
                    <ol class="breadcrumb">
                        <li class="active"><a href="index.php">Voltar</a></li>                        
                    </ol>
                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <div id="menu_pta">
                            <div id="divMenu" style="display: none;">
                                <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/pla/central/menuCentral.php";  ?>
                            </div>
                        </div>
                        <!-- Inicio Form -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel">                                                                        
                                    <!--Horizontal Form-->
                                    <!--===================================================-->
                                    <form class="form-horizontal formDados">                                        
                                        <div class="panel-body">                                           
                                            <div class="form-group">                                                
                                                <div class="panel-body"  style="font-size:15px;">
                                                    <div class="row">
                                                        <div class="col-sm-2"><b>Ordem de Entrega:</b></div>
                                                        <div class="col-sm-3">84/2017</div>
                                                        <div class="col-sm-2"><b>ADA:</b></div>
                                                        <div class="col-sm-4">19-17-0021829</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-2"><b>Central de Demanda:</b></div>
                                                        <div class="col-sm-3">Divisão de Almoxarifado</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-2"><b>Elemento de Despesa:</b></div>
                                                        <div class="col-sm-3">3.3.90.30 - Material de Consumo</div>                                                        
                                                        <div class="col-sm-2"><b>Fonte:</b></div>
                                                        <div class="col-sm-4">400</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-2"><b>Pregão:</b></div>
                                                        <div class="col-sm-3">0720/2016 - Aquisição refeição preparada</div> 
                                                        <div class="col-sm-2"><b>Ata:</b></div>
                                                        <div class="col-sm-4">0014/2017</div>                                                        
                                                                                                         
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-2"><b>Fornecedor:</b></div>
                                                        <div class="col-sm-3">SOUZA & PASTOR LTDA</div>  
                                                        <div class="col-sm-2"><b>CNPJ:</b></div>
                                                        <div class="col-sm-4">34.710.145/0001-06</div>                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-2"><b>Empenho:</b></div>
                                                        <div class="col-sm-3">7216071276/2017</div>                                                            
                                                        <div class="col-sm-2"><b>Portaria:</b></div>
                                                        <div class="col-sm-4">Portaria nº 1864/03</div>
                                                    </div>                                                                                 
                                                </div>                                                                                                                                                                                                                                                                                                                                   
                                            </div>
                                            <!-- End <div class="form-group"> -->                                       
                                        </div>
                                        <!-- <div class="panel-body"> -->
                                    </form>
                                    <!--===================================================-->
                                    <!--End Horizontal Form-->

                                </div>
                            </div>
                        </div>
                        <!-- Fim Form -->
                        
                        <div class="panel">
                            <div class="panel-heading ">
                                <h3 class="panel-title">Itens Contidos Na Ordem</h3>
                            </div>

                            <!--Horizontal Form-->
                            <!--===================================================-->
                            <form class="form-horizontal form">                                                                       
                                <div class="panel-body">
                                    <div class="form-group">
                                         <div class="panel-body">
                                            <table  width="100%" align="center" class="table table-bordered">
                                                <thead>
                                                    <tr>                                                        
                                                        <th rowspan="2">Item</th>
                                                        <th rowspan="2">Produto</th>
                                                        <th colspan="2" class="text-center">Entregas</th>           
                                                        <th colspan="3" class="text-center">Solicitação</th>
                                                    </tr>
                                                    <tr>       
                                                        <th>Qtd Entregas</th>
                                                        <th>Qtd Total</th>           
                                                        <th>Quantidade</th>
                                                        <th>Valor Unitário</th>
                                                        <th>Valor Total</th>
                                                    </tr>
                                                </thead>  
                                                <tbody>
                                                    <tr>                                                        
                                                        <td style="text-align: center">1</td>
                                                        <td>200058866 - REFEICAO PRONTA ACONDICIONADA EM EMBALAGEM TERMICA DESCARTVEL COM TRES DIVISORIAS; COMPO</td>
                                                        <td style="text-align: right">1</td>
                                                        <td style="text-align: right">7.128,00</td>      
                                                        <td style="text-align: right">7.128,00</td>
                                                        <td style="text-align: right">16,20</td>
                                                        <td style="text-align: right">115.473,60</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6" style="text-align: right">Valor Total</td>
                                                        <td style="text-align: right">115.473,60</td>
                                                    </tr>
                                              </tbody>
                                            </table>
                                         </div>
                                    </div>


                                
                                </div>
                        


                                <!-- Footer Form -->
                               
                                <!-- End Form -->
                            </form>
                            <!--===================================================-->
                            <!--End Horizontal Form-->

                        </div>                                                                                  
                                           
                         <div class="panel">                           
                            <div class="panel-body">                                
                                    <div class="row">                                        
                                        <div class="col-md-4">
                                            <div class="panel-body">
                                                <label for="det">
                                                    Detalhamento da Ação:
                                                </label>                                                        
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-list inputPFa"></p>
                                                    </span>
                                                    <select id="det" class="form-control">                                                        
                                                        <?php
                                                            echo $select;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-6">
                                            <div class="panel-body">
                                                <label for="quantidade">
                                                    Quantidade: <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                    </span>
                                                     <input type="text" class="form-control quantidade" name="quantidade" required="true">
                                                </div>
                                            </div>
                                        </div>                                                                               
                                    </div>    
                                
                                    <div class="row">                                        
                                        <div class="col-md-4">
                                            <div class="panel-body">
                                                <label for="det">
                                                    Detalhamento da Ação:
                                                </label>                                                        
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-list inputPFa"></p>
                                                    </span>
                                                    <select id="det" class="form-control">                                                        
                                                        <?php
                                                            echo $select;
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-md-6">
                                            <div class="panel-body">
                                                <label for="quantidade">
                                                    Quantidade: <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <p class="fa fa-sort-numeric-asc inputPFa"></p>
                                                    </span>
                                                     <input type="text" class="form-control quantidade" name="quantidade" required="true">
                                                </div>
                                            </div>
                                        </div>                                                                               
                                    </div>   
                            </div>
                            <div class="panel-footer text-right">    
                                <button class="btn btn-primary btn-rounded btn-enviar-planejamento" type="button" >
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i> Receber
                                </button>
                                <button class="btn btn-danger btn-rounded btn-enviar-planejamento" type="button" >
                                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Não Receber
                                </button>                                                                         
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
        <!--MaskedInput-->
        <script src="/assets/lib/template/plugins/masked-input/jquery.maskedinput.min.js"></script>
        <!--Input valor priceformat-->
        <script src="/assets/lib/template/plugins/priceformat/Jquery.Price_Fromat.js"></script>
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/js/pla/ordem_entrega/ordem.js"></script>
           
        <!-- END JAVASCRIPT -->

    </body>
</html>
