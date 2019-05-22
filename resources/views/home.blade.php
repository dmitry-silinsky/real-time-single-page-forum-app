<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Single Page Forum</title>
    <link href="{{ mix('css/app.css', 'build') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <v-app>
            <home></home>
        </v-app>
    </div>

    <script src="{{ mix('js/app.js', 'build') }}"></script>
</body>
</html>