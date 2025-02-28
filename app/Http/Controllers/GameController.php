<?php

namespace App\Http\Controllers;

use App\Models\game;
use Illuminate\Http\Request;

class GameController extends Controller
{

    public function index()
    {
        $game = game::all();

        return view('test', ['games' => $game]);
    }

    public function store(Request $request)
    {
        $game = $request->validate([
            'name' => 'string|required|max:20'
        ]);
        $game['user_id'] = auth()->id();
        $game['name'] = $request->name();
        $game['turns'] = $request->turns;
        $game['won'] = $request->won;
        $game['game_time'] = $request->game_time;
        $game = new games($game);
        $game->save();
        return back();
    }

    public function startGame(Request $request)
    {
        $colors = ['red', 'orange', 'yellow', 'green', 'lightblue', 'blue'];

        shuffle($colors);
        $answer = array_slice($colors, 0, 4);

        error_log("Generated Answer: " . json_encode($answer)); // Log to server

        $request->session()->put('mastermind_answer', $answer);
        return response()->json([
            'message' => 'Game started successfully!',
            'answer' => $answer // Remove this in production
        ]);
    }

    public function checkGuess(Request $request)
    {
        $answer = $request->session()->get('mastermind_answer');

        if (!$answer) {
            return response()->json(['error' => 'Game not started. Please start a new game.'], 400);
        }

        $guess = $request->input('guess');

        if (count($guess) !== 4) {
            return response()->json(['error' => 'Invalid guess. Please provide 4 colors.'], 400);
        }

        $feedback = [];
        $answerCounts = array_count_values($answer); // Tel hoe vaak elke kleur voorkomt in de geheime code
        $guessCounts = array_count_values($guess);   // Tel hoe vaak elke kleur voorkomt in de gok
        $exactMatches = 0;
        $partialMatches = 0;

        // 🔹 Eerste loop: Zoek exacte matches (juiste kleur én positie)
        for ($i = 0; $i < 4; $i++) {
            if ($guess[$i] === $answer[$i]) {
                $exactMatches++;
                $answerCounts[$guess[$i]]--; // Verminder de teller voor deze kleur
                $guessCounts[$guess[$i]]--;
            }
        }

        // 🔹 Tweede loop: Zoek juiste kleur, verkeerde positie
        foreach ($guessCounts as $color => $count) {
            if (isset($answerCounts[$color]) && $answerCounts[$color] > 0) {
                // Tel het minimum aantal voor correcte kleuren op de verkeerde plek
                $partialMatches += min($answerCounts[$color], $count);
            }
        }

        // Voeg de juiste symbolen toe
        $feedback = array_merge(array_fill(0, $exactMatches, '*'), array_fill(0, $partialMatches, '+'));

        // Sorteer de feedback zodat het consistent is
        sort($feedback);

        if ($exactMatches === 4) {
            return response()->json([
                'message' => 'You win!',
                'answer' => $answer,
                'feedback' => implode('', $feedback),
            ]);
        }

        return response()->json([
            'feedback' => implode('', $feedback),
        ]);
    }}
