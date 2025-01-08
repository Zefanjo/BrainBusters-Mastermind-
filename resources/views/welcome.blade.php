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
        <div class="buttons"><a href="login">Start</a></div>
        <div class="buttons"><a href="login">Scoreboard</a></div>
        <div class="buttons"><a href="login">Rules</a></div>
        <div class="buttons"><a href="login">Profile</a></div>
    </div>
</div>
</body>
</html>