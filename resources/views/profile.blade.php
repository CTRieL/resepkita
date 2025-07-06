<?php 
$user = auth()->user() 
?>

@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="w-full flex flex-col items-center justify-center pt-4 gap-2">
    <div class="w-[80%] max-w-[1000px] justify-start">  
        <button onclick="history.back()" class="text-gray-600 border-[1px] border-gray-400 rounded-lg px-3 py-2 mb-1 flex items-center justify-cneter pr-1 group hover:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="#999999"><path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/></svg>
            <p class="text-sm text-gray-400 group-hover:text-gray-500 mr-2">Kembali</p>
        </button>
    </div>
    <div class="grid grid-cols-5 gap-[16px] w-[90%] max-w-[1000px]">
        {{-- profile section --}}
        <div class="col-span-2 slide-in-left">
            <div class="text-center flex flex-col gap-3 bg-white shadow-md rounded-lg p-4">
                <div class="relative w-full aspect-square max-w-64 max-h-64 mx-auto group">
                    @if($user && $user->photo_path)
                        <img src="{{ asset('storage/' . $user->photo_path) }}" alt="Foto Profil" class="w-full h-full aspect-square rounded-lg object-cover border border-gray-300 cursor-pointer">
                    @else
                        <span class="w-full h-full aspect-square rounded-lg bg-gray-400 font-bold text-[100px] p-0 text-gray-600 flex items-center justify-center cursor-pointer select-none">
                            {{ $user ? strtoupper(substr($user->name,0,1)) : '' }}
                        </span>
                    @endif
                    <button type="button" onclick="showEditPhotoPopup()" class="absolute inset-0 flex flex-col items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#FFFFFF"><path d="M480-480ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h320v80H200v560h560v-320h80v320q0 33-23.5 56.5T760-120H200Zm40-160h480L570-480 450-320l-90-120-120 160Zm440-320v-80h-80v-80h80v-80h80v80h80v80h-80v80h-80Z"/></svg>
                        <span class="text-white text-lg font-semibold">Ubah Foto Profil</span>
                    </button>
                </div>
                <label class="font-bold text-2xl text-gray-800 ">{{ $user['name'] }}</label>
                <form method="POST" action="{{ route('logout') }}" class="mt-10">
                    @csrf
                    <button type="submit" class="text-base text-danger w-full h-10 bg-danger/5 border-[1px] border-danger text-center rounded-xl hover:bg-danger/10 active:border-[2px]">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        {{-- recipe section --}}
        <div class="col-span-3 flex flex-col gap-4">

            @if($userRecipes && $userRecipes->isNotEmpty())
                <h2 class="text-gray-600 font text-lg">Resep {{ Auth::user()->name }}:</h2>
                <button onclick="window.location.href='{{ route('recipe.create') }}'" class="w-full h-[80px] flex items-center justify-center rounded-xl border-[2px] border-dashed border-primary text-primary hover:bg-primary/5 active:bg-primary/10">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                    <p class="font-semibold text-lg"> Upload Resep</p>
                </button>
                
                <div id="recipe-container" class="w-full flex flex-col gap-4 mt-2">
                    @foreach($userRecipes as $recipe)
                        <x-recipe.card :recipe="$recipe" />
                    @endforeach
                </div>
                @if($userRecipes instanceof \Illuminate\Pagination\LengthAwarePaginator && $userRecipes->hasMorePages())
                    <input type="hidden" id="next-page-url" value="{{ $userRecipes->nextPageUrl() }}">
                @endif

            @else
                <p class="w-full text-center text-gray-600 text-lg">Kamu belum pernah buat resep nih. Ayo buat sekarang!</p>
                <button onclick="window.location.href='{{ route('recipe.create') }}'" class="w-full h-[80px] flex items-center justify-center rounded-xl border-[2px] border-dashed border-primary text-primary hover:bg-primary/5 active:bg-primary/10">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                    <p class="font-semibold text-lg"> Upload Resep</p>
                </button>
            @endif
        </div>
    </div>
