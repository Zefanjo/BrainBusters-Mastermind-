<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css','resources/js/auth.js')
    <title>Profile | Brain Busters</title>
</head>
<body>
<div class="login">
    <h1 class="top-text">Brain Busters</h1>
    @csrf
    <h2>Profile
        @auth
            {{ auth()->user()->name }}
        @endauth
    </h2>
    <form action="{{ route('profile.update') }}" method="post" class="editform">
        @csrf
        @method('put')
        <label for="name">Change Username:</label>
        <input type="text" name="name" placeholder="Username" required>
        <label for="password">Change Password:</label>
        <input type="password" name="password" placeholder="New Password" required>
        <button type="submit">Save</button>
    </form>

    <form METHOD="POST" action="{{route("logout")}}">
        @csrf
        <button class="custom-button">Logout</button>
    </form>
        @if($errors->all())
        <div class="errors">
            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        </div>
    @endif
</div>
</body>
</html>