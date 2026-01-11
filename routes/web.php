<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\RaceController;
use App\Http\Controllers\FantasyTeamController;
use App\Http\Controllers\FantasyTeamDriverController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\SocialiteController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Socialite routes (3rd party authentication)
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

Route::get('/auth/github', [SocialiteController::class, 'redirectToGithub'])->name('auth.github');
Route::get('/auth/github/callback', [SocialiteController::class, 'handleGithubCallback']);

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD routes
    Route::resource('drivers', \App\Http\Controllers\DriverController::class);
    Route::resource('teams', \App\Http\Controllers\TeamController::class);
    Route::resource('races', \App\Http\Controllers\RaceController::class);
    Route::resource('fantasy-teams', \App\Http\Controllers\FantasyTeamController::class);
    Route::delete('fantasy-teams/{fantasyTeam}/drivers/{driver}', [\App\Http\Controllers\FantasyTeamController::class, 'removeDriver'])->name('fantasy-teams.remove-driver');
    
    // Weather API routes
    Route::get('races/{race}/weather', [\App\Http\Controllers\WeatherController::class, 'getWeatherForRace'])->name('races.weather');
    Route::post('races/update-weather', [\App\Http\Controllers\WeatherController::class, 'updateAllRacesWeather']);
});

require __DIR__.'/settings.php';
