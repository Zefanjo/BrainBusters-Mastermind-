<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mastermind Board</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container">
    <div class="back">
        <a href="welcome">
            <button class="backbtn">Back</button>
        </a>
    </div>
    <div class="mastermind">
        <div class="mastermind-board">
            <div>
                <div class="row">
                    <div class="guess">
                        <div id="peg1" class="pin"></div>
                        <div id="peg2" class="pin"></div>
                        <div id="peg3" class="pin"></div>
                        <div id="peg4" class="pin"></div>
                    </div>
                    <div class="feedback">
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="guess">
                        <div id="peg1" class="pin"></div>
                        <div id="peg2" class="pin"></div>
                        <div id="peg3" class="pin"></div>
                        <div id="peg4" class="pin"></div>
                    </div>
                    <div class="feedback">
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="guess">
                        <div id="peg1" class="pin"></div>
                        <div id="peg2" class="pin"></div>
                        <div id="peg3" class="pin"></div>
                        <div id="peg4" class="pin"></div>
                    </div>
                    <div class="feedback">
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="guess">
                        <div id="peg1" class="pin"></div>
                        <div id="peg2" class="pin"></div>
                        <div id="peg3" class="pin"></div>
                        <div id="peg4" class="pin"></div>
                    </div>
                    <div class="feedback">
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="guess">
                        <div id="peg1" class="pin"></div>
                        <div id="peg2" class="pin"></div>
                        <div id="peg3" class="pin"></div>
                        <div id="peg4" class="pin"></div>
                    </div>
                    <div class="feedback">
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="guess">
                        <div id="peg1" class="pin"></div>
                        <div id="peg2" class="pin"></div>
                        <div id="peg3" class="pin"></div>
                        <div id="peg4" class="pin"></div>
                    </div>
                    <div class="feedback">
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="guess">
                        <div id="peg1" class="pin"></div>
                        <div id="peg2" class="pin"></div>
                        <div id="peg3" class="pin"></div>
                        <div id="peg4" class="pin"></div>
                    </div>
                    <div class="feedback">
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="guess">
                        <div id="peg1" class="pin"></div>
                        <div id="peg2" class="pin"></div>
                        <div id="peg3" class="pin"></div>
                        <div id="peg4" class="pin"></div>
                    </div>
                    <div class="feedback">
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                        <div class="feedback-pin"></div>
                    </div>
                </div>
                <div>
                    <div id="colorPalette">
                        <div class="color-peg" data-color="red" style="background-color: red;"></div>
                        <div class="color-peg" data-color="orange" style="background-color: orange;"></div>
                        <div class="color-peg" data-color="yellow" style="background-color: yellow;"></div>
                        <br>
                        <div class="color-peg" data-color="green" style="background-color: green;"></div>
                        <div class="color-peg" data-color="blue" style="background-color: blue;"></div>
                        <div class="color-peg" data-color="lightblue" style="background-color: lightblue;"></div>
                    </div>
                    <div>
                        <table style="margin: 0 auto; width: 60%; text-align: center;">
                            <thead>
                            <tr>
                                <button id="checkGuess" class="mastermind-button">Submit Guess</button>
                                <button id="resetBoard" class="mastermind-button">Clear Last Peg</button>
                            </tr>
                            </thead>
                            <tbody id="guesses"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
