<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="hisab">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div id="app">
    <App />
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
