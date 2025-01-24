<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\game;

class ScoreController extends Controller
{
    public function index()
    {
        $score = game::all();

        return view('scoreboard', ['scores' => $score]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }
}
