<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardTesteApiController;

Route::view('/', 'dashboard');

Route::view('/dashboard-teste', 'dashboard_teste_fixed')->name('dashboard.teste');

// API endpoints for Dashboard de Testes (using web.php since routes/api.php is not present)
Route::prefix('api')->group(function () {
    Route::get('/tests/status-distribution', [DashboardTesteApiController::class, 'statusDistribution']);
    Route::get('/devs/activities-count', [DashboardTesteApiController::class, 'devActivitiesCount']);
    Route::get('/structures/tests-count', [DashboardTesteApiController::class, 'structuresTestsCount']);
});
