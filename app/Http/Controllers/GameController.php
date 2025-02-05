<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function startGame(Request $request)
    {
        $colors = ['red', 'green', 'blue', 'yellow', 'black', 'white'];

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

        if (implode('', $feedback) === '****') {
            return response()->json([
                'message' => 'You win!',
                'answer' => $answer,
                'feedback' => implode('', $feedback),
            ]);
        }

        return response()->json([
            'feedback' => implode('', $feedback),
        ]);
    }
}









