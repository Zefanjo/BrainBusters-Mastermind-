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
    </style>
</head>
<body>
<h1>Mastermind Game</h1>

<button id="startGame">Start Game</button>
<p>Click "Start Game" to begin. You have 10 turns to guess the correct sequence!</p>

<div>
    <h2>Pick colors for the pegs:</h2>

    <!-- Peg 1 -->
    <div id="peg1-color" class="color-peg" data-peg="1" style="display: inline-block; width: 50px; height: 50px; background-color: red;"></div>
    <div id="peg2-color" class="color-peg" data-peg="2" style="display: inline-block; width: 50px; height: 50px; background-color: green;"></div>
    <div id="peg3-color" class="color-peg" data-peg="3" style="display: inline-block; width: 50px; height: 50px; background-color: blue;"></div>
    <div id="peg4-color" class="color-peg" data-peg="4" style="display: inline-block; width: 50px; height: 50px; background-color: yellow;"></div>
    <div id="peg4-color" class="color-peg" data-peg="4" style="display: inline-block; width: 50px; height: 50px; background-color: black;"></div>
    <div id="peg4-color" class="color-peg" data-peg="4" style="display: inline-block; width: 50px; height: 50px; background-color: white;"></div>
</div>

<!-- Placeholder to show current guesses -->
<h3>Your Guess:</h3>
<div>
    <div id="peg1" class="peg" style="display: inline-block; width: 50px; height: 50px;"></div>
    <div id="peg2" class="peg" style="display: inline-block; width: 50px; height: 50px;"></div>
    <div id="peg3" class="peg" style="display: inline-block; width: 50px; height: 50px;"></div>
    <div id="peg4" class="peg" style="display: inline-block; width: 50px; height: 50px;"></div>
</div>


<table border="1" style="margin: 0 auto; width: 60%; text-align: center;">
    <thead>
    <tr>
        <th>Turn</th>
        <th>Guess</th>
        <th>Feedback</th>
    </tr>
    </thead>
    <tbody id="guesses">

    </tbody>
</table>
</body>
</html>
