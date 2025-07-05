<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ResepKita')</title>
    @vite('resources/css/app.css') {{-- Pastikan kamu pakai Vite --}}
</head>
<body class="bg-gray-100 min-h-screen flex flex-col font-sans text-gray-800">

    {{-- Header --}}
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-red-600">🍽️ ResepKita</h1>
            <nav class="space-x-4">
                <a href="/" class="text-gray-700 hover:text-red-500">Beranda</a>
                <a href="/resep" class="text-gray-700 hover:text-red-500">Resep</a>
                @auth
                    <a href="/dashboard" class="text-gray-700 hover:text-red-500">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-500">Logout</button>
                    </form>
                @else
                    {{-- <a href="{{ route('login') }}" class="text-gray-700 hover:text-red-500">Login</a>
                    <a href="{{ url('/register') }}" class="text-gray-700 hover:text-red-500">Daftar</a> --}}
                @endauth
            </nav>
        </div>
    </header>

    {{-- Main --}}
    <main class="flex-grow container mx-auto px-4 py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-200 text-center py-4 text-sm text-gray-600">
        &copy; {{ date('Y') }} ResepKita.
    </footer>

</body>
</html>