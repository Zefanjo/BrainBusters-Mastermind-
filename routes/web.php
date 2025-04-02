<?php

use App\Http\Controllers\ScoreController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('welcome', function () {
    return view('welcome');
});

Route::get('/game', function () {
    return view('game');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/login', [\App\Http\Controllers\UserController::class, 'index'])->name('login');

Route::get('/register', [\App\Http\Controllers\UserController::class, 'create'])->name('register');

Route::get('/test', [\App\Http\Controllers\GameController::class, 'index']);

Route::get('/scoreboard', [\App\Http\Controllers\ScoreController::class, 'index']);

Route::get('/rules', function () {
    return view('rules');
});

Route::post('/start-game', [GameController::class, 'startGame']);
Route::post('/check-guess', [GameController::class, 'checkGuess']);
Route::get('/scoreboard-data', [ScoreController::class, 'getTopScores']);

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\UserController::class, 'update'])->name('profile.update');
    Route::post('/logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('logout');
});