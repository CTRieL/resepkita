@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="w-full flex justify-center items-center py-8">
    <div class="w-[90%] max-w-[1000px] flex flex-col justify-center items-center gap-4">
        <form method="GET" action="{{ route('dashboard') }}" class="w-full flex gap-2 mb-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul resep atau bahan..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30">
            <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition">Search</button>
        </form>
        <button onclick="window.location.href='{{ route('recipe.create') }}'" class="w-full h-[60px] flex items-center justify-center rounded-xl border-[2px] border-dashed border-primary text-primary hover:bg-primary/5 active:bg-primary/10">
            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
            <p class="font-semibold text-lg"> Upload Resep</p>
        </button>
        <div id="recipe-container" class="w-full flex flex-col gap-4 mt-6">
            @forelse($recipes as $recipe)
                <x-recipe.card :recipe="$recipe" />
            @empty
                <p class="col-span-full text-center text-gray-500 text-lg">Tidak ada resep ditemukan.</p>
            @endforelse
        </div>
        @if($recipes->hasMorePages())
            <input type="hidden" id="next-page-url" value="{{ $recipes->nextPageUrl() }}">
        @endif
    </div>
</div>
@endsection

@section('popup')
    <div id="delete-popup" class="hidden">
        <div class="bg-white rounded-lg shadow-lg p-8 min-w-[320px] relative flex flex-col items-center">
            <h2 class="text-xl font-bold mb-4 text-danger">Konfirmasi Hapus</h2>
            <p class="mb-6 text-center">Yakin ingin menghapus resep <span id="delete-recipe-title" class="font-semibold"></span>?</p>
            <form id="delete-form" method="POST" action="" class="w-full flex flex-col items-center gap-2">
                @csrf
                @method('DELETE')
                <div class="flex gap-4 justify-end mt-2">
                    <button type="button" onclick="hideDeletePopup()" class="px-4 py-2 border-[2px] border-gray-400 text-gray-500 rounded-lg hover:bg-gray-200">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-danger text-white rounded-lg hover:bg-danger/80">Hapus</button>
                </div>
            </form>
        </div>
    </div>
    <script>
    window.showDeletePopup = function(recipeId, recipeTitle) {
        document.getElementById('popup-container').classList.remove('hidden');
        document.getElementById('delete-popup').classList.remove('hidden');
        document.getElementById('delete-recipe-title').textContent = recipeTitle;
        const form = document.getElementById('delete-form');
        form.action = `/recipe/${recipeId}`;
    }
    window.hideDeletePopup = function() {
        document.getElementById('popup-container').classList.add('hidden');
        document.getElementById('delete-popup').classList.add('hidden');
        document.getElementById('delete-recipe-title').textContent = '';
        document.getElementById('delete-form').action = '';
    }
    </script>
@endsection