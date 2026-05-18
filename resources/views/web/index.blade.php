<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title', $currentPage->title ?? 'AgroVision')
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="{{ $currentPage?->theme?->value ?? null }}">
    @include('web.partials.header', [
        'menuPages' => $menuPages ?? collect(),
        'currentPage' => $currentPage ?? null,
    ])

    @include('web.partials.menu', [
        'menuPages' => $menuPages ?? collect(),
        'currentPage' => $currentPage ?? null,
    ])

    <main>
        @yield('content')
    </main>

    @include('web.partials.footer')

</body>

</html>
