@extends('layouts.app')

@section('title', 'Buat Resep Baru')

@section('content')
<div class="w-full flex justify-center items-center py-8">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-4xl border border-gray-100">
        <div class="flex gap-2 items-center">
            <button onclick="history.back()" class="text-gray-600 border-[1px] border-gray-400 rounded-lg w-6 h-6 mb-1 flex items-center justify-end hover:bg-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="#999999"><path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/></svg>
            </button>
            <h2 class="text-2xl font-bold text-primary mb-2">Edit Resep</h2>
        </div>
        @if($errors->any())
            <div class="bg-danger/10 text-danger px-4 py-2 rounded mb-2 text-center border border-danger">
                <div class="list-disc list-inside text-center inline-block">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif
        <form method="POST" action="{{ route('recipe.update', $recipe->id) }}" enctype="multipart/form-data" class="grid grid-cols-5 gap-8">
            @csrf
            @method('PUT')
            <div class="col-span-2 flex flex-col gap-4">
                <label for="cover-photo" class="block text-base font-semibold text-gray-900 mb-1">Masukkan Foto Resep</label>
                <div id="drop-area" class="flex justify-center rounded-lg p-4 pb-8 border border-dashed border-primary/40 transition-colors duration-200 bg-primary/5">
                    <div class="text-center w-full flex justify-center items-center flex-col">
                        <div id="photo-preview" class="w-[80%] aspect-square flex justify-center items-center">
                            @if($recipe->photo_path)
                                <img src="{{ asset('storage/' . $recipe->photo_path) }}" alt="Foto Resep" class="mx-auto rounded-lg object-cover max-h-32 max-w-32 border border-gray-200" />
                            @else
                                <svg class="mt-10 text-gray-300" height="80px" width="80px" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex flex-col items-center mt-4 gap-1">
                            <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-primary focus-within:ring-2 focus-within:ring-primary-600 focus-within:ring-offset-2 focus-within:outline-hidden hover:text-primary-500 px-4 py-2 border border-primary/30 shadow-sm">
                                <span>Upload a file</span>
                                <input id="file-upload" name="photo" type="file" class="sr-only" accept=".jpg,.jpeg,.png,.webp" />
                            </label>
                            <span class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-3 flex flex-col gap-4">
                <div class="grid grid-cols-2 gap-4 cursor-default">
                    <div>
                        <input type="radio" id="private" name="privacy" value="private" class="accent-primary mr-2 cursor-pointer" @checked(old('privacy', $recipe->privacy) == 'private')>
                        <label for="private" class="font-medium cursor-pointer">Private</label>
                        <p class="text-xs text-gray-500">Hanya anda yang dapat melihat resep ini</p>
                    </div>
                    <div>
                        <input type="radio" id="public" name="privacy" value="public" class="accent-primary mr-2 cursor-pointer" @checked(old('privacy', $recipe->privacy) == 'public')>
                        <label for="public" class="font-medium cursor-pointer">Public</label>
                        <p class="text-xs text-gray-500">Resep ini dapat dilihat oleh orang lain</p>
                    </div>
                </div>
                <label class="font-semibold mt-2">Judul Resep</label>
                <input name="title" type="text" value="{{ old('title', $recipe->title) }}" class="block w-full py-2 px-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/40">

                <label class="font-semibold mt-2">Deskripsi</label>
                <textarea name="description" rows="2" class="block w-full py-2 px-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/40">{{ old('description', $recipe->description) }}</textarea>
                
                <label class="font-semibold mt-2">Bahan-Bahan</label>
                <textarea name="ingredients" rows="3" class="block w-full py-2 px-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/40">{{ old('ingredients', $recipe->ingredients) }}</textarea>
                
                <label class="font-semibold mt-2">Langkah-Langkah</label>
                <textarea name="directions" rows="4" class="block w-full py-2 px-3 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/40">{{ old('directions', $recipe->directions) }}</textarea>
                
                <button type="submit" class="mt-6 bg-primary text-white font-semibold py-3 rounded-xl hover:bg-primary/90 transition text-base shadow">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection