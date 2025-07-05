<?php 
$user = auth()->user() 
?>

@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
<div class="w-full flex items-center justify-center pt-6">
    <div class="grid grid-cols-5 gap-[16px] w-[90%] max-w-[800px]">
        <div class="col-span-2 text-center flex flex-col gap-3">
            <div class="relative w-full aspect-square max-w-64 max-h-64 mx-auto group">
                @if($user && $user->photo_path)
                    <img src="{{ asset('storage/' . $user->photo_path) }}" alt="Foto Profil" class="w-full h-full aspect-square rounded-lg object-cover border border-gray-300 cursor-pointer">
                @else
                    <span class="w-full h-full aspect-square rounded-lg bg-gray-400 font-bold text-[100px] p-0 text-gray-600 flex items-center justify-center cursor-pointer select-none">
                        {{ $user ? strtoupper(substr($user->name,0,1)) : '' }}
                    </span>
                @endif
                <button type="button" onclick="showPopup()" class="absolute inset-0 flex flex-col items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#FFFFFF"><path d="M480-480ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h320v80H200v560h560v-320h80v320q0 33-23.5 56.5T760-120H200Zm40-160h480L570-480 450-320l-90-120-120 160Zm440-320v-80h-80v-80h80v-80h80v80h80v80h-80v80h-80Z"/></svg>
                    <span class="text-white text-lg font-semibold">Ubah Foto Profil</span>
                </button>
            </div>
            <label class="font-bold text-2xl text-gray-800 ">{{ $user['name'] }}</label>
        </div>
        <div class="col-span-3 flex flex-col gap-4">
            @if($userRecipes && $userRecipes->isNotEmpty())

                <h2 class="text-gray-600 font-semibold text-lg">Resepku:</h2>
                <button class="w-full h-[80px] flex items-center justify-center rounded-xl border-[3px] border-dashed border-primary text-primary hover:bg-primary/5 active:bg-primary/10">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                    <p class="font-semibold text-lg">Tambah Resep</p>
                </button>
                
                @foreach($userRecipes as $recipe)
                    <div class="p-4 bg-white rounded shadow border border-gray-100 mb-2">
                        <div class="font-semibold text-lg text-gray-800">{{ $recipe->title }}</div>
                        <div class="text-gray-500 text-sm">{{ $recipe->created_at->format('d M Y') }}</div>
                    </div>
                @endforeach
            @else   
                <p class="w-full text-center text-gray-600 text-lg">Kamu belum pernah buat resep nih. Ayo buat sekarang!</p>
                <button class="w-full h-[80px] flex items-center justify-center rounded-xl border-[3px] border-dashed border-primary text-primary hover:bg-primary/5 active:bg-primary/10">
                    <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
                    <p class="font-semibold text-lg">Tambah Resep</p>
                </button>
            @endif
        </div>
    </div>
</div>
@endsection

@section('popup')
<form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow-lg p-8 min-w-[320px] relative">
    @csrf
    <h2 class="text-xl font-bold mb-4">Ubah Foto Profil</h2>
    <div class="col-span-full mb-4 w-[400px]">
        <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Cover photo</label>
        <div id="drop-area" class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 transition-colors duration-200">
            <div class="text-center">
                <div id="photo-preview">
                    <svg class="mx-auto text-gray-300" height="80px" width="80px" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="mt-4 flex text-sm/6 text-gray-600 justify-center flex-col">
                    <div class="mt-4 flex text-sm/6 text-gray-600">
                        <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-primary focus-within:ring-2 focus-within:ring-primaryS-600 focus-within:ring-offset-2 focus-within:outline-hidden hover:text-primaryS-500">
                            <span>Upload a file</span>
                            <input id="file-upload" name="photo" type="file"class="sr-only"  accept=".jpg,.jpeg,.png,.webp" />
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                </div>
            </div>
        </div>
</form>
<script>
// Drag & drop + preview
const dropArea = document.getElementById('drop-area');
const fileInput = document.getElementById('file-upload');
const preview = document.getElementById('photo-preview');

if (dropArea && fileInput && preview) {
    // Highlight on drag    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
            dropArea.classList.add('bg-primary/10');
        });
    });
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
            dropArea.classList.remove('bg-primary/10');
        });
    });
    // Handle drop
    dropArea.addEventListener('drop', e => {
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            fileInput.files = e.dataTransfer.files;
            showPreview(fileInput.files[0]);
        }
    });
    // Handle file input change
    fileInput.addEventListener('change', e => {
        if (fileInput.files && fileInput.files[0]) {
            showPreview(fileInput.files[0]);
        }
    });
    function showPreview(file) {
        if (!file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="mx-auto rounded-lg object-cover max-h-32 max-w-32 border border-gray-200" />`;
        };
        reader.readAsDataURL(file);
    }
}
</script>
    <div class="flex gap-4 justify-end mt-4">
        <button type="button" onclick="hidePopup()" class="px-4 py-2 border-[2px] border-gray-400 text-gray-500 rounded-lg hover:bg-gray-200">Cancel</button>
        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/80">Submit</button>
    </div>
</form>
@endsection