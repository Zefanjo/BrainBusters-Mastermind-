let selectedColor = null;
let filledPegs = []; // Tracks the order of filled pegs per row
let guessCount = 0; // Keeps track of how many guesses have been made
const maxGuesses = 8; // Max number of allowed guesses

document.addEventListener("DOMContentLoaded", function () {
    fetch('/start-game', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => console.log("Generated Code:", data.answer)) // Debugging
        .catch(error => console.error('Error starting game:', error));
});

// Handle color selection
document.querySelectorAll('.color-peg').forEach(colorPeg => {
    colorPeg.addEventListener('click', function () {
        selectedColor = colorPeg.dataset.color;

        // Get the current row to fill
        const currentRow = document.querySelectorAll('.row')[guessCount];
        if (!currentRow) {
            alert("You've used all your guesses!");
            return;
        }

        // Find the next empty peg in the current row
        const nextEmptyPeg = Array.from(currentRow.querySelectorAll('.pin')).find(peg => !peg.style.backgroundColor);

        if (nextEmptyPeg) {
            nextEmptyPeg.style.backgroundColor = selectedColor;
            filledPegs.push(nextEmptyPeg); // Track for reset
        } else {
            alert('Row is full! Submit your guess or clear the last peg.');
        }
    });
});

// Clear the last filled peg
document.getElementById('resetBoard').addEventListener('click', function () {
    if (filledPegs.length > 0) {
        const lastPeg = filledPegs.pop();
        lastPeg.style.backgroundColor = ''; // Clear peg color
    } else {
        alert('No pegs to clear!');
    }
});

// Handle guess submission
document.getElementById('checkGuess').addEventListener('click', function () {
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfTokenMeta) {
        console.error('CSRF token not found in meta tags.');
        alert('CSRF token is missing. Please refresh the page.');
        return;
    }

    const csrfToken = csrfTokenMeta.getAttribute('content');

    const currentRow = document.querySelectorAll('.row')[guessCount];
    if (!currentRow) return;

    const pegs = Array.from(currentRow.querySelectorAll('.pin'));
    const guess = pegs.map(peg => peg.style.backgroundColor || null);

    if (guess.includes(null)) {
        alert('Fill all pegs before submitting.');
        return;
    }

    fetch('/check-guess', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
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
                alert(data.message); // "You win!" or similar
            }

            // Display feedback
            const feedbackPins = currentRow.querySelectorAll('.feedback-pin');
            data.feedback.split('').forEach((symbol, index) => {
                if (symbol === '*') {
                    feedbackPins[index].style.backgroundColor = 'green'; // Correct spot
                } else if (symbol === '+') {
                    feedbackPins[index].style.backgroundColor = 'orange'; // Correct color, wrong spot
                }
            });

            guessCount++;

            if (guessCount >= maxGuesses) {
                alert('Game over! Maximum attempts reached.');
                resetGame();
            }
        })
        .catch(error => console.error('Error checking guess:', error));
});


function resetGame() {
    guessCount = 0;
    filledPegs = [];
    document.querySelectorAll('.pin').forEach(peg => peg.style.backgroundColor = '');
    document.querySelectorAll('.feedback-pin').forEach(pin => pin.style.backgroundColor = '');

    fetch('/start-game', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => console.log("New Generated Code:", data.answer))
        .catch(error => console.error('Error resetting game:', error));
}
