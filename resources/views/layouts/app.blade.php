<?php
$user = auth()->user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ResepKita')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if(request()->routeIs('dashboard') || request()->routeIs('profile'))
        @vite(['resources/js/dashboard.js'])
    @endif
</head>
<body class="bg-gray-100 min-h-screen flex flex-col font-sans text-gray-800">

    {{-- Header --}}
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/dashboard">
                <h1 class="text-2xl font-bold text-primary transition-all duration-200 hover:scale-105 hover:drop-shadow-[0_0_12px_#10b981A0]">ResepKita</h1>
            </a>
            <nav class="space-x-4">
                @auth
                    <div class="flex items-center">
                        <span class="font-semibold">Mau masak apa hari ini?</span>
                        <a href="/profile" class="flex items-center gap-2 pl-2 pr-3 py-1 hover:bg-gray-200 hover:rounded-md transition-all">
                            <span class="font-semibold">{{ $user ? $user->name : '' }}</span>
                            @if($user && $user->photo_path)
                            <img src="{{ asset('storage/' . $user->photo_path) }}" alt="Foto Profil" class="w-9 h-9 rounded-full object-cover border border-gray-300">
                            @else
                            <span class="w-9 h-9 rounded-full bg-gray-400 font-bold text-gray-600 flex items-center justify-center">
                                {{ $user ? strtoupper(substr($user->name,0,1)) : '' }}
                            </span>
                            @endif
                        </a>
                    </div>
                @else   
                    <a href="{{ route('login') }}" class="text-white bg-primary rounded-md hover:scale-105">Login</a>
                @endauth
            </nav>
        </div>
    </header>


    {{-- Main --}}
    <main class="flex-grow container mx-auto px-2 py-2">
        @yield('content')
        {{-- Popup container --}}
        <div id="popup-container" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
            <div id="popup-content">
                @yield('popup')
            </div>
        </div>
    </main>

    <script>
    // Popup open/close logic (can be used in child views)
    window.showPopup = function() {
        document.getElementById('popup-container').classList.remove('hidden');
    }
    window.hidePopup = function() {
        document.getElementById('popup-container').classList.add('hidden');
    }
    </script>

    {{-- Footer --}}
    <footer class="bg-gray-200 text-center py-4 text-sm text-gray-600">
        &copy; {{ date('Y') }} ResepKita.
    </footer>

</body>
</html>