</div>
@endsection

@section('popup')
<div id="delete-popup">
    <form id="delete-form" method="POST" action="" class="bg-white rounded-lg shadow-lg p-8 min-w-[320px] flex flex-col items-center">
        <h2 class="text-xl font-bold mb-4 text-danger">Konfirmasi Hapus</h2>
        <p class="mb-6 text-center">Yakin ingin menghapus resep <span id="delete-recipe-title" class="font-semibold"></span>?</p>
        @csrf
        @method('DELETE')
        <div class="flex gap-4 justify-center mt-2">
            <button type="button" onclick="hideDeletePopup()" class="px-4 py-2 border-[2px] border-gray-400 text-gray-500 rounded-lg hover:bg-gray-200">Batal</button>
            <button type="submit" class="px-4 py-2 bg-danger text-white rounded-lg hover:bg-danger/80">Hapus</button>
        </div>
    </form>
</div>
<div id="popup-ubah-foto">
    <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-8 min-w-[320px] relative mb-6">
        @csrf
        <h2 class="text-xl font-bold mb-4">Ubah Foto Profil</h2>
        <div class="col-span-full w-[400px]">
            <label for="cover-photo" class="block text-sm/6 text-gray-900">Masukkan foto profil yang baru</label>
            <div id="drop-area" class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 transition-colors duration-200">
                <div class="text-center">
                    <div id="photo-preview">
                        <svg class="mx-auto text-gray-300" height="80px" width="80px" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="mt-4 flex text-sm/6 text-gray-600 justify-center flex-col">
                        <div class="mt-4 flex justify-center items-center text-sm/6 text-gray-600">
                            <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-primary focus-within:ring-2 focus-within:ring-primaryS-600 focus-within:ring-offset-2 focus-within:outline-hidden hover:text-primaryS-500">
                                <span>Upload a file</span>
                                <input id="file-upload" name="photo" type="file"class="sr-only"  accept=".jpg,.jpeg,.png,.webp" />
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs/5 text-gray-600">PNG, JPG, JPEG up to 2MB</p>
                    </div>
                </div>
            </div>
        <div class="flex gap-4 justify-end mt-4">
            <button type="button" onclick="hideEditPhotoPopup()" class="px-4 py-2 border-[2px] border-gray-400 text-gray-500 rounded-lg hover:bg-gray-200">Cancel</button>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/80">Submit</button>
        </div>
    </form>
</div>
<script>

// show edit photo
window.showEditPhotoPopup = function() {
  const container = document.getElementById('popup-container');
  container.classList.remove('hidden');
  container.classList.add('flex');

  document.getElementById('popup-ubah-foto').classList.remove('hidden');
  document.getElementById('delete-popup').classList.add('hidden');
};

// hide edit photo
window.hideEditPhotoPopup = function() {
  const container = document.getElementById('popup-container');
  container.classList.add('hidden');
  container.classList.remove('flex');

  document.getElementById('popup-ubah-foto').classList.add('hidden');
};

// show delete popup
window.showDeletePopup = function(recipeId, recipeTitle) {
  const container = document.getElementById('popup-container');
  const edit = document.getElementById('popup-ubah-foto');
  const del  = document.getElementById('delete-popup');

  container.classList.remove('hidden');
  container.classList.add('flex');

  edit.classList.add('hidden');
  del.classList.remove('hidden');

  document.getElementById('delete-recipe-title').textContent = recipeTitle;
  document.getElementById('delete-form').action = '{{ route('recipe.destroy', ['recipe' => 'RECIPE_ID']) }}'.replace('RECIPE_ID', recipeId);
};

// hide delete popup
window.hideDeletePopup = function() {
  const container = document.getElementById('popup-container');
  const del       = document.getElementById('delete-popup');

  container.classList.add('hidden');
  container.classList.remove('flex');

  del.classList.add('hidden');
};
</script>
@endsection