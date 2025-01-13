<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\GameController;

Route::post('/start-game', [GameController::class, 'startGame']);
Route::post('/check-guess', [GameController::class, 'checkGuess']);
