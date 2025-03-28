let selectedColor = null;
let filledPegs = [];
let guessCount = 0;
const maxGuesses = 8;
let gameOver = false;
let startTime = null;

document.addEventListener("DOMContentLoaded", function () {
    startNewGame();
});

document.querySelectorAll('.color-peg').forEach(colorPeg => {
    colorPeg.addEventListener('click', function () {
        if (gameOver) {
            alert("Game is over! Please start a new game.");
            return;
        }

        selectedColor = colorPeg.dataset.color;

        const currentRow = document.querySelectorAll('.row')[guessCount];
        if (!currentRow) {
            alert("You've used all your guesses!");
            return;
        }

        const nextEmptyPeg = Array.from(currentRow.querySelectorAll('.pin')).find(peg => !peg.style.backgroundColor);

        if (nextEmptyPeg) {
            nextEmptyPeg.style.backgroundColor = selectedColor;
            filledPegs.push(nextEmptyPeg);
        } else {
            alert('Row is full! Submit your guess or clear the last peg.');
        }
    });
});

document.getElementById('resetBoard').addEventListener('click', function () {
    if (gameOver) return;

    const currentRow = document.querySelectorAll('.row')[guessCount];
    if (!currentRow) return;

    if (filledPegs.length > 0) {
        const lastPeg = filledPegs.pop();
        if (currentRow.contains(lastPeg)) {
            lastPeg.style.backgroundColor = '';
        } else {
            alert('You can only reset the current row!');
        }
    } else {
        alert('No pegs to clear!');
    }
});

document.getElementById('checkGuess').addEventListener('click', function () {
    if (gameOver) return;

    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    if (!csrfTokenMeta) {
        console.error('CSRF token not found.');
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

    let gameTime = Math.floor((Date.now() - startTime) / 1000);

    fetch('/check-guess', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ guess, won: true, game_time: gameTime, turns: guessCount + 1 })
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            if (data.message) {
                alert(data.message);
                gameOver = true;
            }

            const feedbackPins = currentRow.querySelectorAll('.feedback-pin');
            let feedbackArray = data.feedback.split('');
            let assignedIndices = new Set();

            feedbackArray.forEach((symbol, index) => {
                if (symbol === '*') {
                    feedbackPins[index].style.backgroundColor = 'green';
                    assignedIndices.add(index);
                }
            });

            feedbackArray.forEach((symbol, index) => {
                if (symbol === '+' && !assignedIndices.has(index)) {
                    feedbackPins[index].style.backgroundColor = 'yellow';
                    assignedIndices.add(index);
                }
            });

            guessCount++;

            if (guessCount >= maxGuesses) {
                alert('Game over! Maximum attempts reached.');
                gameOver = true;
            }

            filledPegs = [];
        })
        .catch(error => console.error('Error checking guess:', error));
});

function startNewGame() {
    guessCount = 0;
    filledPegs = [];
    gameOver = false;
    startTime = Date.now();

    document.querySelectorAll('.pin').forEach(peg => peg.style.backgroundColor = '');
    document.querySelectorAll('.feedback-pin').forEach(pin => pin.style.backgroundColor = '');

    fetch('/start-game', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })

}

