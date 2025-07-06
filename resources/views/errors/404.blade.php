@extends('layouts.app')

@section('title', '404 Not Found')

@section('content')
<div class="flex items-center justify-center h-[70vh] slide-in-down">
    <div class="text-center">
        <h1 class="text-6xl font-extrabold text-danger mb-4">404</h1>
        <p class="text-base text-gray-500 mb-6">Ups! Halaman yang kamu cari tidak ditemukan.</p>

        <button onclick="history.back()" class="bg-primary text-white h-10 w-40 rounded hover:bg-primaryS-600 hover:scale-105 transition">
            Kembali
        </button>
    </div>
</div>
@endsection