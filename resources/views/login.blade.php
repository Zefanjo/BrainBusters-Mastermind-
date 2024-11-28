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
    <label for="email"><b>Email</b></label>
    <input type="text" name="email" id="email">
    <label for="psw"><b>Password</b></label>
    <input type="password" name="password" id="psw">
    <label>
        <input type="checkbox" name="remember"> Remember me
    </label><br>
    <a href="/dashboard">
        <button type="submit" class="registerbtn" >Login</button>
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