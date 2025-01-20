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

<script>
    let selectedColor = null;
    let guessCount = 0;
    const filledPegs = [];
    const maxGuesses = 6;

    document.querySelectorAll('.color-peg').forEach(colorPeg => {
        colorPeg.addEventListener('click', function () {
            selectedColor = colorPeg.dataset.color;

            const nextEmptyPeg = Array.from(document.querySelectorAll('.peg')).find(peg => !peg.style.backgroundColor);

            if (nextEmptyPeg) {
                nextEmptyPeg.style.backgroundColor = selectedColor;
                filledPegs.push(nextEmptyPeg);
            } else {
                alert('All pegs are filled! Submit your guess or clear the board.');
            }
        });
    });

    document.getElementById('resetBoard').addEventListener('click', function () {
        if (filledPegs.length > 0) {
            const lastPeg = filledPegs.pop();
            lastPeg.style.backgroundColor = '';
        } else {
            alert('No more pegs to clear!');
        }
    });


    document.getElementById('checkGuess').addEventListener('click', function () {
        const guess = Array.from(document.querySelectorAll('.peg')).map(peg => {
            return peg.style.backgroundColor || null;
        });

        if (guess.includes(null)) {
            alert('Please fill all the pegs before submitting your guess.');
            return;
        }

        fetch('/check-guess', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ guess })
        }).then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        }).then(data => {
            if (data.message) {
                alert(data.message);
            }

            const feedbackRow = document.createElement('tr');

            guessCount++;
            const turnCell = document.createElement('td');
            turnCell.textContent = guessCount;
            feedbackRow.appendChild(turnCell);

            const guessCell = document.createElement('td');
            guess.forEach(color => {
                const colorBox = document.createElement('div');
                colorBox.style.backgroundColor = color;
                colorBox.style.width = '30px';
                colorBox.style.height = '30px';
                colorBox.style.display = 'inline-block';
                colorBox.style.margin = '0 5px';
                guessCell.appendChild(colorBox);
            });
            feedbackRow.appendChild(guessCell);

            const feedbackCell = document.createElement('td');
            data.feedback.split('').forEach(symbol => {
                const feedbackIndicator = document.createElement('div');
                feedbackIndicator.style.width = '15px';
                feedbackIndicator.style.height = '15px';
                feedbackIndicator.style.display = 'inline-block';
                feedbackIndicator.style.margin = '0 2px';

                if (symbol === '*') {
                    feedbackIndicator.style.backgroundColor = 'green';
                } else if (symbol === '+') {
                    feedbackIndicator.style.backgroundColor = 'orange';
                }

                feedbackCell.appendChild(feedbackIndicator);
            });
            feedbackRow.appendChild(feedbackCell);

            document.getElementById('guesses').appendChild(feedbackRow);

            clearBoard();

            if (guessCount >= maxGuesses) {
                alert('Nice Try! You have used all your guesses.');
                resetGame();
            }
        }).catch(error => {
            console.error('Error checking guess:', error);
        });
    });

    function clearBoard() {
        document.querySelectorAll('.peg').forEach(peg => {
            peg.style.backgroundColor = '';
        });
        filledPegs.length = 0;
    }

    function resetGame() {
        guessCount = 0;
        clearBoard();
        document.getElementById('guesses').innerHTML = '';
        alert('The game is restarting! Click "Start Game" to play again.');
    }

</script>
</body>
</html>
