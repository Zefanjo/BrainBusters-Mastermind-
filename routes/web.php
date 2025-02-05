<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/game', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/scoreboard', function () {
    return view('scoreboard');
});

Route::get('/rules', function () {
    return view('rules');
});

Route::post('/start-game', [GameController::class, 'startGame']);
Route::post('/check-guess', [GameController::class, 'checkGuess']);