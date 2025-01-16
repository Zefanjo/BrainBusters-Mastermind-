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

<button id="startGame">Start Game</button>
<p>Click "Start Game" to begin. You have 10 turns to guess the correct sequence!</p>

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

<!-- Placeholder to show current guesses -->
<h3>Your Guess:</h3>
<div>
    <div id="peg1" class="peg"></div>
    <div id="peg2" class="peg"></div>
    <div id="peg3" class="peg"></div>
    <div id="peg4" class="peg"></div>
</div>

<!-- Table to show previous guesses and feedback -->
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
    const filledPegs = []; // Stack to track the order of filled pegs
    let guessCount = 0; // Counter for the number of guesses
    const maxGuesses = 6; // Maximum allowed guesses

    // Handle color selection and auto-fill the next empty peg
    document.querySelectorAll('.color-peg').forEach(colorPeg => {
        colorPeg.addEventListener('click', function () {
            selectedColor = colorPeg.dataset.color;

            // Find the next empty peg
            const nextEmptyPeg = Array.from(document.querySelectorAll('.peg')).find(peg => !peg.style.backgroundColor);

            if (nextEmptyPeg) {
                nextEmptyPeg.style.backgroundColor = selectedColor;
                filledPegs.push(nextEmptyPeg); // Add to the stack
            } else {
                alert('All pegs are filled! Submit your guess or clear the board.');
            }
        });
    });

    // Clear the last filled peg
    document.getElementById('resetBoard').addEventListener('click', function () {
        if (filledPegs.length > 0) {
            const lastPeg = filledPegs.pop(); // Remove the last peg from the stack
            lastPeg.style.backgroundColor = ''; // Clear its color
        } else {
            alert('No more pegs to clear!');
        }
    });

    // Handle guess submission
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
                alert(data.message); // E.g., "You win!"
            }

            // Display feedback in the table (same as before)
            const feedbackRow = document.createElement('tr');

            // Increment and display the guess count
            guessCount++;
            const turnCell = document.createElement('td');
            turnCell.textContent = guessCount; // Use guess count instead of time
            feedbackRow.appendChild(turnCell);

            // Add the guess as colored boxes
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

            // Add the feedback (use symbols like `*` or `+`)
            const feedbackCell = document.createElement('td');
            data.feedback.split('').forEach(symbol => {
                const feedbackIndicator = document.createElement('div');
                feedbackIndicator.style.width = '15px';
                feedbackIndicator.style.height = '15px';
                feedbackIndicator.style.display = 'inline-block';
                feedbackIndicator.style.margin = '0 2px';

                if (symbol === '*') {
                    feedbackIndicator.style.backgroundColor = 'green'; // Correct position
                } else if (symbol === '+') {
                    feedbackIndicator.style.backgroundColor = 'nigger'; // Correct color, wrong position
                }

                feedbackCell.appendChild(feedbackIndicator);
            });
            feedbackRow.appendChild(feedbackCell);

            // Append the row to the guesses table
            document.getElementById('guesses').appendChild(feedbackRow);

            // Automatically clear the board
            clearBoard();

            // Check if we've reached the maximum guesses
            if (guessCount >= maxGuesses) {
                alert('Nice Try! You have used all your guesses.');
                resetGame(); // Restart the game after clicking "OK"
            }
        }).catch(error => {
            console.error('Error checking guess:', error);
        });
    });

    // Function to clear the board
    function clearBoard() {
        document.querySelectorAll('.peg').forEach(peg => {
            peg.style.backgroundColor = ''; // Clear the color
        });
        filledPegs.length = 0; // Reset the stack
    }

    // Function to reset the game after 6 guesses or after winning
    function resetGame() {
        // Reset game state
        guessCount = 0; // Reset the guess count
        clearBoard(); // Clear the board
        document.getElementById('guesses').innerHTML = ''; // Clear the feedback table
        alert('The game is restarting! Click "Start Game" to play again.');
        // Optionally, trigger the start game API or UI action if needed
        // fetch('/start-game', {...}); // Uncomment if needed
    }

</script>
</body>
</html>
