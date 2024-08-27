<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config("app.name") }}</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.svg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <meta name="kadam-verification" content="kadam92f488dcd397d7661609116020ae70cd" />
    <meta name="google-site-verification" content="9olAR0iGm3JZXhSKgL49tQw_UPrq0FUYm8m0IKonZj0" />
    
    @viteReactRefresh
    @vite(['resources/react/index.jsx', 'resources/css/app.css'])

</head>
<body>
<div id="app"></div>
</body>
</html>
