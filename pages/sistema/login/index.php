
<!DOCTYPE html>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/model/sistema/login/index.load.php";
?>
<html lang="pt-br">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo TITULO_DO_SISTEMA; ?></title>
        <!--STYLESHEET-->
        <!--=================================================-->

        <!--Bootstrap Stylesheet [ REQUIRED ]-->
        <link href="/assets/lib/template/css/bootstrap.min.css" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="/assets/lib/template/plugins/font-awesome/css/font-awesome.min.css">

        <!--Nifty Stylesheet [ REQUIRED ]-->
        <link href="/assets/lib/template/css/nifty.min.css" rel="stylesheet">

        <!--Nifty Premium Icon [ DEMONSTRATION ]-->
        <link href="/assets/lib/template/css/demo/nifty-demo-icons.min.css" rel="stylesheet">

        <!--Demo [ DEMONSTRATION ]-->
        <link href="/assets/lib/template/css/nifty.min.css" rel="stylesheet">


    </head>

    <body>
        <div id="container" class="container-fluid cls-container">

            <?php
            //Modal Alert
            require_once $_SERVER['DOCUMENT_ROOT'] . "/layout/modalAlert.html";
            ?>

            <!-- BACKGROUND IMAGE -->
            <!--===================================================-->
            <div id="bg-overlay"></div>

            <!-- LOGIN FORM -->
            <!--===================================================-->
            <div class="cls-content login" >
                <div class="cls-content-sm panel">
                    <div class="panel-body">
                        <div class="mar-ver pad-btm">
                            <h1 class="h1 mar-no" >SESACRENET</h1>
                        </div>                                                                       
                        <form action="">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" style="background: white"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control input-lg" name ="login" id="login" placeholder="Usuário" autofocus required>                                
                                </div>
                            </div>
                            <div class="form-group campoSenha">
                                <div class="input-group">
                                    <span class="input-group-addon" style="background: white"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                    <input type="password" class="form-control input-lg" name="senha" id="senha" placeholder="Senha" required>
                                </div>
                            </div>
                            <button class="btn btn-success btn-lg btn-block" type="button" id="btn-logar">Logar</button>
<!--                            <button class="btn btn-danger btn-lg btn-block" type="button" id="cadFornecedor">Cadastro de Fornecedores</button>-->
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!--===================================================-->
        <!-- END OF CONTAINER -->


        <!--JAVASCRIPT-->

        <!--jQuery [ REQUIRED ]-->
        <script src="/assets/lib/template/js/jquery-2.2.4.min.js"></script>


        <!--BootstrapJS [ RECOMMENDED ]-->
        <script src="/assets/lib/template/js/bootstrap.min.js"></script>


        <!--NiftyJS [ RECOMMENDED ]-->
        <script src="/assets/lib/template/js/nifty.min.js"></script>

        <!--Background Image [ DEMONSTRATION ]-->
        <script src="/assets/lib/template/js/demo/bg-images.js"></script>

        <!--JAVASCRIP da pagina-->
        <script src="/assets/lib/sesacre/funcoes.js"></script>
        <script src="/assets/js/sistema/login/login.js"></script>
        <script src="/assets/lib/loadingover/loadingoverlay.js"></script>
        <!-- END JAVASCRIPT -->
    </body>
</html>
