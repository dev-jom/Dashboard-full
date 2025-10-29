<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <base href="{{ asset('') }}">
    <title>Dashboard de Testes | PBMonitor</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/assets/images/favicon.png">
    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
        type="text/css" />
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />
    <link href="assets/css/bootstrap-dark.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app-dark.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/card.css" rel="stylesheet" type="text/css" />
</head>

<body data-topbar="dark" data-layout="horizontal">
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box">
                        <a href="{{ url('/') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm-light.png" alt="" height="18">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-light.png" alt="" height="30">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item"
                        data-toggle="collapse" data-target="#topnav-menu-content">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>

                    <div class="dropdown dropdown-mega d-none d-lg-block ml-2">
                        <button class="btn header-item cursor-default">
                            <i class="mdi mdi-clock"></i>
                            Dashboard de Testes
                        </button>
                    </div>
                </div>

                <div class="d-flex pr-2">
                    <div class="d-none d-lg-inline-block">
                        <a href="{{ url('/') }}"
                            class="btn header-item noti-icon waves-effect d-flex align-items-center" title="Site"
                            target="_blank" rel="noopener">
                            <span class="d-none d-xl-inline-block ml-2">Ir para Dashboard de Projetos</span>
                        </a>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect d-flex align-items-center"
                            data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect d-flex align-items-center"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-apps-2-line d-none d-xl-inline-block"></i>
                            <span class="d-none d-xl-inline-block ml-2">Apps</span>
                        </button>

                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <div class="px-lg-2">
                                <div class="row no-gutters">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/redmine.png" alt="Redmine">
                                            <span>Redmine</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/gitlab.png" alt="GitLab">
                                            <span>GitLab</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/syspass.png" alt="SysPasss">
                                            <span>SysPass</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="row no-gutters">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/hostgator.png" alt="Hostgator">
                                            <span>Hostgator</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/locaweb.png" alt="Locaweb">
                                            <span>Locaweb</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="assets/images/brands/hostdime.png" alt="Hostdime">
                                            <span>Hostdime</span>
                                        </a>
                            </div>
                        </div>
                    </div>
                                                    </p>
                                                    <h4 class="mb-0">147</h4>
                                                </div>
                                                <div class="text-primary">
                                                    <i class="ri-ticket-fill font-size-24"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body border-top py-3">
                                            <div class="text-truncate">
                                                <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up">
                                                    </i> 2.4% </span>
                                                <span class="text-muted ml-2">Comparado a Sprint anterior</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <div class="media">
                                                <div class="media-body overflow-hidden">
                                                    <p class="text-truncate font-size-14 mb-2"> Taxa de Aprovação
                                                    </p>
                                                    <h4 class="mb-0">97.3%</h4>
                                                </div>
                                                <div class="text-primary">
                                                    <i class="ri-check-line font-size-24"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body border-top py-3">
                                            <div class="text-truncate">
                                                <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up">
                                                    </i> 2.4% </span>
                                                <span class="text-muted ml-2">Comparado a Sprint anterior</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <div class="media">
                                                <div class="media-body overflow-hidden">
                                                    <p class="text-truncate font-size-14 mb-2">Total de Estruturas
                                                    </p>
                                                    <h4 class="mb-0">19</h4>
                                                </div>
                                                <div class="text-primary">
                                                    <i class="ri-stack-line font-size-24"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body border-top py-3">
                                            <div class="text-truncate">
                                                <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up">
                                                    </i> 2.4% </span>
                                                <span class="text-muted ml-2">Comparado a Sprint anterior</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <div class="media">
                                                <div class="media-body overflow-hidden">
                                                    <p class="text-truncate font-size-14 mb-2">Quantidade de Devs
                                                    </p>
                                                    <h4 class="mb-0">10</h4>
                                                </div>
                                                <div class="text-primary">
                                                    <i class="ri-user-fill font-size-24"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body border-top py-3">
                                            <div class="text-truncate">
                                                <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up">
                                                    </i> 2.4% </span>
                                                <span class="text-muted ml-2">Comparado a Sprint anterior</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            


            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            Copyright <script>
                                document.write(new Date().getFullYear())

                            </script> PBMonitor. Todos os direitos reservados.
                        </div>
                    </div>
                </div>
            </footer>
            
            <div class="rightbar-overlay"></div>

            <script src="assets/libs/jquery/jquery.min.js"></script>
            <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="assets/libs/metismenu/metisMenu.min.js"></script>
            <script src="assets/libs/simplebar/simplebar.min.js"></script>
            <script src="assets/libs/node-waves/waves.min.js"></script>
            <script src="assets/js/app.js"></script>
            <script src="assets/js/pages/dashboard_teste.init.js"></script>
</body>

</html>
