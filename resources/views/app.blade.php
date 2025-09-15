<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ url("assets/images/favicon.ico") }}">
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    @routes
    @inertiaHead
</head>
<body>
@inertia
</body>
</html>
