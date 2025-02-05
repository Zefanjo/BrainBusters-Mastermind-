<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/game', function () {
    return view('index');
});

Route::get('/login', [\App\Http\Controllers\UserController::class, 'index'])->name('login');

Route::get('/register', [\App\Http\Controllers\UserController::class, 'create'])->name('register');

Route::get('/test', [\App\Http\Controllers\GameController::class, 'index']);

Route::get('/scoreboard', [\App\Http\Controllers\ScoreController::class, 'index']);

Route::post('/start-game', [GameController::class, 'startGame']);
Route::post('/check-guess', [GameController::class, 'checkGuess']);