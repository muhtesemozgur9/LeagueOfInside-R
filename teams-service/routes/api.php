<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    TeamController,
    FixtureController,
    SimulationController,
    StandingsController,
    ChampionshipController
};

Route::prefix('fixture')->group(function(){
    Route::post('/generate', [FixtureController::class, 'generate']);
    Route::prefix('schedule')->group(function(){
        Route::get('/', [FixtureController::class, 'schedule']);
        Route::get('/latest', [FixtureController::class, 'latestSchedule']);
    });
});

Route::prefix('teams')->group(function () {
    Route::get('/', [TeamController::class, 'index']);
});

Route::prefix('simulate')->group(function (){
    Route::post('/', [SimulationController::class, 'simulateMatches']);
    Route::post('/reset', [SimulationController::class, 'reset']);
});

Route::get('/standings', [StandingsController::class, 'index']);

Route::get('/championship-probabilities', [ChampionshipController::class, 'index']);

