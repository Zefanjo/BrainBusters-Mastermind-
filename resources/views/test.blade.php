<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mastermind Game</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .guess-inputs {
            margin: 20px 0;
        }
        .color-peg {
            display: inline-block;
            width: 50px;
            height: 50px;
            cursor: pointer;
            margin: 10px;
        }
        .peg {
            display: inline-block;
            width: 50px;
            height: 50px;
            margin: 10px;
            border: 1px solid #000;
        }
    </style>
</head>
<body>
<h1>Mastermind Game</h1>

<button id="start-game">Start Game</button>
<div>
    <h2>Pick colors for the pegs:</h2>
    <div id="colorPalette">
        <div class="color-peg" data-color="red" style="background-color: red;"></div>
        <div class="color-peg" data-color="green" style="background-color: green;"></div>
        <div class="color-peg" data-color="blue" style="background-color: blue;"></div>
        <div class="color-peg" data-color="yellow" style="background-color: yellow;"></div>
        <div class="color-peg" data-color="black" style="background-color: black;"></div>
        <div class="color-peg" data-color="white" style="background-color: white;"></div>
    </div>
</div>

<h3>Your Guess:</h3>
<div>
    <div id="peg1" class="peg"></div>
    <div id="peg2" class="peg"></div>
    <div id="peg3" class="peg"></div>
    <div id="peg4" class="peg"></div>
</div>

<table border="1" style="margin: 0 auto; width: 60%; text-align: center;">
    <thead>
    <tr>
        <th>Turn</th>
        <button id="checkGuess">Submit Guess</button>
        <button id="resetBoard">Clear Last Peg</button>
        <th>Previous Guesses</th>
        <th>Feedback</th>
    </tr>
    </thead>
    <tbody id="guesses"></tbody>
</table>
</body>
</html>
