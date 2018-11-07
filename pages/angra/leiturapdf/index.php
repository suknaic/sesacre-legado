<!DOCTYPE html>
<?php
require_once "index.load.php";
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
        
        <!--JSTree [ OPTIONAL ]-->
        <link href="/assets/lib/jstree/dist/themes/default/style.css" rel="stylesheet">                
        
        <!-- Font Awesome [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/lib/template/plugins/font-awesome/css/font-awesome.min.css">
        <!-- themify icons [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/lib/template/plugins/themify-icons/themify-icons.min.css">  
        <!-- ion icons [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/lib/template/plugins/ionicons/css/ionicons.min.css">
        
        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css">
        
        <link rel="stylesheet" href="index.css">
       
    </head>
    <!--TIPS-->

    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-lg">

            <?php
            //Cabeçalho do Sistema
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php";
            ?>

            <div class="boxed">

                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">

                    <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <div id="page-title">
                        <h1 class="page-header text-overflow"></h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">                                              
                        <div class="panel_pdf" id="panel_pdf">                                                 
                            <embed src="" width="600" height="500" alt="pdf" class="embed_pdf" >                         
                        </div>

                    </div>
                    <!--===================================================-->
                    <!--End page content-->
                </div>
                <!--===================================================-->
                <!--END CONTENT CONTAINER-->

                <nav id="mainnav-container" xmlns="http://www.w3.org/1999/html">
                    <div id="mainnav">
                        <!--Menu-->
                        <!--================================-->
                        <div id="mainnav-menu-wrap">
                            <div class="nano">
                                <div class="nano-content">
                                    <ul  class="list-group">
                                        <!--Category name-->
                                        <li class="list-header">Navegação</li>
                                        <!--Menu list Dashboard-->                                        
                                        <div class="panel">                                                                                        
                                            <div id="demo-jstree-json">                                                    
                                                <div id="jstree">                                           
                                                    <ul>
                                                        <li data-jstree='{"opened":true}'>Arquivo Pessoa
                                                            <ul>                                                                
                                                                <li data-jstree='{"icon":"glyphicon glyphicon-file", "info": "3", "nome_arquivo": "RG e CPF"}' 
                                                                    title="RG e CPF">
                                                                    RG e CPF
                                                                </li>
                                                            </ul>
                                                        </li>                                                        
                                                        <li data-jstree='{"opened":true}'>Arquivo do TFD
                                                            <ul>
                                                                <li data-jstree='{"icon":"glyphicon glyphicon-file", "info":"3", "nome_arquivo": "Arquivo 3"}'
                                                                    title="Arquivo 3">
                                                                    Arquivo 3
                                                                </li>
                                                                <li data-jstree='{"icon":"glyphicon glyphicon-file", "info":"2", "nome_arquivo": "Arquivo 2"}'
                                                                    title="Arquivo 2">
                                                                    Arquivo 2
                                                                </li>
                                                                <li data-jstree='{"icon":"glyphicon glyphicon-file", "info":"1", "nome_arquivo": "Arquivo 1"}'
                                                                    title="Arquivo 1">
                                                                    Arquivo 1
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div> 
                                            </div>                                           
                                        </div>                                                                                           
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--================================-->
                        <!--End menu-->
                    </div>
                </nav>
            </div>

            <!-- FOOTER -->
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/rodape.php"; ?>
            <!-- END FOOTER -->
         

        </div>
        <!--===================================================-->
        <!-- END OF CONTAINER -->

       

        <!--jQuery [ REQUIRED ]-->
        <script src="/assets/lib/template/js/jquery-2.2.4.min.js"></script>
        <!--BootstrapJS [ REQUIRED ]-->
        <script src="/assets/lib/template/js/bootstrap.min.js"></script>
        <!--NiftyJS [ REQUIRED ]-->
        <script src="/assets/lib/template/js/nifty.min.js"></script>                   
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/lib/jstree/dist/jstree.min.js"></script>    
        <script src="index.js"></script>    
        <!-- END JAVASCRIPT -->
        
    </body>
</html>
