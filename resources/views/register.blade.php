<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/auth.css','resources/js/auth.js')
    <title>Register | Brain Busters</title>
</head>
<body>

<form method="POST" action="/register">
    <h1 class="top-text">Brain Busters</h1>
    @csrf
    <div class="registreren">
        <div class="form">
        <h2>Register</h2>
            <form method="POST" action="{{ route('register') }}">
                <label for="name"><b>Full Name</b></label>
                <input type="text" name="name" id="name">
                <label for="email"><b>Email</b></label>
                <input type="text" name="email" id="email">
                <label for="psw"><b>Password</b></label>
                <input type="password" name="password" id="psw">
                <label for="psw-repeat"><b>Confirm Password</b></label>
                <input type="password" name="password_confirmation" id="psw-repeat">
                <a href="/dashboard/index">
                    <button type="submit" class="registerbtn">Register</button>
                </a>
            </form>
        </div>
    </div>
    @if($errors->all())
        <div class="errors">
            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        </div>
    @endif
    <div class="container signin">
        <p>Already have an account? <a href="/login">Login</a>.</p>
    </div>
</form>

</body>
</html>