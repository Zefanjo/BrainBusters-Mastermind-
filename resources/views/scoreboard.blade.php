<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scoreboard</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: lightgray;
        }
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
@vite('resources/css/auth.css','resources/js/auth.js')
<body>
<h1 style="text-align:center;">Scoreboard</h1>
<table>
    <thead>
    <tr>
        <th>Rank</th>
        <th>User</th>
        <th>Turns</th>
        <th>Result</th>
        <th>Game Time</th>
    </tr>
    </thead>
    <tbody id="scoreboard-body">
    @foreach ($topScores as $index => $score)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $score->user_id ? 'User ' . $score->user_id : 'Guest' }}</td>
            <td>{{ $score->turns }}</td>
            <td>{{ $score->won ? 'Won' : 'Lost' }}</td>
            <td>{{ $score->game_time }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    function fetchScores() {
        fetch('/scoreboard-data')
            .then(response => response.json())
            .then(data => {
                // Sort scores by the lowest number of turns (best scores)
                data.sort((a, b) => a.turns - b.turns);

                let tbody = document.getElementById("scoreboard-body");
                tbody.innerHTML = ""; // Clear existing rows

                data.slice(0, 10).forEach((score, index) => {
                    let row = `<tr>
                            <td>${index + 1}</td>
                            <td>${score.user_id ? 'User ' + score.user_id : 'Guest'}</td>
                            <td>${score.turns}</td>
                            <td>${score.won ? 'Won' : 'Lost'}</td>
                            <td>${score.game_time}</td>
                        </tr>`;
                    tbody.innerHTML += row;
                });
            });
    }

    setInterval(fetchScores, 5000); // Refresh scores every 5 seconds
</script>
</body>
</html>
