let selectedColor = null;
const filledPegs = []; // Stack to track the order of filled pegs
let guessCount = 0; // Counter for the number of guesses
const maxGuesses = 6; // Maximum allowed guesses

// Start Game Function
document.addEventListener("DOMContentLoaded", function () {
    fetch('/start-game', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => {
            console.log("Generated Code:", data.answer); // Debugging
        })
        .catch(error => console.error('Error starting game:', error));
});


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
    const guess = Array.from(document.querySelectorAll('.peg')).map(peg => peg.style.backgroundColor || null);

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
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            if (data.message) {
                alert(data.message); // E.g., "You win!"
            }

            // Display feedback in the table
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
                    feedbackIndicator.style.backgroundColor = 'yellow'; // Correct color, wrong position
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
        })
        .catch(error => {
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
    guessCount = 0; // Reset the guess count
    clearBoard(); // Clear the board
    document.getElementById('guesses').innerHTML = ''; // Clear the feedback table
    alert('The game is restarting! Click "Start Game" to play again.');
}
