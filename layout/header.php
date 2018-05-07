<!--NAVBAR-->
<!--===================================================-->
<header id="navbar">
    <div id="navbar-container" class="boxed">

        <!--Brand logo & name-->
        <!--================================-->
        <div class="navbar-header">
            <a href="/index.php" class="navbar-brand">
                <img src="/assets/img/esfera.png" alt="Nifty Logo" class="brand-icon">
                <div class="brand-title">
                    <span class="brand-text">SESACRENET</span>
                </div>
            </a>
        </div>
        <!--================================-->
        <!--End brand logo & name-->


        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content clearfix">
            <ul class="nav navbar-top-links pull-left">

                <!--Navigation toogle button-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="tgl-menu-btn">
                    <a class="mainnav-toggle" href="#">
                        <i class="ti-view-list"></i>
                    </a>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Navigation toogle button-->


                
                <!--Notification dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                        <i class="ti-bell"></i>
                        <span class="badge badge-header badge-danger"></span>
                    </a>

                    
                    <div class="dropdown-menu dropdown-menu-md">
                        <div class="pad-all bord-btm">
                            <p class="text-semibold text-main mar-no">You have 9 notifications.</p>
                        </div>
                        <div class="nano scrollable">
                            <div class="nano-content">
                                <ul class="head-list">

                                    
                                    <li>
                                        <a href="#">
                                            <div class="clearfix">
                                                <p class="pull-left">Database Repair</p>
                                                <p class="pull-right">70%</p>
                                            </div>
                                            <div class="progress progress-sm">
                                                <div style="width: 70%;" class="progress-bar">
                                                    <span class="sr-only">70% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                    
                                    <li>
                                        <a href="#">
                                            <div class="clearfix">
                                                <p class="pull-left">Upgrade Progress</p>
                                                <p class="pull-right">10%</p>
                                            </div>
                                            <div class="progress progress-sm">
                                                <div style="width: 10%;" class="progress-bar progress-bar-warning">
                                                    <span class="sr-only">10% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                    
                                    <li>
                                        <a class="media" href="#">
                                            <span class="badge badge-success pull-right">90%</span>
                                            <div class="media-left">
                                               <i class="fa fa-hdd-o fa-2x" aria-hidden="true"></i>
                                            </div>
                                            <div class="media-body">
                                                <div class="text-nowrap">HDD is full</div>
                                                <small class="text-muted">50 minutes ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    
                                    <li>
                                        <a class="media" href="#">
                                            <div class="media-left">
                                               <i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
                                            </div>
                                            <div class="media-body">
                                                <div class="text-nowrap">Write a news article</div>
                                                <small class="text-muted">Last Update 8 hours ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    
                                    <li>
                                        <a class="media" href="#">
                                            <span class="label label-danger pull-right">New</span>
                                            <div class="media-left">
                                                <i class="ti-comment icon-2x"></i>
                                            </div>
                                            <div class="media-body">
                                                <div class="text-nowrap">Comment Sorting</div>
                                                <small class="text-muted">Last Update 8 hours ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    
                                    <li>
                                        <a class="media" href="#">
                                            <div class="media-left">
                                                <i class="fa fa-user-plus fa-2x"></i>
                                            </div>
                                            <div class="media-body">
                                                <div class="text-nowrap">New User Registered</div>
                                                <small class="text-muted">4 minutes ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    
                                    <li class="bg-gray">
                                        <a class="media" href="#">
                                            <div class="media-left">
                                                <img class="img-circle img-sm" alt="Profile Picture" src="/assets/lib/template/img/profile-photos/9.png">
                                            </div>
                                            <div class="media-body">
                                                <div class="text-nowrap">Lucy sent you a message</div>
                                                <small class="text-muted">30 minutes ago</small>
                                            </div>
                                        </a>
                                    </li>

                                    
                                    <li class="bg-gray">
                                        <a class="media" href="#">
                                            <div class="media-left">
                                                <img class="img-circle img-sm" alt="Profile Picture" src="/assets/lib/template/img/profile-photos/3.png">
                                            </div>
                                            <div class="media-body">
                                                <div class="text-nowrap">Jackson sent you a message</div>
                                                <small class="text-muted">40 minutes ago</small>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        
                        <div class="pad-all bord-top">
                            <a href="#" class="btn-link text-dark box-block">
                                <i class="fa fa-angle-right fa-lg pull-right"></i>Show All Notifications
                            </a>
                        </div>
                    </div>
                </li> -->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End notifications dropdown-->



                

            </ul>
            <ul class="nav navbar-top-links pull-right">

                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <span class="pull-right">
                            <!--<img class="img-circle img-user media-object" src="img/profile-photos/1.png" alt="Profile Picture">-->
                            <i class="ti-user ic-user"></i>
                        </span>
                        <div class="username hidden-xs"><?php echo Metodos::primerioNomePessoa($_SESSION['nmPessoa']); ?></div>
                    </a>


                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right panel-default">

                        <!-- Dropdown heading  -->
                        <!--
                        <div class="pad-all bord-btm">
                            <p class="text-main mar-btm"><span class="text-bold">750GB</span> of 1,000GB Used</p>
                            <div class="progress progress-sm">
                                <div class="progress-bar" style="width: 70%;">
                                    <span class="sr-only">70%</span>
                                </div>
                            </div>
                        </div> -->


                        <!-- User dropdown menu -->
                        <ul class="head-list">
                            
                            <li>
                                <a href="#">
                                    <i class="ti-user icon-lg icon-fw"></i> Meus Dados
                                </a>
                            </li>
                            <!--
                            <li>
                                <a href="#">
                                    <span class="badge badge-danger pull-right">9</span>
                                    <i class="ti-email icon-lg icon-fw"></i> Mensagens
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-success pull-right">New</span>
                                    <i class="ti-settings icon-lg icon-fw"></i> Configurações
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="ti-help-alt icon-lg icon-fw"></i> Ajuda
                                </a>
                            </li> -->
                            <li>
                                <a href="/pages/sistema/login/alterarSenha.php">
                                    <i class="ti-lock icon-lg icon-fw"></i> Alterar Senha
                                </a>
                            </li>
                        </ul>

                        <!-- Dropdown footer -->
                        <div class="pad-all text-right">
                            <a href="/logout.php" class="btn btn-primary">
                                <i class="ti-power-off"></i> Sair
                            </a>
                        </div>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->
               
            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

    </div>
</header>
<!--===================================================-->
<!--END NAVBAR-->
