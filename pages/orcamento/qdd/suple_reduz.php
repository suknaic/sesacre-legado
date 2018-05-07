<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/orcamento/qdd/suple_reduz.load.php";
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
                        <h1 class="page-header text-overflow">Suplementado e Reduzido do QDD <?php echo $ano; ?></h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <div id="menu_pta">
                            <?php                                 
                                require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/menus/orcamento/qdd/menuQdd.php";                                  
                            ?>
                        </div>
                        <div class="panel"> 
                            <div class="panel-body">                                
                                <div class="form-group">
                                    <input type="hidden" id="ano" value="<?php echo $ano; ?>" />                                    
                                    <!--Horizontal Form-->
                                    <!--===================================================-->
                                    <form class="form-horizontal form">    
                                        <div class="row" style="margin-bottom: 5px;">
                                            <div class="col-md-12">                                                
                                                <div class="radio">
                                                    <label><input type="radio" class="tipo" value="s" name="tipo" checked="">Suplementado</label>
                                                    <label><input type="radio" class="tipo" value="r" name="tipo">Reduzido</label>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Selecione o Registro a Ser <span id="spanPrimeiro">Suplementado</span></h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-6">                                            
                                                    <label for="programaTipo">
                                                        <?php echo STR_FUNCIONAL_PROGRAMATICA; ?>: <span class="text-danger">*</span>
                                                    </label>                                                        
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="programaTipo" class="form-control">                                                                                                                    
                                                            <?php
                                                                echo $selectProgramaTrabalho;
                                                            ?>
                                                        </select>
                                                    </div>                                            
                                                </div>   
                                                <div class="col-md-3">                                            
                                                    <label for="fonteTipo">
                                                        Fonte: <span class="text-danger">*</span>
                                                    </label>                                                        
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="fonteTipo" class="form-control">                                                                                                                    
                                                            <?php
                                                                echo $selectFonte;
                                                            ?>
                                                        </select>
                                                    </div>                                            
                                                </div>                                        
                                                <div class="col-md-3">                                            
                                                    <label for="despesaTipo">
                                                        <?php echo STR_DESPESA_ELEMENTO; ?>: <span class="text-danger">*</span>
                                                    </label>                                                        
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="despesaTipo" class="form-control">                                                                                                                    
                                                            <?php
                                                                echo $selectDespesa;
                                                            ?>
                                                        </select>
                                                    </div>                                            
                                                </div>
                                                <div class="col-md-3">                                                    
                                                    <label for="valorTipo">
                                                        Valor: <span class="text-danger">*</span>
                                                    </label>                                                                
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-dollar inputPFa"></p></span>
                                                        <input class="form-control valor" type="text" name="valorTipo" id="valorTipo" required>
                                                    </div>                                                   
                                                </div> 
                                            </div>
                                        </div>
                                        
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">Adicione os Registros a Serem <span id="spanSegundo">Reduzidos</span></h4>
                                            </div>
                                            <div class="panel-body">
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
                                                    <label for="fonte">
                                                        Fonte: <span class="text-danger">*</span>
                                                    </label>                                                        
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <p class="fa fa-list inputPFa"></p>
                                                        </span>
                                                        <select id="fonte" class="form-control">                                                                                                                    
                                                            <?php
                                                                echo $selectFonte;
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
                                                    <label for="valorTipo">
                                                        Valor: <span class="text-danger">*</span>
                                                    </label>                                                                
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><p class="fa fa-dollar inputPFa"></p></span>
                                                        <input class="form-control valor" type="text" name="valor" id="valor" required>
                                                    </div>                                                   
                                                </div> 
                                                <div class="col-md-3">                                                    
                                                    <label for="">                                                   
                                                    </label>                                                                
                                                    <div class="input-group">
                                                        <button class="btn btn-primary btn-rounded btn-add" type="button">
                                                            <i class="fa fa-plus fa-lg" aria-hidden="true"></i> Adicionar
                                                        </button>
                                                    </div>                                                   
                                                </div> 
                                                <div class="col-md-12">
                                                    <div class="panel-body" >                                
                                                        <div class="form-group">
                                                            <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <table id="registros" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th><?php echo STR_FUNCIONAL_PROGRAMATICA; ?></th>
                                                                                    <th>Fonte</th>
                                                                                    <th><?php echo STR_DESPESA_ELEMENTO; ?></th> 
                                                                                    <th>Valor</th> 
                                                                                    <th>Remover</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                            </tbody>
                                                                        </table>            
                                                                    </div>
                                                                </div>
                                                            </div>                                        
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 5px;">
                                            <div class="col-md-8">                                                                                                                                                                                                            
                                                <label for="obs">
                                                    Observação:
                                                </label>
                                                <textarea class="form-control" rows="4" name="obs" id="obs" required="true"></textarea>                                                                                                   
                                            </div>
                                        </div>                                                                                                                                                           
                                        <!-- <div class="panel-body"> -->                                                                                
                                    </form>
                                    <!--===================================================-->
                                    <!--End Horizontal Form-->                                                                                
                                </div>
                                <!-- End <div class="form-group"> -->                                                                     
                                                                
                            </div>
                            <!-- Footer Form -->
                            <div class="panel-footer text-right">                                 
                                <button class="btn btn-success btn-rounded btn-salvar" type="button">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar
                                </button>
                            </div>
                            <!-- End Form -->
                        </div>
                        
                        <div class="panel-body selecaoAno" style="display: none;">                                
                            <div class="form-group">
                                <div class="panel-body" >                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="anoSelect">
                                                Ano:
                                            </label>                                                        
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <p class="fa fa-list inputPFa"></p>
                                                </span>
                                                <select id="anoSelect" class="form-control anoSelect">
                                                    <option value="0">Selecione um Ano</option>                                                                
                                                    <?php
                                                        echo Metodos::retornaAnosSelect(date("Y"));
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                                                                                                                                                                                                                                                                               
                            </div>
                            <!-- End <div class="form-group"> -->                                       
                        </div>
                        
                                               
                       
                        
                        

                    </div>
                    <!--===================================================-->
                    <!--End page content-->
                   <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Transações Realizadas</h3>
                        </div>
                        <div class="panel-body">
                            <div id="demo-dt-basic_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="tabela" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-left">Data</th>
                                                    <th class="text-center">Ação</th>
                                                    <th class="text-left">Usuário</th> 
                                                    <th class="text-left">Origem</th> 
                                                    <th class="text-left">Destino</th>
                                                    <th class="text-center">Validação</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>            
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

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
        <script src="/assets/js/orcamento/qdd/suple_reduz.js"></script>
           
        <!-- END JAVASCRIPT -->

    </body>
</html>
