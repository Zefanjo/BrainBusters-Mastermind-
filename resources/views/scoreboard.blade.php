<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css','resources/js/app.js')
    <title>Scoreboard | Brain Busters</title>
</head>
<body id="scores">
    <div class="scoreboard">
        @foreach($scores as $score)
        <div class="name">
            Name {{ $score['name'] }}
        </div>
        <div class="score">
            Turns {{ $score['turns'] }}
        </div>
        <div class="won">
            Won {{ $score['won'] }}
        </div>
        <div class="time">
            Time {{ $score['game_time'] }}
        </div>
        @endforeach
    </div>
</body>
</html>