<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/index.load.php";
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
        <!--Nifty Premium Icon [ DEMONSTRATION ]-->
        <link href="/assets/lib/template/css/demo/nifty-demo-icons.min.css" rel="stylesheet">

        <!--Demo [ DEMONSTRATION ]-->
        <link href="/assets/lib/template/css/demo/nifty-demo.min.css" rel="stylesheet">

        <!-- Font Awesome [ REQUIRED ] -->
        <link rel="stylesheet" href="/assets/lib/template/plugins/font-awesome/css/font-awesome.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <!--TIPS-->
    <!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
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
                        <h1 class="page-header text-overflow">Início - Título da Tela</h1>
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">
                        <?php
//                        $client = new SoapClient("http://10.1.2.69:9081/grpServiceHttpRouter/services/GrpService/wsdl/GrpService.wsdl");
//                        $ar[] = array('descricaoMaterial' => 'dipirona');
//                        $response = $client->__soapCall("getCatalagoMaterialByDescricaoMaterial", $ar);
//                        //$result = $client->getCatalagoMaterialByDescricaoMaterial($ar);
//                        echo "<pre>";
//                        print_r($response);
//                        echo "</pre>";
                        
                        
                        require_once('ws_sga.php');
                        try {


                            $web = new ws_sga();


                            //$result = $web->pesquisaDescricaoMaterial("arroz");

                            //print_r($result);
                            //foreach ($result as $value) {
                                //echo utf8_encode($value['descricaoMaterial']) . "<br>";
                            //}
                            
                            $elemento = "3390303001";
                            echo "<pre>";
                            print_r($web->pesquisaElementoDespesa("3390390100"));
                            //print_r($web->pesquisaDescricaoMaterial("CANETA ESFEROGRAFICA"));
                            //print_r($web->pesquisaElementoDespesa("3390301700"));

                            //$result = $web->pesquisaDescricaoMaterial("cadeira");
                            // print_r($result);
                            //foreach ($result as $value) {
                                // echo utf8_encode($value['descricaoMaterial']) . "<br>";
                            //}
                            print "<pre>";
                           // print_r($web->pesquisaNomeMaterial("cadeira"));

                            //print_r($web->pesquisaElementoDespesa("3390302100"));
                            echo "</pre>";
                        } catch (Exception $ex) {
                            echo $ex->getMessage();
                        }
                         
                       
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
        <!-- /.login-box -->

        <!--jQuery [ REQUIRED ]-->
        <script src="/assets/lib/template/js/jquery-2.2.4.min.js"></script>
        <!--BootstrapJS [ REQUIRED ]-->
        <script src="/assets/lib/template/js/bootstrap.min.js"></script>
        <!--NiftyJS [ RECOMMENDED ]-->
        <script src="/assets/lib/template/js/nifty.min.js"></script>
    </body>
</html>
