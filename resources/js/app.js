console.log('works');

import './bootstrap';

document.getElementById("startGame").addEventListener("click", function () {
    fetch('/start-game', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            alert("New game started!");
        })
        .catch(error => console.error('Error:', error));
});

document.getElementById("submitGuess").addEventListener("click", function () {
    const guess = [
        document.getElementById("peg1").value.toLowerCase(),
        document.getElementById("peg2").value.toLowerCase(),
        document.getElementById("peg3").value.toLowerCase(),
        document.getElementById("peg4").value.toLowerCase(),
    ];

    fetch('/check-guess', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ guess }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }

            console.log("Feedback:", data.feedback);
            alert("Feedback: " + data.feedback);

            if (data.answer) {
                alert("You win! The answer was: " + data.answer.join(", "));
            }
        })
        .catch(error => console.error('Error:', error));
});
