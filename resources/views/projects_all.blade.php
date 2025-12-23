<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos - Todos | PBMonitor</title>
    <base href="{{ asset('') }}">
    <link rel="stylesheet" href="assets/css/style.css">
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
                            <span class="logo-sm"><img src="assets/images/logo-sm-light.png" alt="" height="18"></span>
                            <span class="logo-lg"><img src="assets/images/logo-light.png" alt="" height="30"></span>
                        </a>
                    </div>
                    <div class="dropdown dropdown-mega d-none d-lg-block ml-2">
                        <button class="btn header-item cursor-default"><i class="mdi mdi-briefcase"></i> Todos os Projetos</button>
                    </div>
                </div>
                <div class="d-flex pr-2">
                    <div class="d-none d-lg-inline-block">
                        <a href="{{ url('/') }}" class="btn header-item noti-icon waves-effect d-flex align-items-center" title="Voltar ao Dashboard">
                            <span class="d-none d-xl-inline-block ml-2">Voltar</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div class="main-content">
            <div class="page-content mt-3">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-3">Testes por Estrutura — Todos os Projetos</h4>

                                    <form id="projects-filter" class="form-inline mb-3" method="get" action="{{ route('projects.all') }}">
                                        <label class="mr-2">Período:</label>
                                        <select name="range" id="range-select-projects" class="custom-select custom-select-sm mr-2">
                                            <option value="month" {{ request('range','month')=='month' ? 'selected' : '' }}>Este mês</option>
                                            <option value="year" {{ request('range')=='year' ? 'selected' : '' }}>Este ano</option>
                                            <option value="custom" {{ request('range')=='custom' ? 'selected' : '' }}>Personalizado</option>
                                        </select>
                                        <input type="date" name="start" id="start-date-projects" class="form-control form-control-sm mr-2" value="{{ request('start') }}" style="display: none;">
                                        <input type="date" name="end" id="end-date-projects" class="form-control form-control-sm mr-2" value="{{ request('end') }}" style="display: none;">
                                        <button type="submit" class="btn btn-sm btn-primary">Aplicar</button>
                                    </form>

                                    <!-- copied chart container from dashboard_teste_fixed -->
                                    <div id="testes-por-estrutura" class="apex-charts" style="min-height:360px"></div>

                                    <p class="text-muted mt-3">Use o seletor de período acima para filtrar os dados.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <footer class="footer text-center mt-4">&copy; <script>document.write(new Date().getFullYear())</script> PBMonitor</footer>
        </div>
    </div>

    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        // Toggle custom date inputs for projects filter
        (function(){
            var range = document.getElementById('range-select-projects');
            var start = document.getElementById('start-date-projects');
            var end = document.getElementById('end-date-projects');
            function toggle() {
                if (!range) return;
                if (range.value === 'custom') { start.style.display = 'inline-block'; end.style.display = 'inline-block'; }
                else { start.style.display = 'none'; end.style.display = 'none'; }
            }
            if (range) { range.addEventListener('change', toggle); toggle(); }
        })();
    </script>
    {{-- Inject server-side arrays for the chart init script --}}
    <script>
        window.topProjectsLabels = @json($topProjectsLabels ?? []);
        window.topProjectsCounts = @json($topProjectsCounts ?? []);
        window.topProjectsPercentages = @json($topProjectsPercentages ?? []);
        window.periodLabel = @json($periodLabel ?? null);
    </script>
    <!-- load projects-specific chart initializer (separate from dashboard_teste) -->
    <script src="assets/js/pages/dashboard_projects.init.js"></script>
</body>
</html>
