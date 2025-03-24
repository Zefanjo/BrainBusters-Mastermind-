<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\game;

class ScoreController extends Controller
{
    public function index()
    {
        $topScores = Game::where('won', true)
            ->orderBy('turns', 'asc')
            ->orderBy('game_time', 'asc')
            ->limit(10)
            ->get();

        return view('scoreboard', ['topScores' => $topScores]);
    }



    public function getTopScores()
    {
        $topScores = Game::where('won', true)
            ->with('user')
            ->orderBy('turns', 'asc')
            ->orderBy('game_time', 'asc')
            ->limit(10)
            ->get();

        return response()->json($topScores);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }


}


