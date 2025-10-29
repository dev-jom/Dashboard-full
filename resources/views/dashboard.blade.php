<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <base href="{{ asset('') }}">
    <title>Dashboard | PBMonitor</title>
    
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="shortcut icon" href="assets/assets/images/favicon.png">
    

    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />  
    
    <link href="assets/css/bootstrap-dark.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    
    <link href="assets/css/app-dark.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />

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
                            Última atualização em: 22/09/2025
                        </button>
                    </div>
                </div>

                <div class="d-flex pr-2">

                    <!-- <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-notification-3-line"></i>
                            <span class="noti-dot"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0"> Notifications </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small"> View All</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="" class="text-reset notification-item">
                                    <div class="media">
                                        <div class="avatar-xs mr-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="ri-shopping-cart-line"></i>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">Your order is placed</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">If several languages coalesce the grammar</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="text-reset notification-item">
                                    <div class="media">
                                        <img src="assets/images/users/avatar-3.jpg"
                                            class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">James Lemire</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">It will seem like simplified English.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="text-reset notification-item">
                                    <div class="media">
                                        <div class="avatar-xs mr-3">
                                            <span class="avatar-title bg-success rounded-circle font-size-16">
                                                <i class="ri-checkbox-circle-line"></i>
                                            </span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">Your item is shipped</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">If several languages coalesce the grammar</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="text-reset notification-item">
                                    <div class="media">
                                        <img src="assets/images/users/avatar-4.jpg"
                                            class="mr-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1">Salena Layfield</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-top">
                                <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                                    <i class="mdi mdi-arrow-right-circle mr-1"></i> View More..
                                </a>
                            </div>
                        </div>
                    </div> -->

                    
                    
                    <div class="d-none d-lg-inline-block">
                        <a href="{{ route('dashboard.teste') }}" class="btn header-item noti-icon waves-effect d-flex align-items-center" title="Site" target="_blank" rel="noopener">
                            <span class="d-none d-xl-inline-block ml-2">Ir para Dashboard de Testes</span>
                        </a>
                    </div>
                    
                    <div class="dropdown d-none d-lg-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect d-flex align-items-center" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block">
                       

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
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <div class="main-content">

            <div class="page-content mt-3">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Dashboard</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body overflow-hidden">
                                                    <p class="text-truncate font-size-14 mb-2">Projetos em andamento este mês</p>
                                                    <h4 class="mb-0">3</h4>
                                                </div>
                                                <div class="text-primary">
                                                    <i class="ri-stack-line font-size-24"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body border-top py-3">
                                            <div class="text-truncate">
                                                <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i> 2.4% </span>
                                                <span class="text-muted ml-2">Comparado ao mês anterior</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body overflow-hidden">
                                                    <p class="text-truncate font-size-14 mb-2">Total de projetos este ano</p>
                                                    <h4 class="mb-0">7</h4>
                                                </div>
                                                <div class="text-primary">
                                                    <i class="ri-store-2-line font-size-24"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body border-top py-3">
                                            <div class="text-truncate">
                                                <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i> 2.4% </span>
                                                <span class="text-muted ml-2">Comparado ao ano anterior</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body overflow-hidden">
                                                    <p class="text-truncate font-size-14 mb-2">Total de projetos esta sprint (Sprint 148)</p>
                                                    <h4 class="mb-0">2</h4>
                                                </div>
                                                <div class="text-primary">
                                                    <i class="ri-briefcase-4-line font-size-24"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body border-top py-3">
                                            <div class="text-truncate">
                                                <span class="badge badge-soft-fail font-size-11" style="background-color: brown; color: white;"><i class="mdi mdi-menu-down"> </i> 2.4% </span>
                                                <span class="text-muted ml-2">Comparado a Sprint anterior</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                               
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title mb-2">Relação Geral entre quantidades de Melhorias e Bugs</h4>
                                                <div id="financial-chart" class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title mb-4">Spline Area</h4>
                                                <div id="spline_area" class="apex-charts" dir="ltr"></div>  
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                
                                
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <div class="float-right">
                                        <select class="custom-select custom-select-sm">
                                            <option selected>375 clientes</option>
                                            <option value="1">Abril</option>
                                            <option value="2">Março</option>
                                        </select>
                                    </div> -->
                                    <div class="float-right d-none d-md-inline-block">
                                        <div class="btn-group mb-2">
                                            <button type="button" class="btn btn-sm btn-light">Ver todos os Projetos</button>
                                        </div>
                                    </div>
                                    <h4 class="card-title mb-4">Projetos com mais atividades</h4>

                                    <div id="donut-chart" class="apex-charts"></div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="text-center mt-4">
                                                <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-info font-size-10 mr-1"></i> Gfrotas</p>
                                                <h5>67.3 %</h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-center mt-4">
                                                <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-danger font-size-10 mr-1"></i> Tecvoto </p>
                                                <h5>65 %</h5>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="text-center mt-4">
                                                <p class="mb-2 text-truncate"><i class="mdi mdi-circle text-warning font-size-10 mr-1"></i> Public </p>
                                                <h5>25 %</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown float-right">
                                    </div>

                                    <h4 class="card-title mb-4">% Projetos em variados ambientes</h4>
                                    <div class="text-center">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div>
                                                    <div class="mb-3">
                                                        <div id="radialchart-1" class="apex-charts"></div>
                                                    </div>

                                                    <p class="text-muted text-truncate mb-2">Mobile</p>
                                                    <h5 class="mb-0">20%</h5>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="mt-5 mt-sm-0">
                                                    <div class="mb-3">
                                                        <div id="radialchart-2" class="apex-charts"></div>
                                                    </div>

                                                    <p class="text-muted text-truncate mb-2">Public</p>
                                                    <h5 class="mb-0">80%</h5>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="mt-5 mt-sm-0">
                                                    <div class="mb-3">
                                                        <div id="radialchart-3" class="apex-charts"></div>
                                                    </div>

                                                    <p class="text-muted text-truncate mb-2">Website</p>
                                                    <h5 class="mb-0">30%</h5>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown float-right">
                                    </div>

                                    <h4 class="card-title mb-4">Validações Recentes</h4>

                                    <div data-simplebar style="max-height:478px;">
                                        <ul class="list-unstyled activity-wid">
                                            <li class="activity-list">
                                                <div class="activity-icon avatar-xs">
                                                    <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                        <i class="ri-check-fill"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <div>
                                                        <h5 class="font-size-13">23/09/2025   <small class="text-muted">14:20</small></h5>
                                                    </div>

                                                    <div>
                                                        <ul class="lista-custom">
                                                            <li>Tarefa: 19979</li>
                                                            <li>Dev: Kayo</li>
                                                            <li>Projeto: Public</li>
                                                            <li>Título da Tarefa: Gerar hash seguro em PHP para uso no sistema Laravel</li>
                                                            <li><a href="https://redmine.pbsoft.com.br/issues/19979">Abrir tarefa no Redmine</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="activity-list">
                                                <div class="activity-icon avatar-xs">
                                                    <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                        <i class="ri-check-fill"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <div>
                                                        <h5 class="font-size-13">23/09/2025  <small class="text-muted">14:10</small></h5>
                                                    </div>

                                                    <div>
                                                        <ul class="lista-custom">
                                                            <li>Tarefa: 20373</li>
                                                            <li>Dev: Newton</li>
                                                            <li>Projeto: Public</li>
                                                            <li>Título da Tarefa: Incluir links de LGPD</li>
                                                            <li><a href="https://redmine.pbsoft.com.br/issues/20373">Abrir tarefa no Redmine</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="activity-list">
                                                <div class="activity-icon avatar-xs">
                                                    <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                        <i class="ri-check-fill"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <div>
                                                        <h5 class="font-size-13">23/09/2025 <small class="text-muted">14:00</small></h5>
                                                    </div>

                                                    <div>
                                                        <ul class="lista-custom">
                                                            <li>Tarefa: 20496</li>
                                                            <li>Dev: Kayo</li>
                                                            <li>Projeto: Public</li>
                                                            <li>Título da Tarefa: Correção do erro 404 no mapa do site</li>
                                                            <li><a href="https://redmine.pbsoft.com.br/issues/20496">Abrir tarefa no Redmine</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="activity-list">
                                                <div class="activity-icon avatar-xs">
                                                    <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                        <i class="ri-check-fill"></i>
                                                    </span>
                                                </div>
                                                <div>
                                                    <div>
                                                        <h5 class="font-size-13">23/09/2025 <small class="text-muted">13:45</small></h5>
                                                    </div>

                                                    <div>
                                                        <ul class="lista-custom">
                                                            <li>Tarefa: 20457</li>
                                                            <li>Dev: Kayo</li>
                                                            <li>Projeto: Circuito AD</li>
                                                            <li>Título da Tarefa: Gerar um PWA da estrutura do CIRCUITO AD</li>
                                                            <li><a href="https://redmine.pbsoft.com.br/issues/20457">Abrir tarefa no Redmine</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown float-right">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>

                                    <h4 class="card-title mb-4">Últimas tarefas</h4>

                                    <div>
                                        <table class="table table-centered datatable dt-responsive nowrap" data-page-length="5" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width: 20px;">#</th>
                                                    <th>Tarefa</th>
                                                    <th>Data de Criação</th>
                                                    <th>Status</th>
                                                    <th>Desenvolvedor</th>
                                                    <th class="text-right" style="width:120px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20574</a></td>
                                                    <td>10/02/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Aprovado</div></td>
                                                    <td>Franklin</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20574" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20115</a></td>
                                                    <td>10/02/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Aprovado</div></td>
                                                    <td>Murillo</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20115" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20115</a></td>
                                                    <td>10/02/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Validado</div></td>
                                                    <td>Murillo</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20115" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20283</a></td>
                                                    <td>10/02/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Validado</div></td>
                                                    <td>Caio Andrade</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20283" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20415</a></td>
                                                    <td>10/02/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Validado</div></td>
                                                    <td>Caio Andrade</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20415" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20544</a></td>
                                                    <td>10/03/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Validado</div></td>
                                                    <td>Jeff</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20544" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20576</a></td>
                                                    <td>10/03/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Validado</div></td>
                                                    <td>Murillo</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20576" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20586</a></td>
                                                    <td>10/06/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Aprovado</div></td>
                                                    <td>Jeff</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20586" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20614</a></td>
                                                    <td>10/06/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Validado</div></td>
                                                    <td>Kayo</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20611" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20611</a></td>
                                                    <td>10/06/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Validado</div></td>
                                                    <td>Kayo</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20611" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>11</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20604</a></td>
                                                    <td>10/06/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Validado</div></td>
                                                    <td>Kayo</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20604" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>12</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20327</a></td>
                                                    <td>10/06/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Validado</div></td>
                                                    <td>Murillo</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20327" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>13</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20405</a></td>
                                                    <td>10/06/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Validado</div></td>
                                                    <td>Jeff</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20405" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>14</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20541</a></td>
                                                    <td>10/06/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Validado</div></td>
                                                    <td>Moab</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20541" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>15</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20535</a></td>
                                                    <td>10/06/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Validado</div></td>
                                                    <td>Moab</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20535" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>16</td>
                                                    <td><a href="javascript: void(0);" class="text-dark font-weight-bold">20477</a></td>
                                                    <td>10/06/2025</td>
                                                    <td class=""><div class="badge badge-soft-success font-size-12">Validado</div></td>
                                                    <td>Max</td>
                                                    <td class="text-right">
                                                        <a href="https://redmine.pbsoft.com.br/issues/20477" target="_blank" rel="noopener" class="mr-2 text-primary" data-toggle="tooltip" data-placement="top" title="Abrir no Redmine" data-original-title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                            Copyright <script>document.write(new Date().getFullYear())</script> PBMonitor. Todos os direitos reservados.
                        </div>
                    </div>
                </div>
            </footer>
        </div>

    </div>

    <div class="rightbar-overlay"></div>

    <!-- Donut Chart Modal -->
    <div class="modal fade" id="donutModal" tabindex="-1" aria-labelledby="donutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Detalhes</h5>
                </div>
                <div class="modal-body">
                    <p>Projeto: <strong><span id="modalProject">-</span></strong></p>
                    <p>Valor: <strong><span id="modalValue">0</span>%</strong></p>
                    <div class="mt-3">
                        <h6>Detalhes Adicionais:</h6>
                        <p id="modalDetails">Clique em um segmento do gráfico para ver os detalhes.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Chart Modal -->
    <div class="modal fade" id="financialModal" tabindex="-1" aria-labelledby="financialModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="financialModalTitle">Mais Detalhes</h5>
                </div>
                <div class="modal-body">
                    <p>Tipo: <strong><span id="financialType">-</span></strong></p>
                    <p>Mês: <strong><span id="financialMonth">-</span></strong></p>
                    <p>Quantidade: <strong><span id="financialValue">0</span></strong></p>
                    <div class="mt-3">
                        <h6>Detalhes Adicionais:</h6>
                        <p id="financialDetails">Clique em uma barra do gráfico para ver os detalhes.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fechar</button>
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

    <script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js"></script>

    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <script src="assets/js/pages/datatables.init.js"></script>

    <script src="assets/js/pages/dashboard.init.js"></script>

    <script src="assets/js/app.js"></script>

</body>
</html>
