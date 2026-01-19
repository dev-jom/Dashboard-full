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

    <style>
        /* Reserve space for donut chart to avoid layout jumps on render */
        #donut-chart { min-height: 320px; display:flex; align-items:center; justify-content:center; }
        /* Keep form area height to avoid small jumps when date inputs show */
        #top-projects-form { min-height: 40px; }
        /* Loading spinner shown while chart renders */
        #donut-chart.loading::before { content: ''; width:36px; height:36px; border:4px solid rgba(255,255,255,0.08); border-top-color:#6c5ce7; border-radius:50%; display:block; animation: spin 1s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>

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
                                                    <h4 class="mb-0">{{ $projetosMes ?? 0 }}</h4>
                                                </div>
                                                <div class="text-primary">
                                                    <i class="ri-stack-line font-size-24"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-body border-top py-3">
                                            <div class="text-truncate">
                                                @if(isset($projetosMesChange))
                                                    @if($projetosMesChange === 0 || $projetosMesChange == 0)
                                                        <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"></i></span>
                                                    @else
                                                        @if($projetosMesIsUp)
                                                            <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i> {{ $projetosMesChange }}% </span>
                                                        @else
                                                            <span class="badge badge-soft-fail font-size-11" style="background-color: brown; color: white;"><i class="mdi mdi-menu-down"> </i> {{ $projetosMesChange }}% </span>
                                                        @endif
                                                    @endif
                                                @else
                                                    <span class="badge badge-soft-secondary font-size-11">--</span>
                                                @endif
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
                                                    <h4 class="mb-0">{{ $projetosAno ?? 0 }}</h4>
                                                </div>
                                                <div class="text-primary">
                                                    <i class="ri-store-2-line font-size-24"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body border-top py-3">
                                            <div class="text-truncate">
                                                @if(isset($projetosAnoChange))
                                                    @if($projetosAnoChange === 0 || $projetosAnoChange == 0)
                                                        <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"></i></span>
                                                    @else
                                                        @if($projetosAnoIsUp)
                                                            <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i> {{ $projetosAnoChange }}% </span>
                                                        @else
                                                            <span class="badge badge-soft-fail font-size-11" style="background-color: brown; color: white;"><i class="mdi mdi-menu-down"> </i> {{ $projetosAnoChange }}% </span>
                                                        @endif
                                                    @endif
                                                @else
                                                    <span class="badge badge-soft-secondary font-size-11">--</span>
                                                @endif
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
                                                    <p class="text-truncate font-size-14 mb-2">Total de projetos esta sprint <small>({{ $sprintLabel ?? '—' }})</small></p>
                                                    <h4 class="mb-0">{{ $projetosSprint ?? 0 }}</h4>
                                                </div>
                                                <div class="text-primary">
                                                    <i class="ri-briefcase-4-line font-size-24"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body border-top py-3">
                                            <div class="text-truncate">
                                                @if(isset($projetosSprintChange))
                                                    @if($projetosSprintChange === 0 || $projetosSprintChange == 0)
                                                        <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"></i></span>
                                                    @else
                                                        @if($projetosSprintIsUp)
                                                            <span class="badge badge-soft-success font-size-11"><i class="mdi mdi-menu-up"> </i> {{ $projetosSprintChange }}% </span>
                                                        @else
                                                            <span class="badge badge-soft-fail font-size-11" style="background-color: brown; color: white;"><i class="mdi mdi-menu-down"> </i> {{ $projetosSprintChange }}% </span>
                                                        @endif
                                                    @endif
                                                @else
                                                    <span class="badge badge-soft-secondary font-size-11">--</span>
                                                @endif
                                                <span class="text-muted ml-2">Comparado a Sprint anterior</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                               
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">

                                                <h4 class="card-title mb-3">Total de Projetos por Usuário</h4>

                                                <form id="dev-projects-filter-form" class="form-inline mb-3" method="get" action="{{ route('dashboard') }}">
                                                    <label class="mr-2">Dev:</label>
                                                    <select id="dev-select" name="dev" class="custom-select custom-select-sm mr-2">
                                                        <option value="">-- Selecionar --</option>
                                                        @if(isset($devs) && is_array($devs))
                                                            @foreach($devs as $d)
                                                                <option value="{{ $d }}" {{ (string)request('dev') === (string)$d ? 'selected' : '' }}>{{ $d }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    <label class="mr-2">Período:</label>
                                                    <select name="dev_range" id="dev-range-select" class="custom-select custom-select-sm mr-2">
                                                        <option value="month" {{ request('dev_range','month')=='month' ? 'selected' : '' }}>Este mês</option>
                                                        <option value="year" {{ request('dev_range')=='year' ? 'selected' : '' }}>Este ano</option>
                                                        <option value="custom" {{ request('dev_range')=='custom' ? 'selected' : '' }}>Personalizado</option>
                                                    </select>

                                                    <input type="date" name="dev_start" id="dev-start-date" class="form-control form-control-sm mr-2" value="{{ request('dev_start') }}" style="{{ request('dev_range')=='custom' ? 'display:inline-block;' : 'display:none;' }}">
                                                    <input type="date" name="dev_end" id="dev-end-date" class="form-control form-control-sm mr-2" value="{{ request('dev_end') }}" style="{{ request('dev_range')=='custom' ? 'display:inline-block;' : 'display:none;' }}">

                                                    <button type="submit" class="btn btn-sm btn-primary">Aplicar</button>
                                                </form>

                                                <!-- Summary columns removed: hours estimadas/gastas moved to modal only -->

                                                <div id="doughnut-wrapper" style="height:320px; display:flex; align-items:center; justify-content:center; position:relative;">
                                                    <!-- placeholder removed so chart starts visible by default -->
                                                    <div id="doughnut-container" style="width:100%; height:100%; display:block;">
                                                        <canvas id="doughnut" style="width:100%; height:100%;"></canvas>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                    
                                
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title mb-4">Relação entre quantidade de tarefas Criadas e Validadas</h4>

                                                <!-- Sprint filter for Criadas x Validadas -->
                                                <!-- Simplified: only two sprint selectors (from/to). These submit as `from` and `to`. -->
                                                <form id="sprints-filter-form" class="form-inline mb-3" method="get" action="{{ route('dashboard') }}">
                                                    <label class="mr-2">Sprints:</label>

                                                    <select id="sprint-from" name="from" class="custom-select custom-select-sm mr-2" style="display:inline-block;">
                                                        <option value="">-- Sprint inicial --</option>
                                                        @if(isset($availableSprints) && is_array($availableSprints))
                                                            @foreach($availableSprints as $sp)
                                                                <option value="{{ $sp['value'] }}" {{ (string)request('from') === (string)$sp['value'] ? 'selected' : '' }}>{{ $sp['label'] }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    <select id="sprint-to" name="to" class="custom-select custom-select-sm mr-2" style="display:inline-block;">
                                                        <option value="">-- Sprint final --</option>
                                                        @if(isset($availableSprints) && is_array($availableSprints))
                                                            @foreach($availableSprints as $sp)
                                                                <option value="{{ $sp['value'] }}" {{ (string)request('to') === (string)$sp['value'] ? 'selected' : '' }}>{{ $sp['label'] }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    <button type="submit" class="btn btn-sm btn-primary">Aplicar</button>
                                                </form>

                                              

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
                                            <a href="{{ route('projects.all') }}" class="btn btn-sm btn-light">Ver todos os Projetos</a>
                                        </div>
                                    </div>
                                    <h4 class="card-title mb-4">Projetos com mais atividades</h4>

                                    <!-- Filtro de período para Projetos com mais atividades -->
                                    <form id="top-projects-filter-form" class="form-inline mb-3" method="get" action="{{ route('dashboard') }}">
                                        <label class="mr-2">Período:</label>
                                        <select name="top_range" id="top-projects-range-select" class="custom-select custom-select-sm mr-2">
                                            <option value="month" {{ request('top_range','month')=='month' ? 'selected' : '' }}>Este mês</option>
                                            <option value="year" {{ request('top_range')=='year' ? 'selected' : '' }}>Este ano</option>
                                            <option value="custom" {{ request('top_range')=='custom' ? 'selected' : '' }}>Personalizado</option>
                                        </select>
                                        <input type="date" name="top_start" id="top-projects-start-date" class="form-control form-control-sm mr-2" value="{{ request('top_start') }}" style="{{ request('top_range')=='custom' ? 'display:inline-block;' : 'display:none;' }}">
                                        <input type="date" name="top_end" id="top-projects-end-date" class="form-control form-control-sm mr-2" value="{{ request('top_end') }}" style="{{ request('top_range')=='custom' ? 'display:inline-block;' : 'display:none;' }}">
                                        <button type="submit" class="btn btn-sm btn-primary">Aplicar</button>
                                    </form>

                                    <div id="donut-chart" class="apex-charts"></div>

                                    <div class="row">
                                        @php
                                            $labels = $topProjectsLabels ?? [];
                                            $percents = $topProjectsPercentages ?? [];
                                        @endphp
                                        @for ($i = 0; $i < 3; $i++)
                                            @php
                                                $label = $labels[$i] ?? null;
                                                $pct = $percents[$i] ?? null;
                                                $dotClass = ['text-info', 'text-danger', 'text-warning'][$i] ?? 'text-primary';
                                            @endphp
                                            <div class="col-4">
                                                <div class="text-center mt-4">
                                                    <p class="mb-2 text-truncate"><i class="mdi mdi-circle {{ $dotClass }} font-size-10 mr-1"></i> {{ $label ?? '-' }}</p>
                                                    <h5>{{ isset($pct) ? $pct . ' %' : '-' }}</h5>
                                                </div>
                                            </div>
                                        @endfor
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
                                            @if(isset($recentValidated) && count($recentValidated))
                                                @foreach($recentValidated as $t)
                                                    <li class="activity-list">
                                                        <div class="activity-icon avatar-xs">
                                                            <span class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                                <i class="ri-check-fill"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <div>
                                                                @php $dt = \Carbon\Carbon::parse($t->created_at); @endphp
                                                                <h5 class="font-size-13">{{ $dt->format('d/m/Y') }} <small class="text-muted">{{ $dt->format('H:i') }}</small></h5>
                                                            </div>

                                                            <div>
                                                                <ul class="lista-custom">
                                                                    <li>Tarefa: {{ (int) $t->id }}</li>
                                                                    <li>Dev: {{ $t->assigned_to ?? '-' }}</li>
                                                                    <li>Projeto: {{ $t->project ?? '-' }}</li>
                                                                    <li>Título da Tarefa: {{ $t->subject ?? '-' }}</li>
                                                                    <li><a href="https://redmine.pbsoft.com.br/issues/{{ (int) $t->id }}" target="_blank" rel="noopener">Abrir tarefa no Redmine</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="activity-list">
                                                    <div class="activity-icon avatar-xs">
                                                        <span class="avatar-title bg-soft-secondary text-secondary rounded-circle">
                                                            <i class="ri-time-line"></i>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <div>
                                                            <h5 class="font-size-13">Sem validações recentes</h5>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
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
                                                @foreach($recentTasks as $idx => $task)
                                                    @php $dt = \Carbon\Carbon::parse($task->created_at); @endphp
                                                    <tr>
                                                        <td>{{ $idx + 1 }}</td>
                                                        <td><a href="https://redmine.pbsoft.com.br/issues/{{ (int)$task->id }}" target="_blank" rel="noopener" class="text-dark font-weight-bold">{{ (int)$task->id }}</a></td>
                                                        <td>{{ $dt->format('d/m/Y') }}</td>
                                                        <td><div class="badge {{ strtolower(trim($task->status)) === 'validado' ? 'badge-soft-success' : 'badge-soft-secondary' }} font-size-12">{{ $task->status }}</div></td>
                                                        <td>{{ $task->assigned_to ?? '-' }}</td>
                                                        <td class="text-right"><a href="https://redmine.pbsoft.com.br/issues/{{ (int)$task->id }}" target="_blank" rel="noopener" class="mr-2 text-primary" title="Abrir no Redmine"><i class="mdi mdi-eye font-size-18"></i></a></td>
                                                    </tr>
                                                @endforeach
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
    <script>
        // Toggle custom date inputs for multiple filters
        (function(){
            function bindToggle(rangeId, opts){
                var range = document.getElementById(rangeId);
                var start = document.getElementById(opts.startId);
                var end = document.getElementById(opts.endId);
                var extra = opts.extraId ? document.getElementById(opts.extraId) : null;
                function toggle(){
                    if(!range) return;
                    if(range.value === 'custom'){
                        if(start) start.style.display = 'inline-block';
                        if(end) end.style.display = 'inline-block';
                        if(extra) extra.style.display = 'inline-block';
                    } else {
                        if(start) start.style.display = 'none';
                        if(end) end.style.display = 'none';
                        if(extra) extra.style.display = 'none';
                    }
                }
                if(range){ range.addEventListener('change', toggle); toggle(); }
            }

            // Bind top-projects filter (two date inputs)
            bindToggle('top-projects-range-select', { startId: 'top-projects-start-date', endId: 'top-projects-end-date' });

            // Client-side validation for sprint range form: if both values are numeric and from>to, swap them
            var sprintsForm = document.getElementById('sprints-filter-form');
            if (sprintsForm) {
                sprintsForm.addEventListener('submit', function(e){
                    try {
                        var f = this.querySelector('select[name="from"]');
                        var t = this.querySelector('select[name="to"]');
                        if (f && t && f.value && t.value) {
                            var fi = parseInt(f.value,10);
                            var ti = parseInt(t.value,10);
                            if (!isNaN(fi) && !isNaN(ti) && fi > ti) {
                                // swap to be user-friendly
                                var tmp = f.value; f.value = t.value; t.value = tmp;
                            }
                        }
                    } catch(err){ /* fail silently */ }
                });
            }
        })();

        // Donut chart is initialized by `assets/js/pages/dashboard.init.js`
    </script>

    {{-- Inject server-side top projects arrays for dashboard.init.js to consume --}}
    <script>
        window.topProjectsLabels = @json($topProjectsLabels ?? []);
        window.topProjectsCounts = @json($topProjectsCounts ?? []);
        window.topProjectsPercentages = @json($topProjectsPercentages ?? []);
        window.topPeriodLabel = @json($topPeriodLabel ?? null);
        window.devList = @json($devs ?? []);
        window.initialDev = @json(request('dev') ?? null);
        window.initialDevRange = @json(request('dev_range', 'month'));
        window.initialDevStart = @json(request('dev_start') ?? null);
        window.initialDevEnd = @json(request('dev_end') ?? null);
    </script>

    <script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js"></script>

    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <script src="assets/js/pages/datatables.init.js"></script>

    <script src="assets/libs/chart.js/Chart.bundle.min.js"></script>
    <script>
        // Prevent static initializers from rendering the spline area; dynamic loader will render it.
        window.__sprintsAreaManaged = true;
    </script>

    <script src="{{ asset('assets/js/pages/dashboard.init.js') }}?v={{ filemtime(public_path('assets/js/pages/dashboard.init.js')) }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard_projects.init.js') }}?v={{ filemtime(public_path('assets/js/pages/dashboard_projects.init.js')) }}"></script>

    <script src="assets/js/app.js"></script>

</body>
</html>
