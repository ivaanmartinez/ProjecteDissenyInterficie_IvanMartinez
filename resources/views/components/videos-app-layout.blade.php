<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Videos App' }}</title>
    @vite('resources/css/app.css')
</head>
<body>
<header>
    <h1>Videos App</h1>
</header>
<main>
    {{ $slot }}
</main>
<footer>
    <p>&copy; {{ date('Y') }} Videos App</p>
</footer>
</body>
</html>
