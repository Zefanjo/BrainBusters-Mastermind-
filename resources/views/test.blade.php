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

        <th>Feedback</th>
    </tr>
    </thead>
    <tbody id="guesses"></tbody>
</table>

<script>
    let selectedColor = null;

    // Handle color selection
    document.querySelectorAll('.color-peg').forEach(peg => {
        peg.addEventListener('click', function () {
            selectedColor = peg.dataset.color;
            alert(`Selected color: ${selectedColor}`); // Debugging
        });
    });

    // Handle peg coloring
    document.querySelectorAll('.peg').forEach(peg => {
        peg.addEventListener('click', function () {
            if (selectedColor) {
                peg.style.backgroundColor = selectedColor;
            }
        });
    });

    // Start game
    document.getElementById('startGame').addEventListener('click', function () {
        fetch('/start-game', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        }).then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        }).then(data => {
            alert(data.message); // Game started successfully
        }).catch(error => {
            console.error('Error starting game:', error);
        });
    });

    // Check guess functionality (Add your own button for this if needed)
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
            } else if (data.feedback) {
                // Create a new table row for feedback
                const feedbackRow = document.createElement('tr');

                // Add the turn number (or timestamp)
                const turnCell = document.createElement('td');
                turnCell.textContent = new Date().toLocaleTimeString();
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
                feedbackCell.textContent = data.feedback; // Example: "****" or "***+"
                feedbackRow.appendChild(feedbackCell);

                // Append the row to the guesses table
                document.getElementById('guesses').appendChild(feedbackRow);
            }
        }).catch(error => {
            console.error('Error checking guess:', error);
        });
    });

</script>
</body>
</html>
