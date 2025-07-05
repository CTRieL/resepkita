@extends('layouts.app')

@section('title', '404 Not Found')

@section('content')
<div class="flex items-center justify-center h-[70vh]">
    <div class="text-center">
        <h1 class="text-6xl font-extrabold text-red-600 mb-4">404</h1>
        <p class="text-xl text-gray-700 mb-6">Ups! Halaman yang kamu cari tidak ditemukan.</p>
        <a href="{{ url('/') }}" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection