@extends('layouts.app')

@section('title', 'Buat Resep Baru')

@section('content')
<h1>Edit Post Resep</h1>
<form method="POST" action="">  
    <label>Privacy:</label><br>
    <input type="radio" id="private" name="privacy" value="private" checked>
    <label for="private">Private</label>
    <input type="radio" id="public" name="privacy" value="public">
    <label for="public">Public</label><br>
    
    <label>Judul Resep</label><br>
    <input name="title" type="text" class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-dashed sm:text-sm/6"><br>

    <label>Bahan-Bahan</label><br>
    <input name="ingredients" type="text"><br>
    
    <label>Langkah-Langkah</label><br>
    <input name="directions" type="text"><br>

    <label>Masukkan Foto</label>
    <input name="photo_path" type="file" accept=".jpg, .jpeg, .webp, .png">
</form>
@endsection