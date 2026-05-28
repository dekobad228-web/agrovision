<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800 font-sans">
    <div class="flex flex-col min-h-screen">

        {{-- Header --}}
        <header class="bg-white shadow-md">
            @include('admin.partials.header')
        </header>

        <div class="flex flex-1">

            {{-- Sidebar --}}
            <aside class="w-64 bg-gray-800 text-gray-100 flex-shrink-0">
                @include('admin.partials.sidebar')
            </aside>

            {{-- Main content --}}
            <main class="flex-1 p-6 overflow-auto">
                @yield('content')
            </main>
        </div>

        {{-- Footer --}}
        <footer class="bg-white shadow-inner p-4 text-center text-gray-500 text-sm">
            @include('admin.partials.footer')
        </footer>
    </div>
</body>

</html>