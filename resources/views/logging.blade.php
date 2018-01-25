<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>正在登录中...</title>
</head>
<body>
<h1>{{ $user->nickname }} 登录中...</h1>
<script>
    var expiresIn = {!! $expires_in !!};

    localStorage.setItem('jwt_token', "{!! $access_token !!}");
    localStorage.setItem('expiry_time', new Date().getTime() + expiresIn * 1000);
    
    location.href = '/';
    
</script>
</body>
</html>
