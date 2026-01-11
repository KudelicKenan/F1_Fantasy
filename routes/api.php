<?php

use App\Http\Controllers\DriverController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

// Internal API routes - zahtijevaju autentifikaciju
Route::middleware(['auth'])->group(function () {
    // Test endpoint - proveri autentifikaciju
    Route::get('auth/check', function () {
        return response()->json([
            'authenticated' => true,
            'user' => [
                'id' => auth()->id(),
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'message' => 'Autentifikacija uspešna!'
        ]);
    });
    
    // CRUD za Drivers
    Route::apiResource('drivers', DriverController::class)->names([
        'index' => 'api.drivers.index',
        'store' => 'api.drivers.store',
        'show' => 'api.drivers.show',
        'update' => 'api.drivers.update',
        'destroy' => 'api.drivers.destroy',
    ]);
    
    // Statistics API
    Route::get('statistics', [StatisticsController::class, 'index']);
    Route::get('statistics/drivers', [StatisticsController::class, 'driverStats']);
    Route::get('statistics/teams', [StatisticsController::class, 'teamStats']);
    Route::get('statistics/fantasy-teams', [StatisticsController::class, 'fantasyTeamStats']);
    
    // Weather API
    Route::get('races/{race}/weather', [\App\Http\Controllers\WeatherController::class, 'getWeatherForRace']);
    Route::post('races/update-weather', [\App\Http\Controllers\WeatherController::class, 'updateAllRacesWeather']);
});

// Public API routes (bez autentifikacije)
Route::get('public/drivers', [DriverController::class, 'index']);
Route::get('public/drivers/{id}', [DriverController::class, 'show']);
Route::get('public/teams', [\App\Http\Controllers\TeamController::class, 'index']);
Route::get('public/teams/{id}', [\App\Http\Controllers\TeamController::class, 'show']);
Route::get('public/races', [\App\Http\Controllers\RaceController::class, 'index']);
Route::get('public/races/{id}', [\App\Http\Controllers\RaceController::class, 'show']);

// Public basic statistics (bez detaljnih podataka)
Route::get('public/stats', function () {
    return response()->json([
        'total_drivers' => \App\Models\Driver::count(),
        'total_teams' => \App\Models\Team::count(),
        'total_races' => \App\Models\Race::count(),
        'top_driver' => \App\Models\Driver::with('team')->orderBy('points', 'desc')->first(['id', 'name', 'points', 'team_id']),
        'top_team' => \App\Models\Team::orderBy('total_points', 'desc')->first(['id', 'name', 'total_points']),
    ]);
});

