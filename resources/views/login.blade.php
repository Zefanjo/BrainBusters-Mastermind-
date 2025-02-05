<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/auth.css','resources/js/auth.js')
    <title>Login | Brain Busters</title>
</head>
<body>

<form action="" method="post" class="login">
    <h1 class="top-text">Brain Busters</h1>
    @csrf
    <h2>Login</h2>
    <form method="POST" action="{{ route('login') }}">
        <label for="email">E-mail</label>
        <input type="text" placeholder="E-mail" size="30" id="email" name="email" required>
        <label for="password">Password</label>
        <input type="password" placeholder="Password" size="30" id="password" name="password" required>
        <label>
            <input type="checkbox" name="remember"> Remember me
        </label><br>
        <button type="submit" class="registerbtn" >Login</button>
    </form>
    <a href="/dashboard">
    </a>
    @if($errors->all())
        <div class="errors">
            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        </div>
    @endif
    <div class="container signin">
        <p>Don't have an acccount yet? <a href="/register">Register</a>.</p>
    </div>
</form>
</body>
</html>