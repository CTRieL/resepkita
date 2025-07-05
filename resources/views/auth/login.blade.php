@vite('resources/css/app.css')

<div class="min-h-screen flex items-center justify-center bg-primary/5 relative overflow-hidden">
    <div class="absolute inset-0 w-full h-full z-0" style="background-image: url('/images/doodle.png'); background-repeat: repeat; background-size: 340px; opacity: 0.2;"></div>
    <form method="POST" action="/login" class="slide-in-up bg-white p-8 rounded-xl shadow-md w-full max-w-md flex flex-col gap-5 border border-gray-200 z-10">
        @csrf

        <h2 class="text-2xl font-bold text-center text-primary mb-2">Login</h2>
        @if($errors->has('email'))
            <div class="bg-danger/10 text-danger px-4 py-2 rounded mb-2 text-center border-[1px] border-danger">
                {{ $errors->first('email') }}
            </div>
        @endif

        <input name="email" type="email" placeholder="Email" required class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 text-lg" autocomplete="email">
        <input name="password" type="password" placeholder="Password" required class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 text-lg" autocomplete="current-password">
        <button type="submit" class="mt-2 bg-primary text-white font-semibold py-3 rounded-xl hover:bg-primary/90 active:bg-primary transition">Login</button>
        <p class="text-gray-600">Tidak punya akun? Ayo <a href="/register" class="text-primary hover:underline">Register!</a></p>
    </form>
</div>