<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Clientes')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen">
    <nav class="bg-white border-b px-6 py-4">
        <a href="{{ route('clientes.index') }}" class="font-semibold text-lg">Clientes</a>
    </nav>

    <main class="max-w-5xl mx-auto p-6">
        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded bg-red-100 text-red-800 px-4 py-2">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
