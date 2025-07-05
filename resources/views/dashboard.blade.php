@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="w-full flex justify-center items-center py-8">
    <div class="w-[90%] max-w-[800px] flex flex-col justify-center items-center gap-4">
        <button onclick="window.location.href='{{ route('recipe.create') }}'" class="w-full h-[60px] flex items-center justify-center rounded-xl border-[3px] border-dashed border-primary text-primary hover:bg-primary/5 active:bg-primary/10">
            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor"><path d="M440-120v-320H120v-80h320v-320h80v320h320v80H520v320h-80Z"/></svg>
            <p class="font-semibold text-lg"> Upload Resep</p>
        </button>
    </div>
</div>
@endsection