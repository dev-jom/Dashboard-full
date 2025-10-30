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
    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
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

                    <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item" data-toggle="collapse" data-target="#topnav-menu-content">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>

                    <div class="dropdown dropdown-mega d-none d-lg-block ml-2">
                        <button class="btn header-item cursor-default">
                            <i class="mdi mdi-clock"></i>
                            Dashboard de Testes
                        </button>
                    </div>
                    <!-- Sprint selector (Bootstrap dropdown to match site pattern) -->
                    <div class="ml-3 mt-3 d-inline-block" style="min-width:260px;">
                        <div class="col-sm-6">
                            <div class="dropdown mt-0 mt-sm-0">
                                <a href="#" id="sprintDropdownBtn" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Todas as Sprints <i class="mdi mdi-chevron-down"></i>
                                </a>

                                <div class="dropdown-menu" id="sprintDropdownMenu">
                                    <a class="dropdown-item" href="#" data-sprint="">Todas as Sprints</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex pr-2">
                    <div class="d-none d-lg-inline-block">
                        <a href="{{ url('/') }}" class="btn header-item noti-icon waves-effect d-flex align-items-center" title="Voltar ao Dashboard" target="_blank" rel="noopener">
                            <span class="d-none d-xl-inline-block ml-2">Ir para Dashboard de Projetos</span>
                        </a>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect d-flex align-items-center" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>

                </div>
            </div>
        </header>

        <div class="main-content">
            <div class="page-content mt-3">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="media">
                                        <div class="media-body overflow-hidden">
                                            <p class="text-truncate font-size-14 mb-2"> Total de Tickets</p>
                                            <h4 id="total-tickets" class="mb-0">147</h4>
                                        </div>
                                        <div class="text-primary"><i class="ri-ticket-fill font-size-24"></i></div>
                                    </div>
                                </div>
                                <div class="card-body border-top py-3">
                                    <div class="text-truncate"><span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"></i> 2.4% </span><span class="text-muted ml-2">Comparado a Sprint anterior</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="media">
                                        <div class="media-body overflow-hidden">
                                            <p class="text-truncate font-size-14 mb-2"> Taxa de Aprovação</p>
                                            <h4 id="approval-rate" class="mb-0">97.3%</h4>
                                        </div>
                                        <div class="text-primary"><i class="ri-check-line font-size-24"></i></div>
                                    </div>
                                </div>
                                <div class="card-body border-top py-3">
                                    <div class="text-truncate"><span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"></i> 2.4% </span><span class="text-muted ml-2">Comparado a Sprint anterior</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="media">
                                        <div class="media-body overflow-hidden">
                                            <p class="text-truncate font-size-14 mb-2"> Total de Estruturas</p>
                                            <h4 id="total-estruturas" class="mb-0">19</h4>
                                        </div>
                                        <div class="text-primary"><i class="ri-stack-line font-size-24"></i></div>
                                    </div>
                                </div>
                                <div class="card-body border-top py-3">
                                    <div class="text-truncate"><span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"></i> 2.4% </span><span class="text-muted ml-2">Comparado a Sprint anterior</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="media">
                                        <div class="media-body overflow-hidden">
                                            <p class="text-truncate font-size-14 mb-2"> Quantidade de Devs</p>
                                            <h4 id="total-devs" class="mb-0">10</h4>
                                        </div>
                                        <div class="text-primary"><i class="ri-user-fill font-size-24"></i></div>
                                    </div>
                                </div>
                                <div class="card-body border-top py-3">
                                    <div class="text-truncate"><span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"></i> 2.4% </span><span class="text-muted ml-2">Comparado a Sprint anterior</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                 

                    <!-- moved Testes por Estrutura below -->

                    <div class="row mt-4">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Status dos Testes</h4>
                                    <div id="donut-chart-teste" class="apex-charts"></div>
                                    <div class="row">
                                        <div class="col-4"><div class="text-center mt-4"><p id="legend-validado" class="mb-2 text-truncate"><i class="mdi mdi-circle text-info font-size-10 mr-1"></i> Validado (0)</p><h5 id="legend-validado-pct">0 %</h5></div></div>
                                        <div class="col-4"><div class="text-center mt-4"><p id="legend-aprovado" class="mb-2 text-truncate"><i class="mdi mdi-circle text-success font-size-10 mr-1"></i> Aprovado (0)</p><h5 id="legend-aprovado-pct">0 %</h5></div></div>
                                        <div class="col-4"><div class="text-center mt-4"><p id="legend-reprovado" class="mb-2 text-truncate"><i class="mdi mdi-circle text-danger font-size-10 mr-1"></i> Reprovado (0)</p><h5 id="legend-reprovado-pct">0 %</h5></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Quantidade de Atividades por Dev</h4>
                                    <div id="qntd-att-devs" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Testes por Estrutura</h4>
                                    <div id="testes-por-estrutura" class="apex-charts"></div>
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
                            Copyright <script>document.write(new Date().getFullYear())</script> PBMonitor. Todos os direitos reservados.
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    

    <div class="rightbar-overlay"></div>

    <!-- Donut Chart Modal (used by dashboard_teste) -->
    <div class="modal fade" id="donutModal" tabindex="-1" aria-labelledby="donutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Detalhes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <!-- small chart container -->
                    <div id="donutModalChart" style="height:220px; max-width:360px; margin:0 auto"></div>

                    <!-- summary lines -->
                    <p class="mt-3">Status: <strong><span id="modalProject">-</span></strong></p>
                    <p>Quantidade: <strong><span id="modalValue">0</span></strong></p>
                    <p id="modalDetails" class="text-muted small">Clique em um segmento do gráfico para ver os detalhes.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/pages/dashboard_teste.init.js"></script>
</body>
</html>
