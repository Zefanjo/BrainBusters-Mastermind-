<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome | Brain Busters</title>
    @vite('resources/css/app.css','resources/js/app.js')
</head>
<body>
<div class="top-text">
    Hello
    @auth
        {{ auth()->user()->name }}
    @endauth
</div>
<div class="container">
    <div class="button-box">
        <a href="game"><button class="buttons">Start</button></a>
        <a href="scoreboard"><button class="buttons">Scoreboard</button></a>
        <a href="rules"><button class="buttons">Rules</button></a>
        <a href="profile"><button class="buttons">Profile</button></a>
    </div>
</div>
</body>
</html>