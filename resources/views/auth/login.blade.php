<html>
<head>
    <title>
        Login
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<h1>Login</h1>
<form method="post" action="{{route('login')}}">
    @csrf
    <label>Email</label>
    <input name="email" type="email">

    <label>Password</label>
    <input name="password" type="password">

    <button type="submit">Login</button>
</form>
<div class="danger">
{{Session::get('error')}}
</div>
</body>
</html>
