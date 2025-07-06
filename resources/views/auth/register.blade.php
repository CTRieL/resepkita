@vite('resources/css/app.css')

<div class="min-h-screen flex items-center justify-center bg-primary/5 relative overflow-hidden">
    <div class="absolute inset-0 w-full h-full z-0" style="background-image: url('/images/doodle.png'); background-repeat: repeat; background-size: 340px; opacity: 0.2;"></div>
    <form method="POST" action="/register" class="slide-in-up bg-white p-8 rounded-xl shadow-md w-full max-w-md flex flex-col gap-5 border border-gray-200 z-10">
        @csrf
        
        <h2 class="text-2xl font-bold text-center text-primary mb-2">Register</h2>
        @if($errors->any())
            <div class="bg-danger/10 text-danger px-4 py-2 rounded mb-2 text-center border-[1px] border-danger">
                <div class="list-disc list-inside text-left inline-block">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <input name="name" type="text" placeholder="Name" required value="{{ old('name') }}" class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 text-lg" autocomplete="name">

        <input name="email" type="email" placeholder="Email" required value="{{ old('email') }}" class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 text-lg" autocomplete="email">

        <input name="password" type="password" placeholder="Password" required class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 text-lg" autocomplete="new-password">

        <input name="password_confirmation" type="password" placeholder="Confirm Password" required class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 text-lg" autocomplete="new-password">

        <button type="submit" class="mt-2 bg-primary text-white font-semibold py-3 rounded-xl hover:bg-primary/90 transition">Register</button>

        <p class="text-gray-600">Sudah punya akun? Ayo <a href="/login" class="text-primary hover:underline">Login!</a></p>
    </form>
</div>