<?php

namespace App\Http\Controllers;

use App\Models\game; // Ensure it's using the correct model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index()
    {
        $games = game::orderBy('game_time', 'desc')->get();
        return view('test', compact('games')); // Pass data to scoreboard view
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:20',
            'turns' => 'required|integer',
            'won' => 'required|boolean',
            'game_time' => 'required|date',
        ]);

        $validatedData['user_id'] = Auth::id();

        game::create($validatedData);

        return back();
    }

    public function startGame(Request $request)
    {
        $colors = ['red', 'green', 'blue', 'yellow', 'black', 'white'];

        shuffle($colors);
        $answer = array_slice($colors, 0, 4);

        $request->session()->put('mastermind_answer', $answer);
        $request->session()->put('turns', 0); // Track turns

        return response()->json([
            'message' => 'Game started successfully!',
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
        $tempAnswer = $answer;

        for ($i = 0; $i < 4; $i++) {
            if ($guess[$i] === $tempAnswer[$i]) {
                $feedback[] = '*';
                $tempAnswer[$i] = null;
                $guess[$i] = null;
            }
        }

        for ($i = 0; $i < 4; $i++) {
            if ($guess[$i] !== null) {
                $index = array_search($guess[$i], $tempAnswer);
                if ($index !== false) {
                    $feedback[] = '+';
                    $tempAnswer[$index] = null;
                }
            }
        }

        sort($feedback);
        $turns = $request->session()->increment('turns');

        // If the player wins
        if (implode('', $feedback) === '****') {
            game::create([
                'user_id' => Auth::id(),
                'name' => Auth::user()->name ?? 'Guest',
                'turns' => $turns,
                'won' => true,
                'game_time' => now(),
            ]);

            return response()->json([
                'message' => 'You win!',
                'answer' => $answer,
                'feedback' => implode('', $feedback),
            ]);
        }

        // If the player loses after 10 turns
        if ($turns >= 10) {
            game::create([
                'user_id' => Auth::id(),
                'name' => Auth::user()->name ?? 'Guest',
                'turns' => $turns,
                'won' => false,
                'game_time' => now(),
            ]);

            return response()->json([
                'message' => 'Out of turns! You lose!',
                'answer' => $answer,
            ]);
        }

        return response()->json([
            'feedback' => implode('', $feedback),
            'turns' => $turns,
        ]);
    }
}
