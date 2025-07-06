<?php
use Carbon\Carbon;
?>

@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
<div class="flex justify-center items-center min-h-[60vh]">
    <div class="w-full max-w-4xl">
        <div class="relative bg-white rounded-3xl shadow border border-gray-100 flex flex-col gap-2 p-6">
            {{-- Modifier btn --}}
            @php $user = auth()->user(); @endphp
            @if($user && $user->id === $recipe->user_id)
                <div class="absolute top-4 right-4 flex gap-1 z-10">
                    <a href="{{ route('recipe.edit', $recipe->id) }}" class="bg-primary/80 hover:bg-primary hover:scale-105 text-white rounded-full p-1.5 shadow transition" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L7.5 19.788l-4 1 1-4 13.362-13.3Z" /></svg>
                    </a>
                    <button type="button" onclick="showDeletePopup({{ $recipe->id }}, '{{ addslashes($recipe->title) }}')" class="bg-danger/80 hover:bg-danger hover:scale-105 text-white rounded-full p-1.5 shadow transition" title="Hapus">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>
            @endif

            {{-- Profil uploader --}}
            <div class="flex items-center gap-2 mb-2">
                <button onclick="history.back()" class="text-gray-600 border-[1px] border-gray-400 rounded-lg w-8 h-8 mb-1 flex items-center justify-end pr-1 hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="#999999"><path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/></svg>
                </button>
                <p class="flex items-center gap-2 px-3 py-1 transition-all">
                    @if($recipe->user && $recipe->user->photo_path)
                        <img src="{{ asset('storage/' . $recipe->user->photo_path) }}" alt="Foto Profil" class="w-10 h-10 rounded-full object-cover border border-gray-300">
                    @else
                        <span class="w-10 h-10 rounded-full bg-gray-400 font-bold text-gray-600 flex items-center justify-center">
                            {{ $recipe->user ? strtoupper(substr($recipe->user->name,0,1)) : '' }}
                        </span>
                    @endif
                    <div class="flex flex-col">
                        <span class="font-semibold text-base">{{ $recipe->user ? $recipe->user->name : '' }}</span>
                        <span class="text-gray-600 text-xs">{{ $recipe->created_at->format('j M Y H:i') }}</span>
                    </div>
                </p>
            </div>

            <div class="grid grid-cols-7 gap-4 items-center">
                {{-- img section --}}
                <div class="col-span-3 w-full flex gap-4 flex-col h-full items-start">
                    <div class=" w-full aspect-square overflow-hidden flex flex-col items-center justify-center">
                        @if($recipe->photo_path)
                        <img src="{{ asset('storage/' . $recipe->photo_path) }}" alt="{{ $recipe->title }}" class="object-cover w-full h-full rounded-xl">
                        @else
                            <span class="text-6xl text-gray-300 font-bold flex items-center justify-center w-full h-full rounded-xl">?</span>
                        @endif  
                    </div>

                    <h2 class="font-bold text-2xl text-gray-800 mb-1">{{ $recipe->title }}</h2>
                    <p class="text-sm text-gray-800 mb-2">{!! nl2br(e($recipe->description)) !!}</p>
                </div>

                {{-- bahan dan langkah section --}}
                <div class="col-span-4 w-full h-full pl-3 pr-5 flex flex-col gap-2">
                    <div class="mb-2">
                        <label class="text-lg text-gray-800 font-semibold">Bahan-bahan</label>
                        <p class="text-sm text-gray-800">
                            {!! nl2br(e($recipe->ingredients)) !!}
                        </p>
                    </div>
                    <div>
                        <label class="text-lg text-gray-800 font-semibold">Langkah-langkah</label>
                        <p class="text-sm text-gray-800 whitespace-pre-line">{!! nl2br(e($recipe->directions)) !!}</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 mt-4 text-primary justify-end">
                @php
                    $likedType = $user ? $recipe->likedTypeByUser($user->id) : null;
                @endphp
                <button class="like-btn flex flex-row gap-1 items-center transition px-2 py-1 rounded-full border border-primary/30 hover:bg-primary/10 focus:outline-none {{ $likedType === 'thumbs_up' ? 'liked bg-primary/10' : '' }}" data-recipe-id="{{ $recipe->id }}" data-type="thumbs_up" aria-label="Like Thumbs Up">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" width="20" height="20"><path d="M2 21h4V9H2v12zM22 9c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L13.17 1 6.59 7.59C6.22 7.95 6 8.45 6 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1.91l-.01-.01L22 9z"/></svg>
                    <span id="like-count-thumbs_up-{{ $recipe->id }}" class="font-semibold">{{ $recipe->likeCount('thumbs_up') }}</span>
                </button>
        
                <button class="like-btn text-danger/80 flex flex-row gap-1 items-center transition px-2 py-1 rounded-full border border-danger/30 hover:bg-danger/10 focus:outline-none {{ $likedType === 'love' ? 'liked bg-danger/10' : '' }}" data-recipe-id="{{ $recipe->id }}" data-type="love" aria-label="Like Love">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" width="20" height="20"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    <span id="like-count-love-{{ $recipe->id }}" class="font-semibold">{{ $recipe->likeCount('love') }}</span>
                </button>
        
                <button class="like-btn text-accent flex flex-row gap-1 items-center transition px-2 py-1 rounded-full border border-accent/50 hover:bg-accent/20 focus:outline-none {{ $likedType === 'tasty' ? 'liked bg-accent/20' : '' }}" data-recipe-id="{{ $recipe->id }}" data-type="tasty" aria-label="Like Tasty">
                    <img src="{{ asset('images/tasty.png') }}" alt="" width="24" height="24">
                    <span id="like-count-tasty-{{ $recipe->id }}" class="font-semibold">{{ $recipe->likeCount('tasty') }}</span>
                </button>
            </div>

            <div id="comment-section" class="mt-8">
                <h3 class="font-bold text-lg mb-2 text-gray-800">Komentar</h3>
                @auth
                <form id="comment-form" action="{{ route('recipe.comment.store', $recipe->id) }}" method="POST" class="flex gap-2 items-start mb-6">
                    @csrf
                    <div>
                        @if(auth()->user()->photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->photo_path) }}" alt="Foto Profil" class="w-9 h-9 rounded-full object-cover border border-gray-300 mt-1">
                        @else
                            <span class="w-9 h-9 rounded-full bg-gray-400 font-bold text-gray-600 flex items-center justify-center mt-1">
                                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                            </span>
                        @endif
                    </div>
                    <textarea name="message" rows="2" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-primary resize-none" placeholder="Tulis komentar..." required></textarea>
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition">Kirim</button>
                </form>
                @endauth

                <div class="flex flex-col gap-4">
                    @forelse($comments as $comment)
                        <div class="flex gap-3 items-start">
                            @if($comment->user && $comment->user->photo_path)
                                <img src="{{ asset('storage/' . $comment->user->photo_path) }}" alt="Foto Profil" class="w-8 h-8 rounded-full object-cover border border-gray-300 mt-1">
                            @else
                                <span class="w-8 h-8 rounded-full bg-gray-400 font-bold text-gray-600 flex items-center justify-center mt-1">
                                    {{ $comment->user ? strtoupper(substr($comment->user->name,0,1)) : '?' }}
                                </span>
                            @endif
                            <div class="flex flex-col bg-gray-100 rounded-xl px-4 py-2 min-w-0 w-full">
                                <span class="font-semibold text-sm text-gray-800">{{ $comment->user ? $comment->user->name : 'User' }}</span>
                                <span class="text-gray-700 text-sm break-words">{!! nl2br(e($comment->message)) !!}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-gray-500 text-center py-6">Belum ada komentar.</div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $comments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- popup konfirmasi delete --}}
@section('popup')
    <div id="delete-popup" class="bg-white rounded-xl shadow-lg p-6 max-w-sm mx-auto flex flex-col items-center gap-4" style="display:none;">
        <h3 class="font-bold text-lg text-danger">Hapus Resep?</h3>
        <p class="text-gray-700 text-center">Yakin ingin menghapus resep <span class="font-semibold" id="delete-recipe-title"></span>?</p>
        <form id="delete-form" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex gap-2 mt-4">
                <button type="button" onclick="hidePopup()" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 rounded bg-danger text-white hover:bg-danger/90">Hapus</button>
            </div>
        </form>
    </div>
    <script>
        function showDeletePopup(recipeId, recipeTitle) {
            document.getElementById('delete-popup').style.display = 'block';
            document.getElementById('delete-recipe-title').textContent = recipeTitle;
            document.getElementById('delete-form').action = '/recipe/' + recipeId;
            showPopup();
        }
        function hidePopup() {
            document.getElementById('delete-popup').style.display = 'none';
            window.hidePopup();
        }
    </script>
@endsection
@endsection
