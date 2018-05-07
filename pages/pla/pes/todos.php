<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/pla/pes/todos.load.php";
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
        <!-- Estilo Default das Páginas [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/css/estilo.css">
    </head>
    <!--TIPS-->

    <body>
        <div id="container" class="effect aside-float aside-bright mainnav-lg">

            <?php require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/header.php"; ?>

            <div class="boxed">

                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">

                    <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Início - Título da Tela</h1>                       
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <?php                             
                            //echo Metodos::getMeses()['01'];
                            function recurseTree($var){
                                $out = '';
                                foreach($var as $key => $v){
                                    if(is_array($v)){
                                        $out .= '<ul>'.recurseTree($v).'</ul>';
                                    }else{
                                        if($key == "value"){
                                            $out .= $v;
                                        }
                                    }
                                }
                                return $out.'';
                            }

                            //echo '<ul>'.recurseTree($pes->retornaTodosPesUlLi()).'</ul>';
                            
                            $GLOBALS['idPes'] = 0;
                            $GLOBALS['idEixo'] = 0;
                            $GLOBALS['idDiretriz'] = 0;
                            $GLOBALS['idObjetivo'] = 0;
                            
                            
                            
                            //code by acmol
                            function array2ul($array) {
                                
                                $out = "<ul>";
                                foreach($array as $key => $elem){
                                    if(!is_array($elem)){
                                        
                                        if($key == "id_pes"){
                                            $GLOBALS['idPes'] = $elem;  
                                            $link = "";
                                            $class = "text-primary";
                                        }
                                        if($key == "id_eixo"){
                                            $link = "<a href=/pages/pla/eixo/index.php?token=".$GLOBALS['idPes']."> Click </a>";
                                            $GLOBALS['idEixo'] = $elem;
                                            $class = "text-warning";
                                        }
                                        if($key == "id_diretriz"){
                                            $link = "<a href=/pages/pla/diretriz/index.php?token=".$GLOBALS['idEixo']."> Click </a>";
                                            $GLOBALS['idDiretriz'] = $elem;
                                            $class = "text-pink";
                                        }
                                        if($key == "id_objetivo"){
                                            $link = "<a href=/pages/pla/objetivo/index.php?token=".$GLOBALS['idDiretriz']."> Click </a>";
                                            $GLOBALS['idObjetivo'] = $elem;
                                            $class = "text-info";
                                        }
                                        if($key == "id_acao"){
                                            $link = "<a href=/pages/pla/acao/index.php?token=".$GLOBALS['idObjetivo']."> Click ".$elem." </a>";
                                            $class = "text-danger";
                                        }
                                        
                                        if($key == "value"){                                            
                                            $out .= "<li><span class=\"$class\">".$elem."</span>".$link."</li>";
                                        }
                                    }
                                    else {          
                                        $out .= array2ul($elem);
                                        //$out .= "<li><span>".$key."</span>".array2ul($elem)."</li>";
                                        
                                    }
                                }
                                $out .= "</ul>";
                                return $out; 
                            }
                            
                            echo array2ul($pes->retornaTodosPesUlLi());
                        
                            
                            echo "<pre>";
                            //print_r($pes->retornaTodosPesUlLi());
                            echo "</pre>";
                        ?>

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
        <script src="/assets/lib/template/plugins/datatables/media/js/accent-neutralise.js"></script> <!-- Search sem Acento -->
        <!-- DIALOG CONFIRM [OPT] -->
        <script src="/assets/lib/template/plugins/bootbox/bootbox.min.js"></script>     
        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <script src="/assets/lib/sesacre/funcoes.js"></script>
           
        <!-- END JAVASCRIPT -->

    </body>
</html>
