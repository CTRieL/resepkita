@extends('layouts.app')

@section('title', '403 Unauthorized')

@section('content')
<div class="flex items-center justify-center h-[70vh] slide-in-down">
    <div class="text-center">
        <h1 class="text-6xl font-extrabold text-danger mb-4">403</h1>
        <p class="text-base text-gray-500 mb-6">Ups! Kamu tidak punya izin untuk mengakses halaman ini.</p>
        
        <button href="{{ url('/') }}" class="bg-primary text-white h-4 w-10 rounded hover:bg-primaryS-600 hover:scale-105 transition">
            Kembali ke Beranda
        </button>
    </div>
</div>
@endsection