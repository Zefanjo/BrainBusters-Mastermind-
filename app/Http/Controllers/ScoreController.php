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

    public function showScoreboard()
    {
        $topScores = Game::where('won', true)
            ->orderBy('turns', 'asc') // Best scores first
            ->limit(10)
            ->get();

        return view('scoreboard', ['topScores' => $topScores]); // Pass to the Blade view
    }


    public function getTopScores()
    {
        $topScores = Game::where('won', true)
            ->orderBy('turns', 'asc') // Best scores first
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


