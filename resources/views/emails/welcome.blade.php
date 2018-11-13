<!DOCTYPE html>
<html>
<head>
    <title>{{ __('translate.welcome') }} {{ $user->name }} {{ __('translate.toWeb') }}</title>
</head>
<body>
    <p>{{ __('translate.login') }}: <a href="{{ $link = route('login') }}">{{ $link }}</a></p>
</body>
</html>
