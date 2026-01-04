<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardTesteApiController;

use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/api/dashboard/summary', [DashboardController::class, 'summary']);

Route::view('/dashboard-teste', 'dashboard_teste_fixed')->name('dashboard.teste');
// Tela com todos os projetos mostrando o gráfico de "Testes por Estrutura"
Route::get('/projects', [DashboardController::class, 'projectsAll'])->name('projects.all');

// API endpoints for Dashboard de Testes (using web.php since routes/api.php is not present)
Route::prefix('api')->group(function () {
    Route::get('/tests/status-distribution', [DashboardTesteApiController::class, 'statusDistribution']);
    Route::get('/tests/by-status', [DashboardTesteApiController::class, 'testsByStatus']);
    Route::get('/tests/search', [DashboardTesteApiController::class, 'testsSearch']);
    Route::get('/tests/sprints', [DashboardTesteApiController::class, 'sprints']);
    Route::get('/devs/activities-count', [DashboardTesteApiController::class, 'devActivitiesCount']);
    Route::get('/structures/tests-count', [DashboardTesteApiController::class, 'structuresTestsCount']);
});

// API route used by dashboard spline area chart
Route::get('api/dashboard/sprints-tasks', [\App\Http\Controllers\DashboardController::class, 'sprintsTasks']);
