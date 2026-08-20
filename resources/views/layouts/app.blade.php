<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Clientes')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 min-h-screen"
      @if (session('success'))
          data-flash-type="success" data-flash-message="{{ session('success') }}"
      @elseif (session('error'))
          data-flash-type="error" data-flash-message="{{ session('error') }}"
      @endif>
    <nav class="bg-white border-b px-6 py-4 flex items-center gap-3">
        @hasSection('back')
            <a href="@yield('back')" title="Voltar" class="text-gray-400 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                    <path fill-rule="evenodd"
                          d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25a.75.75 0 0 1 .75.75Z"
                          clip-rule="evenodd" />
                </svg>
            </a>
        @endif
        <a href="{{ route('clientes.index') }}" class="font-semibold text-lg">@yield('title', 'Clientes')</a>
    </nav>

    <main class="max-w-5xl mx-auto p-6">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>
