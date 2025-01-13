<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function startGame(Request $request)
    {
        // Available colors
        $colors = ['red', 'green', 'blue', 'yellow', 'black', 'white'];

        // Generate random answer
        $answer = [
            $colors[rand(0, 5)],
            $colors[rand(0, 5)],
            $colors[rand(0, 5)],
            $colors[rand(0, 5)],
        ];

        // Store the answer in the session
        $request->session()->put('mastermind_answer', $answer);

        // Return a response
        return response()->json([
            'message' => 'Game started successfully!',
        ]);
    }

    public function checkGuess(Request $request)
    {
        // Retrieve the stored answer from the session
        $answer = $request->session()->get('mastermind_answer');

        if (!$answer) {
            return response()->json(['error' => 'Game not started. Please start a new game.'], 400);
        }

        // Retrieve the user's guess from the request
        $guess = $request->input('guess');

        if (count($guess) !== 4) {
            return response()->json(['error' => 'Invalid guess. Please provide 4 colors.'], 400);
        }

        // Feedback logic
        $feedback = [];
        $tempAnswer = $answer;

        // Check for exact matches
        for ($i = 0; $i < 4; $i++) {
            if ($guess[$i] === $tempAnswer[$i]) {
                $feedback[] = '*'; // Exact match
                $tempAnswer[$i] = null; // Mark as matched
                $guess[$i] = null; // Mark as checked
            }
        }

        // Check for color matches in different positions
        for ($i = 0; $i < 4; $i++) {
            if ($guess[$i] !== null) {
                $index = array_search($guess[$i], $tempAnswer);
                if ($index !== false) {
                    $feedback[] = '+'; // Color match, wrong position
                    $tempAnswer[$index] = null; // Mark as matched
                }
            }
        }

        // Sort feedback for consistency (optional)
        sort($feedback);

        // Check if the user has won
        if (implode('', $feedback) === '****') {
            return response()->json([
                'message' => 'You win!',
                'answer' => $answer,
                'feedback' => implode('', $feedback),
            ]);
        }

        // Return feedback
        return response()->json([
            'feedback' => implode('', $feedback),
        ]);
    }
}
